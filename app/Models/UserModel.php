<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'password',
    ];

    // ================= TIMESTAMP =================
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ================= CAST =================
    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ================= HIDE PASSWORD =================
    protected $afterFind = ['hidePassword'];

    protected function hidePassword(array $data)
    {
        // single row
        if (isset($data['data']['password'])) {
            unset($data['data']['password']);
        }

        // multiple rows
        if (isset($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as &$row) {
                if (isset($row['password'])) {
                    unset($row['password']);
                }
            }
        }

        return $data;
    }

    // ================= AUTO HASH PASSWORD =================
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}