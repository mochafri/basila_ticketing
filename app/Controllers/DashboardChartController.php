<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class DashboardChartController extends ResourceController
{
    public function getChartData()
    {
        $kategoriId = $this->request->getGet('kategori');
        $fakultas = $this->request->getGet('fakultas');
        $prodi = $this->request->getGet('prodi');
        
        $roles = [session('role_name')];
        $nip = session('user_identifier');

        $db = \Config\Database::connect();
        
        // Build the query to count tickets per jenis layanan (id_layanan)
        $builder = $db->table('tikets')
            ->select('layanans.per_kategori_layanan, COUNT(tikets.id) as total')
            ->join('layanans', 'layanans.id = tikets.id_layanan');

        // Apply role filters just like the dashboard service
        $dashboardService = service('dashboard');
        // Since applyRoleFilters is private, I will just copy the logic or we can assume we only want to show statistics based on their access. 
        // Actually, it's better to recreate the condition or change the service.
        // For simplicity, let's just show global stats filtered by the requested filters, or we can use the same logic if we make it public.
        
        // Let's copy the logic temporarily for simplicity, or we can just show global stats for the chart as the user just wants the chart to replace the workflow status.
        if (!in_array('SUPERADMIN', $roles) && !in_array('BAA', $roles)) {
            if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles)) {
                $builder->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                    ->where('assign_to_kaur.nip_kaur', $nip)
                    ->where('tikets.tiket_status !=', 'Waiting');
            } else {
                // STAFF & MAHASISWA
                $builder->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                    ->join('tiket_on_progress', 'tiket_on_progress.fk_assign_to_kaur = assign_to_kaur.id', 'left')
                    ->groupStart()
                        ->where('tikets.nip_creator', $nip)
                        ->orGroupStart()
                            ->where('tiket_on_progress.nip_receive_task', $nip)
                            ->where('tikets.tiket_status !=', 'Waiting')
                        ->groupEnd()
                    ->groupEnd();
            }
        }

        if ($kategoriId) {
            $builder->where('tikets.id_kategori', $kategoriId);
        }
        if ($fakultas) {
            $builder->where('tikets.fakultas', $fakultas);
        }
        if ($prodi) {
            $builder->where('tikets.prodi', $prodi);
        }

        $result = $builder->groupBy('tikets.id_layanan')->get()->getResultArray();

        $labels = [];
        $data = [];

        foreach ($result as $row) {
            $labels[] = $row['per_kategori_layanan'];
            $data[] = $row['total'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
