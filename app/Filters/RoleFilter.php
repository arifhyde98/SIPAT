<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_login')) {
            return redirect()->to('/')->with('errors', ['Silakan login terlebih dahulu.']);
        }

        $role = session()->get('user_role');
        $allowed = $arguments ?? [];

        if (!empty($allowed) && !in_array($role, $allowed, true)) {
            return redirect()->to('/dashboard')->with('errors', ['Akses ditolak untuk peran ini.']);
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah response
    }
}
