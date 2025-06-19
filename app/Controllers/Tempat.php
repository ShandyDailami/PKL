<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tempat as ModelTempat;
use CodeIgniter\HTTP\ResponseInterface;

class Tempat extends BaseController
{
    public function index()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $model = new ModelTempat();
        $data = [
            'title' => 'Tempat',
            'places' => $model->paginate(10),
            'pager' => $model->pager,
        ];
        return view('admin/tempat/dashboard', $data);
    }

    public function tambah()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        helper("helper");

        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Tempat harus diisi'],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ModelTempat();
        $model->save([
            'nama' => $this->request->getPost('nama'),
        ]);

        return redirect()->to('admin/dashboard/tempat')->with('message', 'Data berhasil ditambahkan');
    }

    public function halamanTambah()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $data = [
            'title' => 'Tempat',
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/tempat/tambah', $data);
        }
        ;
    }

    public function halamanUpdate($id)
    {
        $model = new ModelTempat();
        $data = [
            'title' => 'Tempat',
            'place' => $model->find($id),
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/tempat/update', $data);
        }
        ;
    }

    public function update($id)
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        helper('form');

        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jenis Perangkat harus diisi'],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ModelTempat();
        $model->update($id, [
            'nama' => $this->request->getPost('nama'),
        ]);

        return redirect('admin/dashboard/tempat')->with('message', 'Data berhasi diubah');
    }

    public function hapus($id)
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        }
        $model = new ModelTempat();
        $tempat = $model->find($id);
        if ($tempat) {
            $model->delete($id);
            return redirect()->back()->with('message', 'Data berhasil dihapus');
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tempat ditemukan');
        }
    }
}
