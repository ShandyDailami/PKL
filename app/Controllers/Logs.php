<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Inventaris;
use App\Models\Kondisi;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Logs as ModelLogs;

class Logs extends BaseController
{
    public function logsSemuaPerangkat()
    {
        $model = new ModelLogs();
        $data = [
            'title' => 'Logs',
            'logs' => $model->dataJoin()
                ->where('kondisi.terpasang', 'terpasang')
                ->findAll(),
        ];

        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/inventaris/logs/dashboard', $data);
        }
    }

    public function logsPerangkat($inventaris_id)
    {
        $model = new ModelLogs();
        $data = [
            'title' => 'Logs',
            'inventaris_id' => $inventaris_id,
            'logs' => $model->where('inventaris_id', $inventaris_id)->findAll(),
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/network-device/log', $data);
        }
    }

    public function halamanTambahPerangkat($inventaris_id)
    {
        $uri = service('uri');
        $segment = $uri->getSegment(3);
        $kembali_url = ($segment === 'perangkat-jaringan')
            ? '/admin/dashboard/perangkat-jaringan/logs/'
            : '/admin/dashboard/inventaris/logs/';
        $data = [
            'kembali_url' => $kembali_url,
            'inventaris_id' => $inventaris_id,
            'title' => 'Tambah Logs',
        ];
        return view('admin/inventaris/logs/tambah', $data);
    }

    public function tambahPerangkat($inventaris_id)
    {
        helper('form');

        $model = new ModelLogs();
        $rules = [
            'aktivitas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Aktivitas harus diisi'
                ],
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi'
                ],
            ],
            'gambar' => [
                'rules' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]',
                'errors' => [
                    'uploaded' => 'Gambar harus diupload',
                    'is_image' => 'File harus berupa gambar yang valid (jpg, png, gif).',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
                ],
            ],
            'waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu harus diisi',
                ],
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status harus diisi'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('gambar');
        $filename = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/logs/', $filename);

        $model->save([
            'inventaris_id' => $this->request->getPost('inventaris_id'),
            'aktivitas' => $this->request->getPost('aktivitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar' => $filename,
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status')
        ]);
        return redirect()->to('admin/dashboard/perangkat-jaringan/logs/' . $inventaris_id . '/tambah')->with('success', 'Log berhasil ditambahkan.');
    }

    public function halamanUpdatePerangkat($inventaris_id, $log_id)
    {
        $model = new ModelLogs();
        $log = $model->where('id', $log_id)->where('inventaris_id', $inventaris_id)->first();
        $data = [
            'title' => 'Update Logs',
            'log' => $log,
            'inventaris_id' => $inventaris_id,
        ];
        return view('admin/inventaris/logs/update', $data);
    }

    public function updatePerangkat($inventaris_id, $id)
    {
        helper('form');

        $model = new ModelLogs();

        $rules = [
            'aktivitas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Aktivitas harus diisi'
                ],
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi'
                ],
            ],
            'waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu harus diisi',
                ],
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status harus diisi'
                ],
            ],
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = [
                'rules' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]',
                'errors' => [
                    'uploaded' => 'Gambar harus diupload',
                    'is_image' => 'File harus berupa gambar yang valid (jpg, png, gif).',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $data = [
            'aktivitas' => $this->request->getPost('aktivitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
        ];

        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move('uploads/logs/', $namaFile);
            $data['gambar'] = $namaFile;
        }

        $model->update($id, $data);

        return redirect()->to('admin/dashboard/perangkat-jaringan/logs/' . $inventaris_id)->with('message', 'Log berhasil diperbarui.');
    }

    public function hapusPerangkat($inventaris_id, $id)
    {
        $model = new ModelLogs();
        $log = $model->find($id);

        if (!$log) {
            return redirect()->to('admin/dashboard/perangkat-jaringan/logs' . $inventaris_id)->with('error', 'Data log tidak ditemukan.');
        }

        if (!empty($log['gambar']) && file_exists(FCPATH . 'uploads/logs/' . $log['gambar'])) {
            unlink(FCPATH . 'uploads/logs/' . $log['gambar']);
        }

        $model->delete($id);

        return redirect()->to('admin/dashboard/perangkat-jaringan/logs/' . $inventaris_id)->with('message', 'Log berhasil dihapus.');
    }

    public function logsSemuaInventaris()
    {
        $model = new ModelLogs();
        $data = [
            'title' => 'Semua Logs Inventaris',
            'logs' => $model->findAll()
        ];

        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }

        return view('admin/inventaris/logs/semua', $data);
    }

    public function logsInventaris($inventaris_id)
    {
        $model = new ModelLogs();
        $data = [
            'title' => 'Logs Inventaris',
            'inventaris_id' => $inventaris_id,
            'logs' => $model->where('inventaris_id', $inventaris_id)->findAll()
        ];

        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }

        return view('admin/item/log', $data);
    }

    public function halamanTambah($inventaris_id)
    {
        $uri = service('uri');
        $segment = $uri->getSegment(3);
        $kembali_url = ($segment === 'perangkat-jaringan')
            ? '/admin/dashboard/perangkat-jaringan/logs/'
            : '/admin/dashboard/inventaris/logs/';
        $data = [
            'kembali_url' => $kembali_url,
            'title' => 'Tambah Log',
            'inventaris_id' => $inventaris_id,
        ];

        return view('admin/inventaris/logs/tambah', $data);
    }

    public function tambahInventaris($inventaris_id)
    {
        helper('form');
        $model = new ModelLogs();

        $rules = [
            'aktivitas' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]',
            'waktu' => 'required',
            'status' => 'required',
        ];

        $errors = [
            'aktivitas' => ['required' => 'Aktivitas harus diisi'],
            'deskripsi' => ['required' => 'Deskripsi harus diisi'],
            'gambar' => [
                'uploaded' => 'Gambar harus diupload',
                'is_image' => 'File harus berupa gambar',
                'max_size' => 'Ukuran gambar maksimal 1MB'
            ],
            'waktu' => ['required' => 'Waktu harus diisi'],
            'status' => ['required' => 'Status harus diisi'],
        ];

        if (!$this->validate($rules, $errors)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('gambar');
        $filename = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/logs/', $filename);

        $model->save([
            'inventaris_id' => $inventaris_id,
            'aktivitas' => $this->request->getPost('aktivitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar' => $filename,
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('admin/dashboard/inventaris/logs/' . $inventaris_id)->with('message', 'Log berhasil ditambahkan.');
    }

    public function halamanUpdateInventaris($inventaris_id, $log_id)
    {
        $model = new ModelLogs();
        $log = $model->where('id', $log_id)->where('inventaris_id', $inventaris_id)->first();

        if (!$log) {
            return redirect()->to('admin/dashboard/inventaris/logs/' . $inventaris_id)->with('error', 'Log tidak ditemukan.');
        }

        $data = [
            'title' => 'Update Log',
            'log' => $log,
            'inventaris_id' => $inventaris_id,
        ];

        return view('admin/inventaris/logs/update', $data);
    }

    public function updateInventaris($inventaris_id, $log_id)
    {
        helper('form');
        $model = new ModelLogs();

        $rules = [
            'aktivitas' => 'required',
            'deskripsi' => 'required',
            'waktu' => 'required',
            'status' => 'required',
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'aktivitas' => $this->request->getPost('aktivitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
        ];

        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/logs/', $namaFile);
            $data['gambar'] = $namaFile;
        }

        $model->update($log_id, $data);

        return redirect()->to('admin/dashboard/inventaris/logs/' . $inventaris_id)->with('message', 'Log berhasil diperbarui.');
    }

    public function hapusInventaris($inventaris_id, $log_id)
    {
        $model = new ModelLogs();
        $log = $model->find($log_id);

        if (!$log) {
            return redirect()->to('admin/dashboard/inventaris/logs/' . $inventaris_id)->with('error', 'Log tidak ditemukan.');
        }

        if (!empty($log['gambar']) && file_exists(FCPATH . 'uploads/logs/' . $log['gambar'])) {
            unlink(FCPATH . 'uploads/logs/' . $log['gambar']);
        }

        $model->delete($log_id);

        return redirect()->to('admin/dashboard/inventaris/logs/' . $inventaris_id)->with('message', 'Log berhasil dihapus.');
    }
}
