<?php

namespace App\Services;

class EskalasiService
{
    protected $tiketModel;
    protected $riwayatAktifitas;

    public function __construct()
    {
        $this->tiketModel = model('Tiket');
        $this->riwayatAktifitas = model('RiwayatAktifitas');
    }

    public function approveEscalated($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $this->tiketModel->update($id, [
            'tiket_status' => 'Open'
        ]);

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Persetujuan Eskalasi',
            'message' => 'Eskalasi tiket telah disetujui.',
            'created_by' => 'Pak tora',
            'fk_tiket' => $id
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Eskalasi tiket disetujui'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menyetujui eskalasi'
        ];
    }

    public function rejectEscalated($id, $data)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $this->tiketModel->update($id, [
            'tiket_status' => 'Reject',
            'catatan' => $data
        ]);

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Tiket ditolak',
            'message' => 'Tiket ditolak saat proses eskalasi.',
            'created_by' => 'Pak tora',
            'fk_tiket' => $id
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Eskalasi tiket ditolak'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menolak eskalasi'
        ];
    }
}
