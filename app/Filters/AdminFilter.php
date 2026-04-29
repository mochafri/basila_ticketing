<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek Login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signin');
        }

        // 2. Cek Role & Khusus User 'admin'
        $roleName = session('role_name');
        $loginUser = strtolower(session('login_username') ?? '');
        $userId   = session('user_identifier');

        // Mengizinkan jika SUPERADMIN ATAU username adalah 'admin' ATAU ID adalah '000000'
        if ($roleName !== 'SUPERADMIN' && $loginUser !== 'admin' && $userId !== '000000') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk menu ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
