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
            return ;
        }

        return $data ?? [];
    }
}
