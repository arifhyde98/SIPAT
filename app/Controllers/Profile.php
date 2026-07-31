<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Profile extends BaseController
{
    public function index()
    {
        $id = session()->get('user_id');
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            throw new PageNotFoundException('User tidak ditemukan');
        }

        return view('profile/index', [
            'title' => 'Profil Saya',
            'user'  => $user,
        ]);
    }

    public function update()
    {
        $id = session()->get('user_id');
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            throw new PageNotFoundException('User tidak ditemukan');
        }

        $rules = [
            'nama'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id_user,{$id}]",
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $old = $user;
        unset($old['password']);
        
        $model->update($id, $data);

        // Perbarui data di session agar langsung sinkron di layout/header
        session()->set([
            'user_name'  => $data['nama'],
            'user_email' => $data['email'],
        ]);

        $logData = $data;
        unset($logData['password']);
        $this->logAudit('update_profile', 'users', (int) $id, $old, $logData);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
