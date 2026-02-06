<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('is_login')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $user = $model->where('email', $this->request->getPost('email'))->first();

        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('errors', ['Email atau password salah.']);
        }

        session()->set([
            'user_id'    => $user['id_user'],
            'user_name'  => $user['nama'],
            'user_role'  => $user['role'],
            'user_email' => $user['email'],
            'is_login'   => true,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Berhasil login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Berhasil logout.');
    }
}
