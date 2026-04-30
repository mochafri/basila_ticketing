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
            tiket_on_progress.nip_receive_task, 
            tiket_on_progress.received_by as nama_staff,
            COUNT(tiket_on_progress.id) as total_tugas,
            SUM(CASE WHEN tiket_on_progress.task_status = "Selesai" THEN 1 ELSE 0 END) as tugas_selesai,
            SUM(CASE WHEN tiket_on_progress.task_status != "Selesai" THEN 1 ELSE 0 END) as tugas_belum_selesai,
            SUM(CASE 
                WHEN tiket_on_progress.task_status = "Selesai" AND tiket_on_progress.started_at IS NOT NULL AND tiket_on_progress.completed_at IS NOT NULL 
                THEN TIMESTAMPDIFF(MINUTE, tiket_on_progress.started_at, tiket_on_progress.completed_at) 
                ELSE 0 
            END) as total_durasi_menit
        ')->where('is_acc_from_kaur', false);

        if (!empty($filters['start_date'])) {
            $builder->where('tiket_on_progress.started_at >=', $filters['start_date'] . ' 00:00:00');
        }
        if (!empty($filters['end_date'])) {
            $builder->where('tiket_on_progress.started_at <=', $filters['end_date'] . ' 23:59:59');
        }
        if (!empty($filters['staff_nip'])) {
            $builder->where('tiket_on_progress.nip_receive_task', $filters['staff_nip']);
        }

        $builder->groupBy('tiket_on_progress.nip_receive_task, tiket_on_progress.received_by');
        
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
            tiket_on_progress.*,
            tikets.id as ticket_id,
            kategoris.kategori_layanan,
            layanans.per_kategori_layanan
        ');
        $builder->join('assign_to_kaur', 'assign_to_kaur.id = tiket_on_progress.fk_assign_to_kaur');
        $builder->join('tikets', 'tikets.id = assign_to_kaur.fk_tiket');
        $builder->join('kategoris', 'kategoris.id = tikets.id_kategori');
        $builder->join('layanans', 'layanans.id = tikets.id_layanan');
        $builder->where('tiket_on_progress.nip_receive_task', $nip);

        if (!empty($filters['status'])) {
            $builder->where('tiket_on_progress.task_status', $filters['status']);
        }

        return $builder->get()->getResultArray();
    }
}
