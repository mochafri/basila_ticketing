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
        $data = $this->riwayatModel->where('fk_tiket', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        if (!$data) {
            return [];
        }

        return $data;
    }

    public function addLog($id, $title, $message, $createdBy, $createdById = null, $file = null)
    {
        $data = [
            'fk_tiket' => $id,
            'activity_title' => $title,
            'message' => $message,
            'created_by' => $createdBy,
            'created_by_id' => $createdById
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $data['attachment'] = $newName;
            $data['original_attachment_name'] = $file->getClientName();
            $file->move(WRITEPATH . 'uploads/tiket/admin/', $newName);
        }

        return $this->riwayatModel->insert($data);
    }
}
