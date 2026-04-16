<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    protected $service;

    public function signIn(): string
    {
        $data = [
            'title' => 'SignIn',
        ];

        return view('auth/signIn/index', $data);
    }

    public function processSignIn()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('validation', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
        ];

        try {
            $service = service('auth')->login($data);

            session()->set([
                'roles' => $service['data_role'],
                'token' => $service['token'],
                'username' => $service['profile']['fullname'] ?? 'Admin',
                'user_identifier' => $service['profile']['numberid'] ?? '1987654321',
                'profilephoto' => $service['profile']['photo'] ?? null,
                'isLoggedIn' => true
            ]);

            return redirect()->to('/role-option');

        } catch (\Exception $e) {
            return redirect()->to('/signin')
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function signUp(): string
    {
        $data = [
            'title' => 'SignIn',
        ];


        return view('auth/signUp/index', $data);
    }

    public function forgotPassword(): string
    {
        $data = [
            'title' => 'ForgotPassword',
        ];


        return view('auth/forgotPassword/index', $data);
    }

    public function logout()
    {
        session()->destroy(); // hapus semua session
        return redirect()->to('/signin'); // arahkan ke login
    }

}