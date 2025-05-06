<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\AutentikasiPerangkat;
use App\Models\Inventaris as ModelsInventaris;
use App\Models\Jenis;
use App\Models\Kondisi;
use App\Models\Lokasi;
use App\Models\Status;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Inventaris extends BaseController
{
    public function perangkatJaringanUser()
    {
        $model = new ModelsInventaris();
        $keyword = $this->request->getGet('keyword');
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 1);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('lokasi.tempat', $keyword)
                ->orLike('lokasi.lantai', $keyword)
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
        $keyword = $this->request->getGet('keyword');
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 2);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('lokasi.tempat', $keyword)
                ->orLike('lokasi.lantai', $keyword)
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
        $keyword = $this->request->getGet('keyword');
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
        $keyword = $this->request->getGet('keyword');
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
            'items' => $model->paginate(5),
            'pager' => $model->pager,
            'keyword' => $keyword,
        ];
        return view('admin/item/dashboard', $data);
    }


    public function get_devices()
    {
        $model = new ModelsInventaris();
        $devices = $model
            ->dataJoin()
            ->where('inventaris.kondisi_id', 1)
            ->findAll();

        return $this->response->setJSON($devices);
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
        $model = new ModelsInventaris();
        $modelKondisi = new Kondisi();
        $modelLokasi = new Lokasi();
        $modelAutentikasiPerangkat = new AutentikasiPerangkat();

        $file = $this->request->getFile('file_excel');

        if ($file && $file->isValid()) {
            $ext = $file->getClientExtension();
            if (!in_array($ext, ['xls', 'xlsx'])) {
                return redirect()->back()->with('error', 'Hanya file Excel (.xls, .xlsx) yang diperbolehkan.');
            }

            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            $header = array_shift($rows); // Buang header

            foreach ($rows as $row) {
                // Ambil kondisi_id lalu cek namanya
                $kondisiId = $row['G'] ?? null;
                $kondisiRow = $modelKondisi->find($kondisiId);
                $namaKondisi = ($kondisiRow && array_key_exists('nama', $kondisiRow)) ? strtolower(trim($kondisiRow['nama'])) : '';
                $isTerpasang = $namaKondisi === 'terpasang';

                if (empty($row['D']) || empty($row['B'])) {
                    continue;
                }

                $modelAutentikasiPerangkat->save([
                    'SSID' => $row['D'] ?? null,
                    'password' => $row['E'] ?? null,
                ]);
                $autentikasiId = $modelAutentikasiPerangkat->getInsertID();

                $lokasiId = null;
                if ($isTerpasang) {
                    $modelLokasi->save([
                        'tempat' => $row['A'] ?? null,
                        'latitude' => isset($row['I']) ? (string) $row['I'] : null,
                        'longitude' => isset($row['J']) ? (string) $row['J'] : null,
                        'lantai' => $row['K'] ?? null,
                    ]);
                    $lokasiId = $modelLokasi->getInsertID();
                }

                // Cek duplikasi
                $exists = $model
                    ->where('merek', $row['C'])
                    ->where('jenis_id', $row['B'])
                    ->where('lokasi_id', $lokasiId)
                    ->countAllResults();

                if ($exists == 0) {
                    $model->save([
                        'jenis_id' => $row['B'],
                        'kondisi_id' => $kondisiId,
                        'merek' => $row['C'],
                        'autentikasi_perangkat_id' => $autentikasiId,
                        'gambar' => $row['F'],
                        'status_id' => $row['H'],
                        'lokasi_id' => $lokasiId,
                    ]);
                }
            }

            return redirect()->to('/admin/dashboard/inventaris/')->with('message', 'Import data berhasil!');
        }

        return redirect()->back()->with('error', 'File tidak valid.');
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
        $model = new ModelsInventaris();
        $modelKondisi = new Kondisi();
        $modelJenis = new Jenis();
        $modelStatus = new Status();
        $data = [
            'title' => 'Perangkat Jaringan - Tambah',
            'devices' => $model->findAll(),
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
        $modelLokasi = new Lokasi();
        $model = new ModelsInventaris();
        $data = [
            'title' => 'Perangkat Jaringan - Edit',
            'inventaris' => $model->dataJoin()->find($id),
            'lokasi' => $modelLokasi->find($id),
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
        $model = new ModelsInventaris();
        $modelKondisi = new Kondisi();
        $modelLokasi = new Lokasi();
        $modelAutentikasiPerangkat = new AutentikasiPerangkat();

        $kondisiId = $this->request->getPost('kondisi_id');
        $kondisiRow = $modelKondisi->find($kondisiId);
        $namaKondisi = ($kondisiRow && array_key_exists('nama', $kondisiRow)) ? strtolower($kondisiRow['nama']) : '';

        $isTerpasang = strtolower(trim($namaKondisi)) === 'terpasang';

        $rules = [
            'jenis_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jenis harus diisi'],
            ],
            'kondisi_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kondisi harus diisi'],
            ],
            'merek' => [
                'rules' => 'required',
                'errors' => ['required' => 'Merek harus diisi'],
            ],
            'gambar' => [
                'rules' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]',
                'errors' => [
                    'uploaded' => 'Gambar harus diupload',
                    'is_image' => 'File harus berupa gambar yang valid(jpg, png, gif).',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
                ],
            ],
            'status_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Status harus diisi'],
            ],
        ];

        if ($isTerpasang) {
            $rules['tempat'] = ['rules' => 'required', 'errors' => ['required' => 'Tempat harus diisi']];
            $rules['latitude'] = ['rules' => 'required', 'errors' => ['required' => 'Latitude harus diisi']];
            $rules['longitude'] = ['rules' => 'required', 'errors' => ['required' => 'Longitude harus diisi']];
            $rules['lantai'] = ['rules' => 'required', 'errors' => ['required' => 'Lantai harus diisi']];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('gambar');
        $filename = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/', $filename);

        $lokasiId = null;
        if ($isTerpasang) {
            $modelLokasi->save([
                'tempat' => $this->request->getPost('tempat'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'lantai' => $this->request->getPost('lantai'),
            ]);
            $lokasiId = $modelLokasi->getInsertID();
        }

        $modelAutentikasiPerangkat->save([
            'SSID' => $this->request->getPost('SSID'),
            'password' => $this->request->getPost('password'),
        ]);
        $autentikasiPerangkatId = $modelAutentikasiPerangkat->getInsertID();

        $model->save([
            'jenis_id' => $this->request->getPost('jenis_id'),
            'kondisi_id' => $this->request->getPost('kondisi_id'),
            'merek' => $this->request->getPost('merek'),
            'autentikasi_perangkat_id' => $autentikasiPerangkatId,
            'gambar' => $filename,
            'status_id' => $this->request->getPost('status_id'),
            'lokasi_id' => $lokasiId,
        ]);

        if ($isTerpasang) {
            return redirect()->to('admin/dashboard/perangkat-jaringan')->with('message', 'Data berhasil dibuat');
        } else {
            return redirect()->to('admin/dashboard/inventaris')->with('message', 'Data berhasil dibuat');
        }
    }

    public function update($id)
    {
        helper('form');

        $model = new ModelsInventaris();
        $modelKondisi = new Kondisi();
        $modelLokasi = new Lokasi();
        $modelAutentikasiPerangkat = new AutentikasiPerangkat();

        $inventaris = $model->find($id);
        if (!$inventaris) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventaris tidak ditemukan');
        }

        $kondisiId = $this->request->getPost('kondisi_id');
        $kondisiRow = $modelKondisi->find($kondisiId);
        $namaKondisi = ($kondisiRow && array_key_exists('nama', $kondisiRow)) ? strtolower($kondisiRow['nama']) : '';
        $isTerpasang = strtolower(trim($namaKondisi)) === 'terpasang';


        $rules = [
            'jenis_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jenis harus diisi'],
            ],
            'kondisi_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kondisi harus diisi'],
            ],
            'merek' => [
                'rules' => 'required',
                'errors' => ['required' => 'Merek harus diisi'],
            ],
            'status_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Status harus diisi'],
            ],
        ];

        if ($this->request->getFile('gambar')->isValid() && !$this->request->getFile('gambar')->hasMoved()) {
            $rules['gambar'] = 'is_image[gambar]|max_size[gambar,1024]';
        }

        if ($isTerpasang) {
            $rules['tempat'] = ['rules' => 'required', 'errors' => ['required' => 'Tempat harus diisi']];
            $rules['latitude'] = ['rules' => 'required', 'errors' => ['required' => 'Latitude harus diisi']];
            $rules['longitude'] = ['rules' => 'required', 'errors' => ['required' => 'Longitude harus diisi']];
            $rules['lantai'] = ['rules' => 'required', 'errors' => ['required' => 'Lantai harus diisi']];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $inventaris['gambar'];
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $gambar = $fileGambar->getRandomName();
            $fileGambar->move(ROOTPATH . 'public/uploads/', $gambar);
            // Opsional: hapus gambar lama
            if (file_exists(ROOTPATH . 'public/uploads/' . $inventaris['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/' . $inventaris['gambar']);
            }
        }

        $lokasiId = $inventaris['lokasi_id'];
        if ($isTerpasang) {
            $dataLokasi = [
                'tempat' => $this->request->getPost('tempat'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'lantai' => $this->request->getPost('lantai'),
            ];

            if ($lokasiId) {
                $dataLokasi['id'] = $lokasiId;
                $modelLokasi->save($dataLokasi);
            } else {
                $modelLokasi->save($dataLokasi);
                $lokasiId = $modelLokasi->getInsertID();
            }
        } else {
            // Jika sekarang tidak terpasang, hapus lokasi jika sebelumnya ada
            if ($lokasiId) {
                $modelLokasi->delete($lokasiId);
                $lokasiId = null;
            }
        }

        $autentikasiId = $inventaris['autentikasi_perangkat_id'];
        $modelAutentikasiPerangkat->save([
            'id' => $autentikasiId,
            'SSID' => $this->request->getPost('SSID'),
            'password' => $this->request->getPost('password'),
        ]);

        // Inventaris
        $model->save([
            'id' => $id,
            'jenis_id' => $this->request->getPost('jenis_id'),
            'kondisi_id' => $this->request->getPost('kondisi_id'),
            'merek' => $this->request->getPost('merek'),
            'autentikasi_perangkat_id' => $autentikasiId,
            'gambar' => $gambar,
            'status_id' => $this->request->getPost('status_id'),
            'lokasi_id' => $lokasiId,
        ]);

        return redirect()->to('admin/dashboard/inventaris')->with('message', 'Data berhasil diperbarui');
    }

    public function updatee($id)
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

    public function test()
    {
        $model = new ModelsInventaris();
        $data = [
            'devices' => $model->dataJoin()->where('inventaris.kondisi_id', 1)->findAll(),
            'title' => 'Perangkat Jaringan - Export PDF',
        ];
        return view('admin/network-device/test', $data);
    }
}