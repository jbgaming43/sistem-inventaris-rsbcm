<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PenggunaModel;
use CodeIgniter\Session\Session;

class AuthController extends Controller
{

    public function login()
    {
        helper(['form', 'url']);

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => 'required',
                'password' => 'required'
            ];

            $errors = [
                'username' => [
                    'required' => 'Username harus diisi.'
                ],
                'password' => [
                    'required' => 'Password harus diisi.'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                return view('auth/login', [
                    'validation' => $this->validator
                ]);
            } else {
                $pm = new PenggunaModel();
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $user = $pm->where('username', $username)->first();

                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        session()->set([
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'nama_pengguna' => $user['nama_pengguna'],
                            'level' => $user['level'],
                            'profile_image' => $user['profile_image'],
                            'isLoggedIn' => true,
                        ]);

                        return redirect()->to('/dashboard');
                    } else {
                        session()->setFlashdata('error', 'Password salah!');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('error', 'Username tidak ditemukan!');
                    return redirect()->back();
                }
            }
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
