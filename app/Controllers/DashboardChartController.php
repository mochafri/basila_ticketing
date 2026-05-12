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
        
        $labels = [];
        $data = [];
        $details = []; // For hovers

        if ($kategoriId) {
            // Case 2: Specific category selected
            // Show all layanans in this category (even with 0 tickets)
            $layanans = $db->table('layanans')
                ->where('fk_kategori', $kategoriId)
                ->get()
                ->getResultArray();

            foreach ($layanans as $l) {
                $builder = $db->table('tikets')->where('id_layanan', $l['id']);
                
                // Role Filters
                if (!in_array('SUPERADMIN', $roles) && !in_array('BAA', $roles)) {
                    if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles)) {
                        $builder->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                            ->where('assign_to_kaur.nip_kaur', $nip)
                            ->where('tikets.tiket_status !=', 'Waiting');
                    } else {
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

                if ($fakultas) $builder->where('tikets.fakultas', $fakultas);
                if ($prodi) $builder->where('tikets.prodi', $prodi);

                $total = $builder->countAllResults();
                $labels[] = $l['per_kategori_layanan'];
                $data[] = $total;
            }
        } else {
            // Case 1: All categories
            $kategoris = $db->table('kategoris')->get()->getResultArray();

            foreach ($kategoris as $k) {
                $builder = $db->table('tikets')->where('id_kategori', $k['id']);
                
                // Role Filters
                if (!in_array('SUPERADMIN', $roles) && !in_array('BAA', $roles)) {
                    if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles)) {
                        $builder->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                            ->where('assign_to_kaur.nip_kaur', $nip)
                            ->where('tikets.tiket_status !=', 'Waiting');
                    } else {
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

                if ($fakultas) $builder->where('tikets.fakultas', $fakultas);
                if ($prodi) $builder->where('tikets.prodi', $prodi);

                $total = $builder->countAllResults();
                
                // Get services breakdown for hover
                $layanansDetail = $db->table('layanans')->where('fk_kategori', $k['id'])->get()->getResultArray();
                $servicesHover = [];
                foreach ($layanansDetail as $ld) {
                    $bL = $db->table('tikets')->where('id_layanan', $ld['id']);
                    // Same filters for services
                    if (!in_array('SUPERADMIN', $roles) && !in_array('BAA', $roles)) {
                        if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles)) {
                            $bL->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                                ->where('assign_to_kaur.nip_kaur', $nip)
                                ->where('tikets.tiket_status !=', 'Waiting');
                        } else {
                            $bL->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
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
                    if ($fakultas) $bL->where('tikets.fakultas', $fakultas);
                    if ($prodi) $bL->where('tikets.prodi', $prodi);

                    $c = $bL->countAllResults();
                    if ($c > 0) {
                        $servicesHover[] = $ld['per_kategori_layanan'] . ": " . $c;
                    }
                }

                $labels[] = $k['kategori_layanan'];
                $data[] = $total;
                $details[] = $servicesHover;
            }
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data' => $data,
            'details' => $details
        ]);
    }
}
