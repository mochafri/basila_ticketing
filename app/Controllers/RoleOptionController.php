<?php

namespace App\Controllers;

class RoleOptionController extends BaseController
{
    public function index()
    {
        return view('auth/roleOption/index');
    }

    public function chooseRole()
    {
        $rules = [
            'role_id' => 'required|integer',
            'role_name' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('validation', $this->validator->getErrors())
                ->withInput();
        }

        $roleId = $this->request->getPost('role_id');
        $roleName = $this->request->getPost('role_name');

        session()->set([
            'role_id' => $roleId,
            'role_name' => $roleName
        ]);

        return redirect()->to('/dashboard');
    }
}