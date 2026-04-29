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

    public function getUserRoles($search = null, $roleFilter = null)
    {
        $query = $this->userRoleModel->select('user_nip, user_fullname, GROUP_CONCAT(roles.role_name SEPARATOR "|") as roles_list, GROUP_CONCAT(user_roles.id SEPARATOR "|") as ids_list')
            ->join('roles', 'roles.id = user_roles.role_id')
            ->groupBy('user_nip, user_fullname')
            ->orderBy('MAX(user_roles.created_at)', 'DESC');

        if ($search) {
            $query->groupStart()
                ->like('user_fullname', $search)
                ->orLike('user_nip', $search)
                ->groupEnd();
        }

        if ($roleFilter) {
            $query->whereIn('user_nip', function($dq) use ($roleFilter) {
                return $dq->select('user_nip')->from('user_roles')->where('role_id', $roleFilter);
            });
        }

        return [
            'data' => $query->paginate(15, 'user_roles'),
            'pager' => $query->pager
        ];
    }

    public function createRole(array $data)
    {
        return $this->roleModel->insert([
            'role_name' => strtoupper($data['role_name'])
        ]);
    }

    public function createUserMapping(array $data)
    {
        $users = $data['users'] ?? []; // Array of ['username' => ..., 'nip' => ...]
        $roles = $data['roles'] ?? []; // Array of role IDs

        if (empty($users) || empty($roles)) return false;

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($users as $user) {
            foreach ($roles as $role_id) {
                // Hindari duplikasi mapping
                $exist = $this->userRoleModel->where('user_nip', $user['nip'])
                    ->where('role_id', $role_id)
                    ->first();
                
                if (!$exist) {
                    $this->userRoleModel->insert([
                        'user_fullname' => $user['username'],
                        'user_nip'      => $user['nip'] ?? '-',
                        'role_id'       => $role_id
                    ]);
                }
            }
        }

        $db->transComplete();
        return $db->transStatus();
    }

    public function deleteUserMapping($id)
    {
        return $this->userRoleModel->delete($id);
    }
}
