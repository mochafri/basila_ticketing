<?php

namespace App\Services;

class KabagService
{
    protected $kaur;
    protected $tiketModel;
    protected $assignTiket;
    protected $assignTaskStaff;
    protected $riwayatAktifitas;

    public function __construct()
    {
        $this->kaur = model('Kaur');
        $this->tiketModel = model('Tiket');
        $this->assignTiket = model('AssignTiket');
        $this->assignTaskStaff = model('AssignTask');
        $this->riwayatAktifitas = model('RiwayatAktifitas');
    }

    public function getKaur()
    {
        return $this->kaur->findAll();
    }

    # Update data tiket approve by kabag
    public function assignTiket(array $data, $id)
    {
        $db = \Config\Database::connect();

        $tiket = $this->tiketModel->find($id);

        if (!$tiket) {
            return [
                'status' => 'fail',
                'message' => 'Tiket tidak ada'
            ];
        }

        $hasDuplicate = false;
        $kaur_on_skip = [];

        $db->transStart();

        $now = date('Y-m-d H:i:s');
        
        $this->tiketModel->update($id, [
            'tiket_status' => 'Open',
            'approve_by' => $data['approve'],
            'level_kesulitan' => $data['level_kesulitan'] ?? null,
        ]);

        $insertedCount = 0;
        foreach ($data['assign_to_kaur'] as $index => $kaur) {
            $nip = $data['user_id'][$index] ?? null;

            if (!$nip)
                continue;

            $exist = $this->assignTiket
                ->where('nip_kaur', $nip)
                ->where('fk_tiket', $id)
                ->first();

            if ($exist) {
                $hasDuplicate = true;
                $kaur_on_skip[] = $kaur;
                continue;
            }

            $this->assignTiket->insert([
                'kaur_name' => $kaur,
                'nip_kaur' => $nip,
                'fk_tiket' => $id,
                'started_at' => $now
            ]);

            $insertedCount++;
        }

        if ($insertedCount === 0) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal menyetujui tiket. Kaur yang dipilih sudah ditugaskan sebelumnya.'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Persetujuan Tiket',
            'message' => 'Tiket telah disetujui oleh Kepala Bagian.',
            'created_by' => 'Kepala Bagian',
            'fk_tiket' => $id
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil approve tiket',
            'duplicates' => $kaur_on_skip
        ] : [
            'status' => 'fail',
            'message' => 'Gagal approve tiket'
        ];
    }

    # Buat wrapper nya kaur di kabag page
    public function getKaurByTiketOpen($id)
    {
        return $this->assignTiket
            ->select('assign_to_kaur.*')
            ->join('tikets', 'tikets.id = assign_to_kaur.fk_tiket')
            ->where('assign_to_kaur.fk_tiket', $id)
            ->whereIn('tikets.tiket_status', ['Open', 'In Progress', 'Closed'])
            ->findAll();
    }

    # Escalated service
    public function isEscalated($id)
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

        $update = $this->tiketModel->update($id, [
            'is_escalated' => true,
            'tiket_status' => 'Escalated Process',
            'level_kesulitan' => 'high'
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update tiket'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Tiket diterima',
            'message' => 'Tiket di eskalasi oleh kepala bagian.',
            'created_by' => 'Kepala Bagian',
            'fk_tiket' => $id
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Tiket berhasil di-eskalasi'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal update tiket'
        ];
    }

    # Service Reject tiket 
    public function rejectTiket($id, $data)
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

        $update = $this->tiketModel->update($id, [
            'tiket_status' => 'Rejected',
            'catatan' => $data
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update tiket'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Penolakan Tiket',
            'message' => 'Tiket telah ditolak oleh Kepala Bagian.',
            'created_by' => 'Kepala Bagian',
            'fk_tiket' => $id
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Tiket berhasil di-reject'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal update tiket'
        ];
    }

    # Service closed tiket oleh kabag
    public function tutupTiket($id)
    {
        $db = \Config\Database::connect();

        $taskKaur = $this->assignTiket
            ->select('id,flag,kaur_name')
            ->where('fk_tiket', $id)
            ->findAll();

        $anyFinished = false;
        foreach ($taskKaur as $kaur) {
            if ($kaur['flag'] === 'Finish') {
                $anyFinished = true;
                break;
            }
        }

        if (!$anyFinished) {
            return [
                'status' => 'fail',
                'message' => "Belum ada Kepala Urusan (Kaur) yang menyelesaikan tugasnya."
            ];
        }

        $db->transStart();

        $update = $this->tiketModel->update($id, [
            'tiket_status' => 'Closed',
            'completed_at'    => date('Y-m-d H:i:s')
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update tiket'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Tiket Selesai',
            'message' => 'Tiket telah diselesaikan oleh Kepala Bagian.',
            'created_by' => 'Kepala Bagian',
            'fk_tiket' => $id
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Tiket telah ditutup dan dinyatakan Selesai'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menutup tiket.'
        ];
    }

    public function tolakHasilKaur($assignKaurId, $catatan = null)
    {
        $db = \Config\Database::connect();

        $assign = $this->assignTiket->find($assignKaurId);

        if (!$assign) {
            return [
                'status' => 'fail',
                'message' => 'Data penugasan tidak ditemukan'
            ];
        }

        $db->transStart();

        # Update flag kaur spesifik menjadi Revisi dan simpan catatan
        $update = $this->assignTiket->update($assignKaurId, [
            'flag' => 'Revisi',
            'catatan_revisi' => $catatan
        ]);

        # Update status task
        $this->assignTaskStaff->builder()
            ->where('fk_assign_to_kaur', $assignKaurId)
            ->update([
                'task_status' => 'Revisi',
                'catatan_revisi' => $catatan
            ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal mengubah status tugas'
            ];
        }

        # Kembalikan status tiket menjadi In Progress (Gunakan builder agar tidak error jika status sudah In Progress)
        $this->tiketModel->builder()
            ->where('id', $assign['fk_tiket'])
            ->update([
                'tiket_status' => 'In Progress'
            ]);

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Revisi Hasil Pekerjaan',
            'message' => "Kepala Bagian meminta revisi kepada {$assign['kaur_name']} dengan catatan: \"{$catatan}\"",
            'created_by' => 'Kepala Bagian',
            'fk_tiket' => $assign['fk_tiket']
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Tugas berhasil dikembalikan untuk direvisi'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal memproses revisi'
        ];
    }
}
