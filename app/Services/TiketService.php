<?php

namespace App\Services;

use App\Models\Tiket;
use App\Models\AssignTiket;
use App\Models\AssignTask;

class TiketService
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

    # Bagian get all data tiket
    public function getDataTiket()
    {
        return $this->tiketModel
            ->select(
                'tikets.id, tikets.judul_permohonan, tikets.deskripsi_permohonan, tikets.tiket_status, tikets.created_at, 
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan'
            )
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = layanans.fk_kategori', 'left')
            ->findAll();
    }

    # Bagian get detail tiket
    public function showTiket($id)
    {
        return $this->tiketModel
            ->select('
                tikets.id, tikets.judul_permohonan, tikets.deskripsi_permohonan, 
                tikets.tiket_status, tikets.created_at, tikets.dokumen_lampiran, 
                tikets.original_dokumen_name,
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan
            ')
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = layanans.fk_kategori', 'left')
            ->find($id);
    }

    # Create data tiket
    public function create(array $data, $file, $username)
    {
        $filePath = null;
        $originalName = null;

        if (!empty($file) && $file->isValid()) {
            $newName = $file->getRandomName();
            $originalName = $file->getClientName();

            $uploadPath = WRITEPATH . 'uploads/tiket/users/';
            $file->move($uploadPath, $newName);

            $filePath = $newName;
        }

        $insertData = $this->tiketModel->insert([
            'judul_permohonan' => $data['judul'],
            'deskripsi_permohonan' => $data['deskripsi'],
            'id_kategori' => $data['kategori'],
            'id_layanan' => $data['layanan'],
            'dokumen_lampiran' => $filePath,
            'original_dokumen_name' => $originalName
        ]);

        if ($insertData) {
            service('riwayat')->create([
                'activity_title' => 'Pengajuan Tiket',
                'message' => 'Pengajuan Tiket oleh ' . $username,
                'created_by' => $username,
            ]);
        }

        return $insertData ? [
            'status' => 'success',
            'message' => 'Berhasil menambahkan tiket'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menambahkan tiket'
        ];
    }

    # Kaur service
    public function approveTask($idTiket)
    {
        $kaur = $this->assignTiket
            ->where('fk_tiket', $idTiket)
            ->where('nip_kaur', '1987654321')
            ->first();

        if (!$kaur) {
            return [
                'status' => 'fail',
                'message' => 'User tidak ditemukan'
            ];
        }

        $this->assignTiket->update($kaur['id'], [
            'flag' => 'Approve'
        ]);

        return [
            'status' => 'success',
            'message' => 'Berhasil menerima tugas'
        ];
    }

    public function assignToStaff($id, array $data, $user_identifier)
    {
        $db = \Config\Database::connect();

        $idTiket = $this->assignTiket->select('id,fk_tiket')->where('fk_tiket', $id)->first();

        $db->transStart();

        foreach ($data['assign_task_to_staff'] as $index => $staffName) {
            $this->assignTaskStaff->insert([
                'task_instruction' => $data['task_instruction'],
                'assign_task_to_staff' => $staffName,
                'nip_staff' => $data['user_id'][$index] ?? null,
                'fk_assign_tiket' => $idTiket['id']
            ]);
        }

        $this->tiketModel->update($idTiket['fk_tiket'], [
            'tiket_status' => 'In Progress'
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return [
                'status' => 'failed',
                'message' => 'Gagal assign ke staff'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Berhasil assign ke staff'
        ];
    }

    public function getTaskStaff($id, $nip)
    {
        $getID = $this->assignTiket->where('fk_tiket', $id)->first();

        if (!isset($getID)) {
            return null;
        }

        $data = $this->assignTaskStaff
            ->where('fk_assign_tiket', $getID['id'])
            ->where('nip_staff', $nip)
            ->first();

        return $data ?? null;
    }

    public function updateTask($id, array $data, $file)
    {
        $staffData = $this->assignTaskStaff
            ->select('assign_to_staff.id')
            ->join('assign_tiket', 'assign_tiket.id = assign_to_staff.fk_assign_tiket')
            ->where('assign_tiket.fk_tiket', $id)
            ->first();

        if (!$staffData)
            return [
                'status' => 'fail',
                'message' => 'Data penugasan staff tidak ditemukan'
            ];

        $updateData = [
            'task_status' => 'Menunggu Approve',
            'catatan_laporan_penyelesaian' => $data['laporan_task']
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $updateData['taks_dokumen'] = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/tiket/admin/', $updateData['taks_dokumen']);
        }

        $result = $this->assignTaskStaff->update($staffData['id'], $updateData);

        return ['status' => $result ? 'success' : 'fail', 'message' => $result ? 'Berhasil upload tugas' : 'Gagal upload tugas'];
    }

    public function getTaskKaurByTiket($idTiket, $nipKaur)
    {
        return $this->assignTaskStaff
            ->select('
                assign_to_staff.id, assign_to_staff.task_instruction, assign_to_staff.task_status, 
                assign_to_staff.taks_dokumen, assign_to_staff.catatan_laporan_penyelesaian,
                assign_to_staff.assign_task_to_staff, assign_to_staff.nip_staff,
                assign_tiket.kaur_name, assign_tiket.fk_tiket as id_tiket,
                tikets.judul_permohonan, tikets.tiket_status
            ')
            ->join('assign_tiket', 'assign_tiket.id = assign_to_staff.fk_assign_tiket')
            ->join('tikets', 'tikets.id = assign_tiket.fk_tiket')
            ->where('assign_tiket.fk_tiket', $idTiket)
            ->where('assign_tiket.nip_kaur', $nipKaur)
            ->findAll();
    }

    public function verifikasiTask($taskId)
    {
        $update = $this->assignTaskStaff->update($taskId, [
            'task_status' => 'Selesai'
        ]);

        return [
            'status' => $update ? 'success' : 'fail',
            'message' => $update ? 'Berhasil memverifikasi tugas.' : 'Gagal memverifikasi tugas.'
        ];
    }

    public function revisiTask($taskId)
    {
        $update = $this->assignTaskStaff->update($taskId, [
            'task_status' => 'Revisi'
        ]);

        return [
            'status' => $update ? 'success' : 'fail',
            'message' => $update ? 'Berhasil mengembalikan tugas untuk direvisi.' : 'Gagal mengembalikan tugas untuk direvisi.'
        ];
    }

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
            ->where('fk_assign_tiket', $assignTiket['id'])
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

        $this->assignTiket->update($assignTiket['id'], [
            'flag' => 'Selesai'
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return [
                'status' => 'fail',
                'message' => 'Gagal menyelesaikan penugasan tiket.'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Berhasil menyelesaikan penugasan tiket.'
        ];
    }

    public function tutupTiket($id)
    {
        $this->tiketModel->update($id, [
            'tiket_status' => 'Closed'
        ]);

        return [
            'status' => 'success',
            'message' => 'Tiket telah ditutup dan dinyatakan Selesai'
        ];
    }
}
