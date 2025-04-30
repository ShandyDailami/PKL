<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\Inventaris as ModelsInventaris;
use App\Models\Jenis;
use App\Models\Kondisi;
use App\Models\Status;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Inventaris extends BaseController
{
    public function perangkatJaringanUser()
    {
        $model = new ModelsInventaris();
        $keyword = $this->request->getPost('keyword');
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 1);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('inventaris.tempat', $keyword)
                ->orLike('inventaris.lantai', $keyword)
                ->groupEnd();
        }
        $data = [
            'title' => 'Perangkat Jaringan',
            'devices' => $query->paginate(5),
            'pager' => $model->pager,
            'keyword' => $keyword,
        ];
        return view('user/network-device', $data);
    }
    public function inventarisUser()
    {
        $model = new ModelsInventaris();
        $keyword = $this->request->getPost('keyword');
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 2);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('inventaris.tempat', $keyword)
                ->orLike('inventaris.lantai', $keyword)
                ->groupEnd();
        }
        $data = [
            'title' => 'Inventaris',
            'items' => $query->paginate(5),
            'pager' => $model->pager,
            'keyword' => $keyword,
        ];
        return view('user/item', $data);
    }

    public function perangkatJaringanAdmin()
    {
        $model = new ModelsInventaris();
        $keyword = $this->request->getPost('keyword');
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 1);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('inventaris.tempat', $keyword)
                ->orLike('inventaris.lantai', $keyword)
                ->groupEnd();
        }
        $data = [
            'title' => 'Perangkat Jaringan',
            'devices' => $query->paginate(5),
            'pager' => $model->pager,
            'keyword' => $keyword,
        ];
        return view('admin/network-device/dashboard', $data);
    }
    public function inventarisAdmin()
    {
        $model = new ModelsInventaris();
        $keyword = $this->request->getPost('keyword');
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 2);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('inventaris.tempat', $keyword)
                ->orLike('inventaris.lantai', $keyword)
                ->groupEnd();
        }
        $data = [
            'title' => 'Inventaris',
            'items' => $query->paginate(5),
            'pager' => $model->pager,
            'keyword' => $keyword,
        ];
        return view('admin/item/dashboard', $data);
    }

    public function get_devices()
    {
        $model = new ModelsInventaris();
        return $this->response->setJSON($model->where('kondisi_id', '1')->findAll());
    }

    public function halamanImport()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/inventaris/importTambah', ['title' => 'Perangkat Jaringan - Tambah']);
        }
    }

    public function importExcel()
    {
        $file = $this->request->getFile('file_excel');

        if ($file && $file->isValid()) {
            $ext = $file->getClientExtension();
            if (!in_array($ext, ['xls', 'xlsx'])) {
                return redirect()->back()->with('error', 'Hanya file Excel (.xls, .xlsx) yang diperbolehkan.');
            }

            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            $header = array_shift($rows);

            $inventarisModel = new ModelsInventaris();

            foreach ($rows as $row) {
                $data = [
                    'tempat' => $row['A'] ?? null,
                    'jenis_id' => $row['B'] ?? null,
                    'tipe' => $row['C'] ?? null,
                    'nama' => $row['D'] ?? null,
                    'password' => $row['E'] ?? null,
                    'gambar' => $row['F'] ?? null,
                    'kondisi_id' => $row['G'] ?? null,
                    'status_id' => $row['H'] ?? null,
                    'kuantitas' => $row['I'] ?? null,
                    'latitude' => isset($row['J']) ? (string) $row['J'] : null,
                    'longitude' => isset($row['K']) ? (string) $row['K'] : null,
                    'lantai' => $row['L'] ?? null,
                ];

                if (empty($data['nama']) || empty($data['jenis_id'])) {
                    continue;
                }

                $exists = $inventarisModel
                    ->where('nama', $data['nama'])
                    ->where('tempat', $data['tempat'])
                    ->countAllResults();

                if ($exists == 0) {
                    $inventarisModel->insert($data);
                }
            }

            if ($data['kondisi_id'] === '1') {
                return redirect()->to('/admin/dashboard/perangkat-jaringan/')->with('message', 'Import data berhasil!');
            } else {
                return redirect()->to('/admin/dashboard/inventaris/')->with('message', 'Import data berhasil!');
            }

        } else {
            return redirect()->back()->with('error', 'File tidak valid.');
        }
    }


    public function exportPerangkatPDF()
    {
        $model = new ModelsInventaris();
        $data = [
            'devices' => $model->dataJoin()->where('inventaris.kondisi_id', 1)->findAll(),
            'title' => 'Perangkat Jaringan - Export PDF',
        ];
        $dompdf = new Dompdf();

        $html = view('admin/network-device/pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setContentType('application/pdf')
            ->setBody($dompdf->output());
    }

    public function exportInventarisPDF()
    {
        $model = new ModelsInventaris();
        $data = [
            'items' => $model->dataJoin()->where('inventaris.kondisi_id', 2)->findAll(),
            'title' => 'Inventaris - Export PDF',
        ];
        $dompdf = new Dompdf();

        $html = view('admin/item/pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setContentType('application/pdf')
            ->setBody($dompdf->output());
    }

    public function halamanTambah()
    {
        $modelKondisi = new Kondisi();
        $modelJenis = new Jenis();
        $modelStatus = new Status();
        $data = [
            'title' => 'Perangkat Jaringan - Tambah',
            'conditions' => $modelKondisi->findAll(),
            'types' => $modelJenis->findAll(),
            'statuses' => $modelStatus->findAll(),
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/inventaris/tambah', $data);
        }
    }

    public function halamanUpdate($id)
    {
        $modelKondisi = new Kondisi();
        $modelJenis = new Jenis();
        $modelStatus = new Status();
        $model = new ModelsInventaris();
        $data = [
            'title' => 'Perangkat Jaringan - Edit',
            'inventaris' => $model->find($id),
            'conditions' => $modelKondisi->findAll(),
            'types' => $modelJenis->findAll(),
            'statuses' => $modelStatus->findAll(),
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/inventaris/update', $data);
        }
    }

    public function tambah()
    {
        helper('form');

        $jenis = $this->request->getPost('jenis_id');

        $rules = [
            'tempat' => [
                'rules' => 'required',
                'errors' => ['required' => 'Tempat harus diisi'],
            ],
            'jenis_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jenis harus diisi'],
            ],
            'tipe' => [
                'rules' => 'required',
                'errors' => ['required' => 'Tipe harus diisi'],
            ],
            'gambar' => [
                'rules' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]',
                'errors' => [
                    'uploaded' => 'Gambar harus diupload',
                    'is_image' => 'File harus berupa gambar yang valid(jpg, png, gif).',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
                ],
            ],
            'kondisi_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kondisi harus diisi'],
            ],
            'status_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Status harus diisi'],
            ],
            'kuantitas' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kuantitas harus diisi'],
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => ['required' => 'Latitude harus diisi'],
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => ['required' => 'Longitude harus diisi'],
            ],
            'lantai' => [
                'rules' => 'required',
                'errors' => ['required' => 'Lantai harus diisi'],
            ],
        ];

        if (in_array($jenis, ['3'])) {
            $rules['nama'] = [
                'rules' => 'required',
                'errors' => ['required' => 'Nama Perangkat harus diisi'],
            ];
            $rules['password'] = [
                'rules' => 'required',
                'errors' => ['required' => 'Password Perangkat harus diisi'],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('gambar');
        $filename = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/', $filename);

        if (in_array($jenis, ['1', '2'])) {
            $nama = '-';
            $password = '-';
        } else {
            $nama = $this->request->getPost('nama');
            $password = $this->request->getPost('password');
        }

        $model = new ModelsInventaris();
        $model->save([
            'kondisi_id' => $this->request->getPost('kondisi_id'),
            'jenis_id' => $this->request->getPost('jenis_id'),
            'tipe' => $this->request->getPost('tipe'),
            'nama' => $nama,
            'password' => $password,
            'gambar' => $filename,
            'tempat' => $this->request->getPost('tempat'),
            'status_id' => $this->request->getPost('status_id'),
            'kuantitas' => $this->request->getPost('kuantitas'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'lantai' => $this->request->getPost('lantai'),
        ]);


        return redirect()->to('admin/dashboard/perangkat-jaringan')->with('message', 'Data berhasil dibuat');
    }

    public function update($id)
    {
        helper('form');
        $model = new ModelsInventaris();
        $perangkat = $model->find($id);
        $jenis = $this->request->getPost('jenis_id');
        $kondisi = $this->request->getPost('kondisi_id');

        $rules = [
            'tempat' => [
                'rules' => 'required',
                'errors' => ['required' => 'Tempat harus diisi'],
            ],
            'jenis_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jenis harus diisi'],
            ],
            'tipe' => [
                'rules' => 'required',
                'errors' => ['required' => 'Tipe harus diisi'],
            ],
            'gambar' => [
                'rules' => 'permit_empty|is_image[gambar]|max_size[gambar,1024]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar yang valid(jpg, png, gif).',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
                ],
            ],
            'kondisi_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kondisi harus diisi'],
            ],
            'status_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Status harus diisi'],
            ],
            'kuantitas' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kuantitas harus diisi'],
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => ['required' => 'Latitude harus diisi'],
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => ['required' => 'Longitude harus diisi'],
            ],
            'lantai' => [
                'rules' => 'required',
                'errors' => ['required' => 'Lantai harus diisi'],
            ],
        ];

        if (in_array($jenis, ['3'])) {
            $rules['nama'] = [
                'rules' => 'required',
                'errors' => ['required' => 'Nama Perangkat harus diisi'],
            ];
            $rules['password'] = [
                'rules' => 'required',
                'errors' => ['required' => 'Password Perangkat harus diisi'],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('gambar');

        $filename = $perangkat['gambar'];

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $filename = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/', $filename);

            if ($perangkat['gambar'] && file_exists(ROOTPATH . 'public/uploads/' . $perangkat['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/' . $perangkat['gambar']);
            }
        } else {
            $filename = $perangkat['gambar'];
        }

        if (in_array($jenis, ['1', '2'])) {
            $nama = '-';
            $password = '-';
        } else {
            $nama = $this->request->getPost('nama');
            $password = $this->request->getPost('password');
        }

        $model = new ModelsInventaris();
        $model->update($id, [
            'kondisi_id' => $this->request->getPost('kondisi_id'),
            'jenis_id' => $this->request->getPost('jenis_id'),
            'tipe' => $this->request->getPost('tipe'),
            'nama' => $nama,
            'password' => $password,
            'gambar' => $filename,
            'tempat' => $this->request->getPost('tempat'),
            'status_id' => $this->request->getPost('status_id'),
            'kuantitas' => $this->request->getPost('kuantitas'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'lantai' => $this->request->getPost('lantai'),
        ]);


        if ($kondisi === '1') {
            return redirect()->to('/admin/dashboard/perangkat-jaringan/')->with('message', 'Data berhasil diperbarui.');
        } else {
            return redirect()->to('/admin/dashboard/inventaris/')->with('message', 'Data berhasil diperbarui.');
        }
    }

    public function hapus($id)
    {
        $model = new ModelsInventaris();
        $perangkat = $model->find($id);
        if ($perangkat) {
            $model->delete($id);
            if ($perangkat['gambar'] && file_exists('uploads/' . $perangkat['gambar'])) {
                unlink('uploads/' . $perangkat['gambar']);
            }
            return redirect()->back()->with('message', 'Data berhasil dihapus');
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Perangkat tidak ditemukan');
        }
    }
}