<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $table = 'user_roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_nip', 'user_fullname', 'role_id'];
    protected $useTimestamps = true;

    public function getUserRoles()
    {
        return $this->select('user_roles.*, roles.role_name')
            ->join('roles', 'roles.id = user_roles.role_id')
            ->findAll();
    }
}
