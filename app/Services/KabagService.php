<?php

namespace App\Services;

use App\Models\Tiket;
use App\Models\AssignTiket;
use App\Models\AssignTask;

class KabagService
{
    protected $tiketModel;
    protected $assignTiket;
    protected $assignTaskStaff;

    public function __construct()
    {
        $this->tiketModel = new Tiket();
        $this->assignTiket = new AssignTiket();
        $this->assignTaskStaff = new AssignTask();
    }

    # Update data tiket approve by kabag
    public function approveTiket(array $data, $id)
    {
        $db = \Config\Database::connect();

        $tiket = $this->tiketModel->find($id);

        if (!$tiket) {
            return [
                'status' => 'fail',
                'message' => 'Tiket tidak ada'
            ];
        }

        $db->transStart();

        $this->tiketModel->update($id, [
            'tiket_status' => 'Open',
            'approve_by' => $data['approve']
        ]);

        foreach ($data['assign_to_kaur'] as $index => $kaur) {
            $this->assignTiket->insert([
                'kaur_name' => $kaur,
                'nip_kaur' => $data['user_id'][$index] ?? null,
                'fk_tiket' => $id
            ]);
        }

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil approve tiket'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal approve tiket'
        ];
    }

    # Escalated service
    public function isEscalated($id)
    {
        $tiket = $this->tiketModel->find($id);

        if (!$tiket) {
            return [
                'status' => 'fail',
                'message' => 'Tiket tidak ada'
            ];
        }

        $update = $this->tiketModel->update($id, [
            'is_escalated' => true
        ]);

        return [
            'status' => $update ? 'success' : 'fail',
            'message' => $update ? 'Tiket berhasil di-eskalasi' : 'Gagal update tiket'
        ];
    }

    # Reject tiket
    public function rejectTiket($id)
    {
        log_message('info', 'PARAM SLUG: ' . $id);
        $tiket = $this->tiketModel->find($id);

        log_message('error', 'Hasil query : ' . json_encode($tiket));
        if (!$tiket) {
            return [
                'status' => 'fail',
                'message' => 'Tiket tidak ada'
            ];
        }

        $update = $this->tiketModel->update($id, [
            'tiket_status' => 'Rejected',
            // 'catatan' => $data['catatan']
        ]);

        return [
            'status' => $update ? 'success' : 'fail',
            'message' => $update ? 'Tiket berhasil di-reject' : 'Gagal update tiket'
        ];
    }
}
