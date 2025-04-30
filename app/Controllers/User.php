<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User as ModelUser;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    public function loginPage()
    {
        if (session()->has('id')) {
            return redirect()->to('admin/dashboard/perangkat-jaringan');
        }
        return view('admin/login', ['title' => 'Login']);
    }

    public function login()
    {
        helper('form');

        $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
        $secret = '6LfqXB8rAAAAAMLfF8Gq4FFH3KqHeqeED9zkG8H9';

        $verifyResponse = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptchaResponse}"
        );
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            return redirect()->back()->withInput()->with('error', 'Verifikasi CAPTCHA gagal.');
        }

        if (
            $this->validate([
                'username' => [
                    'rules' => 'required|min_length[3]|max_length[255]',
                    'errors' => [
                        'required' => 'Username cannot be empty',
                        'min_length' => 'Username must be at least 3 characters long.',
                        'max_length[255]' => 'Username can be up to 255 characters long.'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[255]',
                    'errors' => [
                        'required' => 'Password cannot be empty.',
                        'min_length' => 'Password must be at least 5 characters long.',
                        'max_length' => 'Password cannot exceed 255 characters.',
                    ]
                ]
            ])
        ) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $model = new ModelUser();
            $user = $model->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->set('id', $user['id']);
                session()->set('username', $user['username']);
                session()->setFlashdata('message', 'Kamu berhasil log in');

                return redirect()->to('admin/dashboard/perangkat-jaringan');
            } else {
                session()->setFlashdata('error', 'Invalid username or password');
                return redirect()->to('admin/login');
            }
        } else {
            return redirect()->to('admin/login')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('admin/login');
    }
}
