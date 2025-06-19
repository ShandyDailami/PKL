<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\AutentikasiPerangkat;
use App\Models\Inventaris as ModelsInventaris;
use App\Models\Jenis;
use App\Models\Kondisi;
use App\Models\Logs;
use App\Models\Lokasi;
use App\Models\Modal;
use App\Models\Status;
use App\Models\Tempat;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class Inventaris extends BaseController
{
    public function perangkatJaringanUser()
    {
        $model = new ModelsInventaris();
        $modelModal = new Modal();
        $keyword = $this->request->getGet('keyword');
        $modalQuery = $modelModal->dataJoin()->where('inventaris.kondisi_id', 1);
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 1);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('tempat.nama', $keyword)
                ->orLike('inventaris.merek', $keyword)
                ->orLike('autentikasi_perangkat.SSID', $keyword)
                ->orLike('lokasi.lantai', $keyword)
                ->groupEnd();
        }
        $data = [
            'title' => 'Perangkat Jaringan',
            'modals' => $modalQuery->findAll(),
            'devices' => $query->paginate(4),
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
                ->orLike('tempat.nama', $keyword)
                ->orLike('inventaris.merek', $keyword)
                ->orLike('lokasi.lantai', $keyword)
                ->groupEnd();
        }
        $data = [
            'title' => 'Inventaris',
            'items' => $query->paginate(4),
            'pager' => $model->pager,
            'keyword' => $keyword,
        ];
        return view('user/item', $data);
    }

    public function perangkatJaringanAdmin()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $model = new ModelsInventaris();
        $modelModal = new Modal();
        $keyword = $this->request->getGet('keyword');
        $modalQuery = $modelModal->dataJoin()->where('inventaris.kondisi_id', 1);
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 1);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('tempat.nama', $keyword)
                ->orLike('inventaris.merek', $keyword)
                ->orLike('autentikasi_perangkat.SSID', $keyword)
                ->orLike('lokasi.lantai', $keyword)
                ->groupEnd();
        }
        $data = [
            'title' => 'Perangkat Jaringan',
            'modals' => $modalQuery->findAll(),
            'devices' => $query->paginate(5),
            'pager' => $model->pager,
            'keyword' => $keyword,
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/network-device/dashboard', $data);
        }
    }
    public function inventarisAdmin()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $model = new ModelsInventaris();
        $keyword = $this->request->getGet('keyword');
        $query = $model->dataJoin()->where('inventaris.kondisi_id', 2);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('jenis.nama', $keyword)
                ->orLike('tempat.nama', $keyword)
                ->orLike('inventaris.merek', $keyword)
                ->orLike('lokasi.lantai', $keyword)
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
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }

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

            $header = array_shift($rows);
            $userId = session()->get('id');

            $importedCount = 0;
            $duplicateCount = 0;

            foreach ($rows as $row) {
                if (empty($row['D']) || empty($row['B'])) {
                    continue;
                }

                $kondisiId = $row['G'] ?? null;
                $kondisiRow = $modelKondisi->find($kondisiId);
                $namaKondisi = ($kondisiRow && array_key_exists('nama', $kondisiRow)) ? strtolower(trim($kondisiRow['nama'])) : '';
                $isTerpasang = $namaKondisi === 'terpasang';

                $modelAutentikasiPerangkat->save([
                    'SSID' => $row['D'] ?? null,
                    'password' => $row['E'] ?? null,
                ]);
                $autentikasiId = $modelAutentikasiPerangkat->getInsertID();

                $lokasiId = null;
                $tempatId = null;
                $lantai = $row['K'] ?? null;

                if ($isTerpasang) {
                    $modelLokasi->save([
                        'latitude' => isset($row['I']) ? (string) $row['I'] : null,
                        'longitude' => isset($row['J']) ? (string) $row['J'] : null,
                        'lantai' => $lantai,
                    ]);
                    $lokasiId = $modelLokasi->getInsertID();
                    $tempatId = $row['A'] ?? null;
                }

                $jenisId = $row['B'];
                $merek = $row['C'];

                $tanggalPerolehan = date('Y-m-d');

                if (!empty($row['L'])) {
                    if (is_numeric($row['L'])) {
                        $tanggalPerolehan = ExcelDate::excelToDateTimeObject($row['L'])->format('Y-m-d');
                    } else {
                        $timestamp = strtotime($row['L']);
                        if ($timestamp !== false) {
                            $tanggalPerolehan = date('Y-m-d', $timestamp);
                        }
                    }
                }

                if ($isTerpasang) {
                    $duplikat = $model
                        ->where('jenis_id', $jenisId)
                        ->where('kondisi_id', $kondisiId)
                        ->where('merek', $merek)
                        ->where('tempat_id', $tempatId)
                        ->join('lokasi', 'lokasi.id = inventaris.lokasi_id')
                        ->where('lokasi.lantai', $lantai)
                        ->first();
                } else {
                    $duplikat = $model
                        ->where('jenis_id', $jenisId)
                        ->where('kondisi_id', $kondisiId)
                        ->where('merek', $merek)
                        ->where('lokasi_id', null)
                        ->first();
                }

                if (!$duplikat) {
                    $model->save([
                        'user_id' => $userId,
                        'jenis_id' => $jenisId,
                        'kondisi_id' => $kondisiId,
                        'merek' => $merek,
                        'autentikasi_perangkat_id' => $autentikasiId,
                        'gambar' => $row['F'] ?? null,
                        'status_id' => $row['H'] ?? null,
                        'lokasi_id' => $lokasiId,
                        'tempat_id' => $tempatId,
                        'tanggal_perolehan' => $tanggalPerolehan,
                    ]);
                    $importedCount++;
                } else {
                    $duplicateCount++;
                }
            }

            return redirect()
                ->to('/admin/dashboard/perangkat-jaringan')
                ->with('message', "Import selesai: <strong>{$importedCount}</strong> data berhasil diimpor, <strong>{$duplicateCount}</strong> data duplikat diabaikan.");
        }

        return redirect()->back()->with('error', 'File tidak valid.');
    }

    public function exportPerangkatPDF()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }

        $logoPath = FCPATH . 'assets/logo/ULM.png';
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoData;

        $model = new ModelsInventaris();
        $modelLogs = new Logs();

        $data = [
            'logoSrc' => $logoSrc,
            'logs' => $modelLogs->dataJoin(1)->findAll(),
            'devices' => $model->dataJoin()->where('inventaris.kondisi_id', 1)->findAll(),
            'title' => 'Perangkat Jaringan - Export PDF',
        ];

        $dompdf = new Dompdf();
        $html = view('admin/network-device/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Perangkat Jaringan - ' . date('Y-m-d') . '.pdf';

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($dompdf->output());
    }


    public function exportInventarisPDF()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $logoPath = FCPATH . 'assets/logo/ULM.png';
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoData;
        $model = new ModelsInventaris();
        $data = [
            'logoSrc' => $logoSrc,
            'items' => $model->dataJoin()->where('inventaris.kondisi_id', 2)->findAll(),
            'title' => 'Inventaris - Export PDF',
        ];
        $dompdf = new Dompdf();

        $html = view('admin/item/pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Inventaris - ' . date('Y-m-d') . '.pdf';

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($dompdf->output());
    }

    public function halamanTambah()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $model = new ModelsInventaris();
        $modelKondisi = new Kondisi();
        $modelJenis = new Jenis();
        $modelStatus = new Status();
        $modelTempat = new Tempat();
        $data = [
            'title' => 'Perangkat Jaringan - Tambah',
            'devices' => $model->findAll(),
            'conditions' => $modelKondisi->findAll(),
            'types' => $modelJenis->findAll(),
            'statuses' => $modelStatus->findAll(),
            'places' => $modelTempat->findAll(),
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/inventaris/tambah', $data);
        }
    }

    public function halamanUpdate($id)
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $modelKondisi = new Kondisi();
        $modelJenis = new Jenis();
        $modelStatus = new Status();
        $modelLokasi = new Lokasi();
        $modelTempat = new Tempat();
        $model = new ModelsInventaris();
        $data = [
            'title' => 'Perangkat Jaringan - Edit',
            'inventaris' => $model->dataJoin()->find($id),
            'lokasi' => $modelLokasi->find($id),
            'conditions' => $modelKondisi->findAll(),
            'types' => $modelJenis->findAll(),
            'statuses' => $modelStatus->findAll(),
            'places' => $modelTempat->findAll(),
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/inventaris/update', $data);
        }
    }

    public function tambah()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }

        helper('form');

        $model = new ModelsInventaris();
        $modelKondisi = new Kondisi();
        $modelLokasi = new Lokasi();
        $modelStatus = new Status();
        $modelAutentikasiPerangkat = new AutentikasiPerangkat();

        $kondisiId = $this->request->getPost('kondisi_id');
        $kondisiRow = $modelKondisi->find($kondisiId);
        $namaKondisi = ($kondisiRow && array_key_exists('nama', $kondisiRow)) ? strtolower($kondisiRow['nama']) : '';
        $isTerpasang = strtolower(trim($namaKondisi)) === 'terpasang';

        $rules = [
            'jenis_id' => ['rules' => 'required', 'errors' => ['required' => 'Jenis harus diisi']],
            'kondisi_id' => ['rules' => 'required', 'errors' => ['required' => 'Kondisi harus diisi']],
            'merek' => ['rules' => 'required', 'errors' => ['required' => 'Merek harus diisi']],
            'gambar' => [
                'rules' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]',
                'errors' => [
                    'uploaded' => 'Gambar harus diupload',
                    'is_image' => 'File harus berupa gambar yang valid (jpg, png, gif).',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
                ],
            ],
            'tanggal_perolehan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu harus diisi',
                ],
            ],
        ];

        if ($isTerpasang) {
            $rules['tempat_id'] = ['rules' => 'required', 'errors' => ['required' => 'Tempat harus diisi']];
            $rules['latitude'] = ['rules' => 'required', 'errors' => ['required' => 'Latitude harus diisi']];
            $rules['longitude'] = ['rules' => 'required', 'errors' => ['required' => 'Longitude harus diisi']];
            $rules['lantai'] = ['rules' => 'required', 'errors' => ['required' => 'Lantai harus diisi']];
            $rules['status_id'] = ['rules' => 'required', 'errors' => ['required' => 'Status harus diisi']];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $jenisId = $this->request->getPost('jenis_id');
        $merek = $this->request->getPost('merek');
        $tempatId = $this->request->getPost('tempat_id');
        $lantai = $this->request->getPost('lantai');

        if ($isTerpasang) {
            $duplikat = $model->where([
                'jenis_id' => $jenisId,
                'kondisi_id' => $kondisiId,
                'merek' => $merek,
                'tempat_id' => $tempatId,
            ])
                ->join('lokasi', 'lokasi.id = inventaris.lokasi_id')
                ->where('lokasi.lantai', $lantai)
                ->first();
        } else {
            $duplikat = $model->where([
                'jenis_id' => $jenisId,
                'kondisi_id' => $kondisiId,
                'merek' => $merek,
            ])
                ->where('lokasi_id', null)
                ->first();
        }

        if ($duplikat) {
            return redirect()->back()->withInput()->with('errors', [
                'duplikat' => 'Data perangkat tersebut sudah ada.'
            ]);
        }

        $image = $this->request->getFile('gambar');
        $filename = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/', $filename);

        $statusId = 3;
        $lokasiId = null;

        if ($isTerpasang) {
            $modelLokasi->save([
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'lantai' => $this->request->getPost('lantai'),
            ]);
            $lokasiId = $modelLokasi->getInsertID();
            $statusId = $this->request->getPost('status_id');
        }

        $modelAutentikasiPerangkat->save([
            'SSID' => $this->request->getPost('SSID'),
            'password' => $this->request->getPost('password'),
        ]);
        $autentikasiPerangkatId = $modelAutentikasiPerangkat->getInsertID();

        $userId = session()->get('id');

        $model->save([
            'user_id' => $userId,
            'jenis_id' => $jenisId,
            'kondisi_id' => $kondisiId,
            'merek' => $merek,
            'autentikasi_perangkat_id' => $autentikasiPerangkatId,
            'gambar' => $filename,
            'tanggal_perolehan' => $this->request->getPost('tanggal_perolehan'),
            'status_id' => $statusId,
            'lokasi_id' => $lokasiId,
            'tempat_id' => $isTerpasang ? $tempatId : null,
        ]);

        $redirectUrl = $isTerpasang ? 'admin/dashboard/perangkat-jaringan' : 'admin/dashboard/inventaris';
        return redirect()->to($redirectUrl)->with('message', 'Data berhasil dibuat');
    }


    public function update($id)
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        helper('form');

        $model = new ModelsInventaris();
        $modelKondisi = new Kondisi();
        $modelLokasi = new Lokasi();
        $modelStatus = new Status();
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
            'tanggal_perolehan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu harus diisi',
                ],
            ],
        ];

        if ($this->request->getFile('gambar')->isValid() && !$this->request->getFile('gambar')->hasMoved()) {
            $rules['gambar'] = 'is_image[gambar]|max_size[gambar,1024]';
        }

        if ($isTerpasang) {
            $rules['tempat_id'] = ['rules' => 'required', 'errors' => ['required' => 'Tempat harus diisi']];
            $rules['latitude'] = ['rules' => 'required', 'errors' => ['required' => 'Latitude harus diisi']];
            $rules['longitude'] = ['rules' => 'required', 'errors' => ['required' => 'Longitude harus diisi']];
            $rules['lantai'] = ['rules' => 'required', 'errors' => ['required' => 'Lantai harus diisi']];
            $rules['status_id'] = ['rules' => 'required', 'errors' => ['required' => 'Status harus diisi']];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $inventaris['gambar'];
        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $gambarBaru = $fileGambar->getRandomName();
            $fileGambar->move(ROOTPATH . 'public/uploads/', $gambarBaru);

            if (!empty($inventaris['gambar']) && file_exists(ROOTPATH . 'public/uploads/' . $inventaris['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/' . $inventaris['gambar']);
            }

            $gambar = $gambarBaru;
        }

        $statusId = $inventaris['status_id'];
        $lokasiId = $inventaris['lokasi_id'];
        $tempatId = $inventaris['tempat_id'];
        if ($isTerpasang) {
            $dataLokasi = [
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'lantai' => $this->request->getPost('lantai'),
            ];
            $tempatId = $this->request->getPost('tempat_id');
            $statusId = $this->request->getPost('status_id');

            if ($lokasiId) {
                $dataLokasi['id'] = $lokasiId;
                $modelLokasi->save($dataLokasi);
            } else {
                $modelLokasi->save($dataLokasi);
            }
        } else {
            $lokasiId = null;
        }

        $autentikasiId = $inventaris['autentikasi_perangkat_id'];
        $modelAutentikasiPerangkat->save([
            'id' => $autentikasiId,
            'SSID' => $this->request->getPost('SSID'),
            'password' => $this->request->getPost('password'),
        ]);

        $model->save([
            'id' => $id,
            'jenis_id' => $this->request->getPost('jenis_id'),
            'kondisi_id' => $this->request->getPost('kondisi_id'),
            'merek' => $this->request->getPost('merek'),
            'autentikasi_perangkat_id' => $autentikasiId,
            'gambar' => $gambar,
            'tanggal_perolehan' => $this->request->getPost('tanggal_perolehan'),
            'status_id' => $statusId,
            'lokasi_id' => $lokasiId,
            'tempat_id' => $tempatId,
        ]);

        if ($isTerpasang) {
            return redirect()->to('admin/dashboard/perangkat-jaringan')->with('message', 'Data berhasil diperbarui');
        } else {
            return redirect()->to('admin/dashboard/inventaris')->with('message', 'Data berhasil diperbarui');
        }
    }

    public function hapus($id)
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
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