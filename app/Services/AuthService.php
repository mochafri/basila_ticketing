<?php

namespace App\Services;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use App\Models\UserModel;

class AuthService
{
    protected $client;
    protected $get_role;

    public function __construct()
    {
        $this->client = Services::curlrequest();
        $this->get_role = env('URL_OPTION_ROLE');
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
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]);
                $profile = json_decode($response_profile->getBody(), true);

                // GET ROLE
                $response_role = $this->client->get($this->get_role, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]);
                $role = json_decode($response_role->getBody(), true);

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

            $userModel = new UserModel();

            $user = $userModel->where('username', $data['username'])->first();

            if (!$user || !password_verify($data['password'], $user['password'])) {
                throw new \Exception('Username atau password tidak valid.');
            }

            // Ambil token
            $getToken = env('URL_TOKEN');

            $response = $this->client->get($getToken);

            if ($response->getStatusCode() == 200) {
                $token = (string) $response->getBody();

                // GET ROLE
                $response_role = $this->client->get($this->get_role, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]);

                $data_role = json_decode($response_role->getBody(), true);

                return [
                    'data_role' => $data_role,
                    'token' => $token,
                    'profile' => [
                        'fullname' => $user['username'],
                        'numberid' => rand(10000000, 99999999),
                        'photo' => null
                    ]
                ];
            }
        }

        throw new \Exception('Gagal login lokal.');
    }
}