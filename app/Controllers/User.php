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

        $response = service('response');
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', '0');

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

        if (
            $this->validate([
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username harus diisi',
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password harus diisi',
                    ]
                ],
                'g-recaptcha-response' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silakan centang CAPTCHA terlebih dahulu.',
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
                session()->setFlashdata('error', 'Username atau password salah');
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
