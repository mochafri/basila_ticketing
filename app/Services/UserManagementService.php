<?php

namespace App\Services;

class UserManagementService
{
    protected $roleModel;
    protected $userRoleModel;
    protected $userModel;

    public function __construct()
    {
        $this->roleModel = model('RoleModel');
        $this->userRoleModel = model('UserRoleModel');
        $this->userModel = model('UserModel');
    }

    public function getUsers()
    {
        return $this->userModel->select('username, nip')->findAll();
    }

    public function getRoles()
    {
        return $this->roleModel->findAll();
    }

    public function getUserRoles()
    {
        return $this->userRoleModel->getUserRoles();
    }

    public function createRole(array $data)
    {
        return $this->roleModel->insert([
            'role_name' => strtoupper($data['role_name'])
        ]);
    }

    public function createUserMapping(array $data)
    {
        return $this->userRoleModel->insert([
            'user_fullname' => $data['username'],
            'user_nip'      => $data['nip'] ?? '-',
            'role_id'       => $data['role_id']
        ]);
    }

    public function deleteUserMapping($id)
    {
        return $this->userRoleModel->delete($id);
    }
}
