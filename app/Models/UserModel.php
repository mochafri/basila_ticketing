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
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ================= CAST =================

    protected function hidePassword(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        // single row
        if (is_array($data['data'])) {
            // kalau associative array (single row)
            if (isset($data['data']['password'])) {
                unset($data['data']['password']);
            }

            // kalau multiple rows
            foreach ($data['data'] as &$row) {
                if (is_array($row) && isset($row['password'])) {
                    unset($row['password']);
                }

                if (is_object($row) && isset($row->password)) {
                    unset($row->password);
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