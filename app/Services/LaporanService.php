<?php

namespace App\Services;

class LaporanService
{
    protected $assignTaskStaff;
    protected $staffModel;

    public function __construct()
    {
        $this->assignTaskStaff = model('AssignTask');
        $this->staffModel = model('Staff');
    }

    public function getKinerjaStaff($filters = [])
    {
        $builder = $this->assignTaskStaff->builder();
        $builder->select('
            assign_to_staff.nip_staff, 
            assign_to_staff.assign_task_to_staff as nama_staff,
            COUNT(assign_to_staff.id) as total_tugas,
            SUM(CASE WHEN assign_to_staff.task_status = "Selesai" THEN 1 ELSE 0 END) as tugas_selesai,
            SUM(CASE WHEN assign_to_staff.task_status != "Selesai" THEN 1 ELSE 0 END) as tugas_belum_selesai,
            SUM(CASE 
                WHEN assign_to_staff.task_status = "Selesai" AND assign_to_staff.started_at IS NOT NULL AND assign_to_staff.completed_at IS NOT NULL 
                THEN TIMESTAMPDIFF(MINUTE, assign_to_staff.started_at, assign_to_staff.completed_at) 
                ELSE 0 
            END) as total_durasi_menit
        ');

        if (!empty($filters['start_date'])) {
            $builder->where('assign_to_staff.started_at >=', $filters['start_date'] . ' 00:00:00');
        }
        if (!empty($filters['end_date'])) {
            $builder->where('assign_to_staff.started_at <=', $filters['end_date'] . ' 23:59:59');
        }
        if (!empty($filters['staff_nip'])) {
            $builder->where('assign_to_staff.nip_staff', $filters['staff_nip']);
        }

        $builder->groupBy('assign_to_staff.nip_staff, assign_to_staff.assign_task_to_staff');
        
        $data = $builder->get()->getResultArray();

        foreach ($data as &$row) {
            $row['avg_durasi_menit'] = $row['tugas_selesai'] > 0 ? ($row['total_durasi_menit'] / $row['tugas_selesai']) : 0;
        }

        return $data;
    }

    public function getDetailKinerja($nip, $filters = [])
    {
        $builder = $this->assignTaskStaff->builder();
        $builder->select('
            assign_to_staff.*,
            tikets.id as ticket_id,
            tikets.judul_permohonan,
            kategoris.kategori_layanan,
            layanans.per_kategori_layanan
        ');
        $builder->join('assign_to_kaur', 'assign_to_kaur.id = assign_to_staff.fk_assign_to_kaur');
        $builder->join('tikets', 'tikets.id = assign_to_kaur.fk_tiket');
        $builder->join('kategoris', 'kategoris.id = tikets.id_kategori', 'left');
        $builder->join('layanans', 'layanans.id = tikets.id_layanan', 'left');
        $builder->where('assign_to_staff.nip_staff', $nip);

        if (!empty($filters['status'])) {
            $builder->where('assign_to_staff.task_status', $filters['status']);
        }

        return $builder->get()->getResultArray();
    }
}
