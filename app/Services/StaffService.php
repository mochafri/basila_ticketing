<?php

namespace App\Services;

class StaffService
{
    protected $assignTaskStaff;
    protected $assignTiket;
    protected $riwayatAktifitas;

    public function __construct()
    {
        $this->assignTaskStaff = model('AssignTask');
        $this->assignTiket = model('AssignTiket');
        $this->riwayatAktifitas = model('RiwayatAktifitas');
    }

    public function getTaskStaff($id, $nip)
    {
        $getID = $this->assignTiket->where('fk_tiket', $id)->first();

        if (!isset($getID)) {
            return [];
        }

        $data = $this->assignTaskStaff
            ->select('tiket_on_progress.*, assign_to_kaur.completed_at as kaur_completed_at, assign_to_kaur.started_at as kaur_started_at, assign_to_kaur.kaur_name, assign_to_kaur.flag as kaur_flag')
            ->join('assign_to_kaur', 'assign_to_kaur.id = tiket_on_progress.fk_assign_to_kaur')
            ->where('assign_to_kaur.fk_tiket', $id)
            ->where('tiket_on_progress.nip_receive_task', $nip)
            ->first();

        return $data ?? [];
    }

    # Update task juga berlaku untuk kaur meng update tugas yang dikerjakan nya,jika tiket dikerjakan sendiri
    public function updateTask($id, array $data, $file, $nip)
    {
        $db = \Config\Database::connect();

        $staffData = $this->assignTaskStaff
            ->select('tiket_on_progress.id, tiket_on_progress.is_acc_from_kaur, tiket_on_progress.fk_assign_to_kaur')
            ->join('assign_to_kaur', 'assign_to_kaur.id = tiket_on_progress.fk_assign_to_kaur')
            ->where('assign_to_kaur.fk_tiket', $id)
            ->where('tiket_on_progress.nip_receive_task', $nip)
            ->first();

        if (!$staffData) {
            return [
                'status' => 'fail',
                'message' => 'Data penugasan tidak ditemukan'
            ];
        }

        # Jika dikerjakan sendiri oleh kaur, status langsung Selesai. Jika staff, Menunggu Approve.
        $isKaurMandiri = (isset($staffData['is_acc_from_kaur']) && (int)$staffData['is_acc_from_kaur'] === 1);

        $updateData = [
            'task_status' => $isKaurMandiri ? 'Selesai' : 'Menunggu Approve',
            'catatan_laporan_penyelesaian' => $data['laporan_task'],
            'catatan_revisi' => null,
            'is_downloadable' => $data['is_downloadable'] ?? 1,
            'completed_at' => date('Y-m-d H:i:s')
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $updateData['taks_dokumen'] = $file->getRandomName();
            $updateData['original_task_name'] = $file->getClientName();
            $file->move(WRITEPATH . 'uploads/tiket/admin/', $updateData['taks_dokumen']);
        }

        $db->transStart();

        $result = $this->assignTaskStaff->update($staffData['id'], $updateData);

        if (!$result) {
            $db->transRollback();
            return [
                'status' => 'fail',
                'message' => 'Gagal update tugas'
            ];
        }

        # Jika tiket dikerjakan oleh kaur, otomatis selesaikan juga penugasan Kaur-nya (flag = Finish)
        if($isKaurMandiri){
            
            $this->assignTiket->builder()
                ->where('id', $staffData['fk_assign_to_kaur'])
                ->update([
                    'flag' => 'Finish',
                    'completed_at' => date('Y-m-d H:i:s')
                ]);

            $this->riwayatAktifitas->insert([
                'activity_title' => 'Tugas Selesai',
                'message' => 'Kepala Urusan telah menyelesaikan tugas mandiri dan mengunggah laporan penyelesaian.',
                'created_by' => 'Kepala Urusan',
                'fk_tiket' => $id
            ]);
        } else {
            $this->riwayatAktifitas->insert([
                'activity_title' => 'Laporan Tugas',
                'message' => 'Staf telah mengunggah laporan penyelesaian tugas.',
                'created_by' => 'Staf',
                'fk_tiket' => $id
            ]);
        }

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => $isKaurMandiri ? 'Berhasil menyelesaikan tugas mandiri' : 'Berhasil upload tugas'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal upload tugas'
        ];
    }
}
