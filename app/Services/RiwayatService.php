<?php

namespace App\Services;

use App\Models\RiwayatAktifitas;

class RiwayatService
{
    protected $riwayatModel;

    public function __construct()
    {
        $this->riwayatModel = new RiwayatAktifitas();
    }

    public function getRiwayat($id)
    {
        $data = $this->riwayatModel->where('fk_tiket', $id)->findAll();

        if (!$data) {
            throw new \Exception('data tidak ada.');
        }

        return $data ?? [];
    }

    public function create(array $data)
    {
        $this->riwayatModel->insert([
            'activity_title' => $data['activity_title'],
            'message' => $data['message'],
            'created_by' => $data['created_by'],
        ]);
    }
}
