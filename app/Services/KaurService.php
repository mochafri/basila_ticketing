<?php

namespace App\Services;

class KaurService
{
    protected $kaur;
    protected $staff;
    protected $tiketModel;
    protected $assignTiket;
    protected $assignTaskStaff;
    protected $riwayatAktifitas;

    public function __construct()
    {
        $this->kaur = model('Kaur');
        $this->staff = model('Staff');
        $this->tiketModel = model('Tiket');
        $this->assignTiket = model('AssignTiket');
        $this->assignTaskStaff = model('AssignTask');
        $this->riwayatAktifitas = model('RiwayatAktifitas');
    }

    public function getStaff($nip)
    {
        $getId = $this->kaur->where('nip_kaur', $nip)->first();

        if (!isset($getId)) {
            return null;
        }

        $getStaff = $this->staff->where('fk_kaur', $getId['id'])->findAll();

        if (!isset($getStaff)) {
            return null;
        }

        return $getStaff;
    }

    # Service assign tugas tiket ke staff
    public function assignToStaff($id, array $data, $user_identifier)
    {
        $db = \Config\Database::connect();

        $idTiket = $this->assignTiket
            ->select('id,fk_tiket')
            ->where('fk_tiket', $id)
            ->where('nip_kaur', $user_identifier)
            ->first();

        if (!$idTiket) {
            return [
                'status' => 'failed',
                'message' => 'Tiket tidak ditemukan atau Anda tidak memiliki akses.'
            ];
        }

        $db->transStart();

        $hasDuplicate = false;
        $staff_on_skip = [];

        $insertedCount = 0;
        foreach ($data['assign_task_to_staff'] as $index => $staffName) {
            $nip = $data['user_id'][$index] ?? null;

            if (!$nip)
                continue;

            // Cek apakah staff sudah ditugaskan sebelumnya untuk tiket ini
            $existing = $this->assignTaskStaff
                ->where('fk_assign_to_kaur', $idTiket['id'])
                ->where('nip_staff', $nip)
                ->first();

            if ($existing) {
                $hasDuplicate = true;
                $staff_on_skip[] = $staffName;
                continue;
            }

            $this->assignTaskStaff->insert([
                'task_instruction' => $data['task_instruction'],
                'assign_task_to_staff' => $staffName,
                'nip_staff' => $nip,
                'fk_assign_to_kaur' => $idTiket['id'],
                'started_at' => date('Y-m-d H:i:s')
            ]);

            $this->riwayatAktifitas->insert([
                'activity_title' => 'Penugasan',
                'message' => 'Tiket ditugaskan kepada ' . $staffName,
                'created_by' => 'Kepala Urusan',
                'fk_tiket' => $id
            ]);

            $insertedCount++;
        }

        if ($insertedCount === 0) {
            $db->transRollback();
            return [
                'status' => 'failed',
                'message' => 'Gagal memberikan tugas. Staf yang dipilih sudah ditugaskan sebelumnya.'
            ];
        }

        $this->tiketModel->update($idTiket['fk_tiket'], [
            'tiket_status' => 'In Progress'
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil assign ke staff',
            'duplicates' => $staff_on_skip
        ] : [
            'status' => 'failed',
            'message' => 'Gagal assign ke staff'
        ];
    }

    # Kaur verifikasi kerja staff
    public function approveTask($idTiket, $nip)
    {
        $db = \Config\Database::connect();

        $kaur = $this->assignTiket
            ->select('id,fk_tiket,nip_kaur')
            ->where('fk_tiket', $idTiket)
            ->where('nip_kaur', $nip)
            ->first();

        if (!$kaur) {
            return [
                'status' => 'fail',
                'message' => 'User tidak ditemukan'
            ];
        }

        $db->transStart();

        $update = $this->assignTiket->update($kaur['id'], [
            'flag' => 'Start'
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update penugasan'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Penugasan',
            'message' => 'Kepala Urusan menerima penugasan.',
            'created_by' => 'Kepala Urusan',
            'fk_tiket' => $idTiket,
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil menerima tugas'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menerima tugas'
        ];
    }

    public function getTaskStaffOnKaur($idTiket, $nipKaur)
    {
        return $this->assignTaskStaff
            ->select('
                assign_to_staff.id, assign_to_staff.task_instruction, assign_to_staff.task_status, 
                assign_to_staff.taks_dokumen, assign_to_staff.catatan_laporan_penyelesaian,
                assign_to_staff.assign_task_to_staff, assign_to_staff.nip_staff,assign_to_staff.fk_assign_to_kaur, assign_to_staff.is_downloadable,
                assign_to_staff.started_at, assign_to_staff.completed_at,
                assign_to_kaur.kaur_name, assign_to_kaur.fk_tiket as id_tiket,
                tikets.judul_permohonan, tikets.tiket_status
            ')
            ->join('assign_to_kaur', 'assign_to_kaur.id = assign_to_staff.fk_assign_to_kaur')
            ->join('tikets', 'tikets.id = assign_to_kaur.fk_tiket')
            ->where('assign_to_kaur.fk_tiket', $idTiket)
            ->where('assign_to_kaur.nip_kaur', $nipKaur)
            ->findAll();
    }

    public function getAllTaskStaffByTiket($idTiket)
    {
        return $this->assignTaskStaff
            ->select('
                assign_to_staff.id, assign_to_staff.task_instruction, assign_to_staff.task_status, assign_to_staff.is_downloadable,
                assign_to_staff.taks_dokumen, assign_to_staff.catatan_laporan_penyelesaian,
                assign_to_staff.assign_task_to_staff,assign_to_staff.fk_assign_to_kaur,
                assign_to_staff.started_at, assign_to_staff.completed_at,
                assign_to_kaur.kaur_name, assign_to_kaur.fk_tiket as id_tiket,
                tikets.judul_permohonan, tikets.tiket_status
            ')
            ->join('assign_to_kaur', 'assign_to_kaur.id = assign_to_staff.fk_assign_to_kaur')
            ->join('tikets', 'tikets.id = assign_to_kaur.fk_tiket')
            ->where('assign_to_kaur.fk_tiket', $idTiket)
            ->findAll();
    }

    public function verifikasiTask($taskId)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $task = $this->assignTaskStaff
            ->join('assign_to_kaur', 'assign_to_kaur.id = assign_to_staff.fk_assign_to_kaur')
            ->select('assign_to_staff.id, assign_to_kaur.fk_tiket')
            ->find($taskId);

        $update = $this->assignTaskStaff->update($taskId, [
            'task_status' => 'Selesai'
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update tugas'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Verifikasi Tugas',
            'message' => 'Kepala Urusan telah memverifikasi pekerjaan staf.',
            'created_by' => 'Kepala Urusan',
            'fk_tiket' => $task['id'],
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Tugas berhasil diverifikasi.'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal memverifikasi tugas.'
        ];
    }

    public function revisiTask($taskId)
    {
        $db = \Config\Database::connect();

        $task = $this->assignTaskStaff
            ->join('assign_to_kaur', 'assign_to_kaur.id = assign_to_staff.fk_assign_to_kaur')
            ->select('assign_to_staff.id, assign_to_kaur.fk_tiket')
            ->find($taskId);

        if (!$task) {
            return [
                'status' => 'fail',
                'message' => 'Data tidak ditemukan.'
            ];
        }

        $db->transStart();

        $update = $this->assignTaskStaff->update($taskId, [
            'task_status' => 'Revisi'
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update tugas'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Revisi Tugas',
            'message' => 'Tugas dikembalikan untuk direvisi oleh Kepala Urusan.',
            'created_by' => 'Kepala Urusan',
            'fk_tiket' => $task['fk_tiket'],
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil,Tugas direvisi.'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal,Tugas direvisi.'
        ];
    }

    # Service kaur menyelesaikan semua tugas staff
    public function selesaikanTugasKaur($idTiket, $nipKaur)
    {
        $db = \Config\Database::connect();

        $assignTiket = $this->assignTiket
            ->where('fk_tiket', $idTiket)
            ->where('nip_kaur', $nipKaur)
            ->first();

        if (!$assignTiket) {
            return [
                'status' => 'fail',
                'message' => 'Data penugasan tidak ditemukan.'
            ];
        }

        $staffTasks = $this->assignTaskStaff
            ->select('id,task_status')
            ->where('fk_assign_to_kaur', $assignTiket['id'])
            ->findAll();

        if (empty($staffTasks)) {
            return [
                'status' => 'fail',
                'message' => 'Belum ada staf yang ditugaskan.'
            ];
        }

        foreach ($staffTasks as $task) {
            if ($task['task_status'] !== 'Selesai') {
                return [
                    'status' => 'fail',
                    'message' => 'Masih ada pekerjaan staf yang belum selesai. Mohon verifikasi seluruh pekerjaan staf terlebih dahulu.'
                ];
            }
        }

        $db->transStart();

        $update = $this->assignTiket->update($assignTiket['id'], [
            'flag' => 'Finish',
            'completed_at' => date('Y-m-d H:i:s')
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update penugasan'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Tugas Selesai',
            'message' => 'Seluruh pekerjaan telah diselesaikan oleh Kepala Urusan.',
            'created_by' => 'Kepala Urusan',
            'fk_tiket' => $idTiket,
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil menyelesaikan penugasan tiket.'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menyelesaikan penugasan tiket.'
        ];
    }

    public function updateInstruction($taskId, $instruction)
    {
        $db = \Config\Database::connect();

        # Untuk mendapatkan id tiket 
        $task = $this->assignTaskStaff
            ->join('assign_to_kaur', 'assign_to_kaur.id = assign_to_staff.fk_assign_to_kaur')
            ->select('assign_to_staff.id, assign_to_kaur.fk_tiket')
            ->find($taskId);

        $db->transStart();

        $update = $this->assignTaskStaff->update($taskId, [
            'task_instruction' => $instruction
        ]);

        if (!$update) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update instruksi'
            ];
        }

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Update Instruksi',
            'message' => 'Instruksi penugasan diperbarui oleh Kepala Urusan.',
            'created_by' => 'Kepala Urusan',
            'fk_tiket' => $task['fk_tiket'],
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil mengubah instruksi.'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal mengubah instruksi.'
        ];
    }
}
