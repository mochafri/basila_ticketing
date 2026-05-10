<?php

namespace App\Services;

use Config\Services;
use App\Models\UserModel;

class AuthService
{
    protected $client;
    protected $get_role;
    protected $user;

    public function __construct()
    {
        $this->client = Services::curlrequest();
        $this->get_role = env('URL_OPTION_ROLE');
        $this->user = new UserModel();
    }

    // ================= MAIN LOGIN =================
    public function login(array $data)
    {
        try {
            return $this->loginSso($data);
        } catch (\Exception $e) {
            return $this->loginLocal($data);
        }
    }

    // ================= LOGIN SSO =================
    public function loginSso(array $data)
    {
        $url = env('URL_SSO');
        $get_profile = env('URL_PROFILE');

        $response = $this->client->post($url, [
            'timeout' => 5,
            'form_params' => [
                'username' => $data['username'],
                'password' => $data['password'],
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody(), true);
            $token = $result['token'] ?? null;

            if ($token) {
                // GET PROFILE
                $response_profile = $this->client->get($get_profile, [
                    'timeout' => 5,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]);
                $profile = json_decode($response_profile->getBody(), true);

                // GET ROLE DARI API
                $response_role = $this->client->get($this->get_role, [
                    'timeout' => 5,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]);
                $api_roles = json_decode($response_role->getBody(), true);
                if (!is_array($api_roles)) $api_roles = [];

                // GET ROLE FROM LOCAL DATABASE (Mapping by Admin)
                $db = \Config\Database::connect();
                $mapped_roles = $db->table('user_roles')
                    ->select('roles.id, roles.role_name as role')
                    ->join('roles', 'roles.id = user_roles.role_id')
                    ->where('user_roles.user_nip', $profile['numberid'] ?? '-')
                    ->get()
                    ->getResultArray();

                // Gabungkan role API dan DB lokal (Mapping)
                $merged_roles = array_merge($api_roles, $mapped_roles);

                // Hilangkan duplikat berdasarkan ID
                $role = [];
                $seen_ids = [];
                foreach ($merged_roles as $r) {
                    if (isset($r['id']) && !in_array($r['id'], $seen_ids)) {
                        $role[] = $r;
                        $seen_ids[] = $r['id'];
                    }
                }

                return [
                    'data_role' => $role,
                    'token' => $token,
                    'profile' => $profile
                ];
            }
        }

        throw new \Exception('Username atau password tidak valid.');
    }

    // ================= LOGIN LOCAL =================
    public function loginLocal(array $data)
    {
        if (ENVIRONMENT === 'development') {
            $user = $this->user->where('username', $data['username'])->first();

            if (!$user || !password_verify($data['password'], $user['password'])) {
                throw new \Exception('Username atau password tidak valid.');
            }

            // GET ROLE FROM LOCAL DATABASE (Mapping by Admin)
            $db = \Config\Database::connect();
            $mapped_roles = $db->table('user_roles')
                ->select('roles.id, roles.role_name as role')
                ->join('roles', 'roles.id = user_roles.role_id')
                ->where('user_roles.user_nip', $user['nip'] ?? '-')
                ->get()
                ->getResultArray();

            return [
                'data_role' => $mapped_roles,
                'token' => 'local_token_' . rand(100000, 999999), // Dummy token lokal
                'profile' => [
                    'fullname' => $user['username'],
                    'numberid' => $user['nip'] ?? null,
                    'photo' => null,
                    'faculty' => null,
                    'studyprogram' => null
                ]
            ];
        }

        throw new \Exception('Gagal login lokal. Pastikan file .env mode development.');
    }
}