<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('admin/dashboard'));
        }
        return view('admin/login');
    }

    public function login()
    {
        $session = session();
        $userModel = new \App\Models\User();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            $pass = $user['password'];
            if (password_verify($password, $pass)) {
                $sessionData = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($sessionData);
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                $session->setFlashdata('error', 'Wrong Password');
                return redirect()->to(base_url('admin/auth'));
            }
        } else {
            $session->setFlashdata('error', 'Email not Found');
            return redirect()->to(base_url('admin/auth'));
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('admin/auth'));
    }
}
