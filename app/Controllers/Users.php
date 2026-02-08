<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $users = $model->orderBy('id_user', 'DESC')->findAll();

        return view('users/index', ['users' => $users]);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'role'     => 'required',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $payload = [
            'nama'     => $this->request->getPost('nama'),
            'role'     => $this->request->getPost('role'),
            'opd'      => $this->request->getPost('opd'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ];
        $model->insert($payload);
        $logData = $payload;
        unset($logData['password']);
        $this->logAudit('create', 'users', (int) $model->getInsertID(), [], $logData);

        return redirect()->to('/users')->with('success', 'User berhasil dibuat.');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        if (!$user) {
            throw new PageNotFoundException('User tidak ditemukan');
        }

        return view('users/edit', ['user' => $user]);
    }

    public function update($id)
    {
        $rules = [
            'nama'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id_user,{$id}]",
            'role'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'role'  => $this->request->getPost('role'),
            'opd'   => $this->request->getPost('opd'),
            'email' => $this->request->getPost('email'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $model = new UserModel();
        $old = $model->find($id) ?? [];
        $model->update($id, $data);
        unset($old['password']);
        $logData = $data;
        unset($logData['password']);
        $this->logAudit('update', 'users', (int) $id, $old, $logData);

        return redirect()->to('/users')->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $old = $model->find($id) ?? [];
        $model->delete($id);
        unset($old['password']);
        $this->logAudit('delete', 'users', (int) $id, $old, []);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus.');
    }
}
