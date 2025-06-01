<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jenis as ModelsJenis;
use CodeIgniter\HTTP\ResponseInterface;

class Jenis extends BaseController
{
    public function index()
    {

        $model = new ModelsJenis();
        $data = [
            'title' => 'Jenis Perangkat',
            'types' => $model->paginate(10),
            'pager' => $model->pager,
        ];
        return view('admin/jenis_perangkat/dashboard', $data);
    }

    public function tambah()
    {
        helper("helper");

        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jenis harus diisi'],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ModelsJenis();
        $model->save([
            'nama' => $this->request->getPost('nama'),
        ]);

        return redirect()->to('admin/dashboard/jenis-perangkat')->with('message', 'Data berhasil ditambah');
    }

    public function halamanUpdate($id)
    {
        $model = new ModelsJenis();
        $data = [
            'title' => 'Jenis Perangkat',
            'type' => $model->find($id),
        ];
        if (!session()->has('id')) {
            return redirect()->to('admin/login');
        } else {
            return view('admin/jenis_perangkat/update', $data);
        }
    }

    public function update($id)
    {
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

        $model = new ModelsJenis();
        $model->update($id, [
            'nama' => $this->request->getPost('nama'),
        ]);

        return redirect()->to('admin/dashboard/jenis-perangkat')->with('message', 'Data berhasil diubah');
    }

    public function hapus($id)
    {
        $model = new ModelsJenis();
        $jenis = $model->find($id);
        if ($jenis) {
            $model->delete($id);
            return redirect()->back()->with('message', 'Data berhasil dihapus');
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis tidak ditemukan');
        }
    }
}
