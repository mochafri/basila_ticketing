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
            return null;
        }

        $data = $this->assignTaskStaff
            ->where('fk_assign_to_kaur', $getID['id'])
            ->where('nip_staff', $nip)
            ->first();

        return $data ?? null;
    }

    public function updateTask($id, array $data, $file, $nip)
    {
        $staffData = $this->assignTaskStaff
            ->select('assign_to_staff.id')
            ->join('assign_to_kaur', 'assign_to_kaur.id = assign_to_staff.fk_assign_to_kaur')
            ->where('assign_to_kaur.fk_tiket', $id)
            ->where('assign_to_staff.nip_staff', $nip)
            ->first();

        if (!$staffData) {
            return [
                'status' => 'fail',
                'message' => 'Data penugasan staff tidak ditemukan'
            ];
        }

        $updateData = [
            'task_status' => 'Menunggu Approve',
            'catatan_laporan_penyelesaian' => $data['laporan_task']
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $updateData['taks_dokumen'] = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/tiket/admin/', $updateData['taks_dokumen']);
        }

        $result = $this->assignTaskStaff->update($staffData['id'], $updateData);

        if ($result) {
            $this->riwayatAktifitas->insert([
                'activity_title' => 'Laporan Tugas',
                'message' => 'Staf telah mengunggah laporan penyelesaian tugas.',
                'created_by' => 'Staf',
                'fk_tiket' => $id
            ]);
        }

        return [
            'status' => $result ? 'success' : 'fail',
            'message' => $result ? 'Berhasil upload tugas' : 'Gagal upload tugas'
        ];
    }
}
