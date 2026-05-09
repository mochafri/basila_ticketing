<?php

namespace App\Services;

class DashboardService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function applyRoleFilters($query, $roles, $nip)
    {
        // 1. KABAG (SUPERADMIN / BAA): Melihat semua tiket
        if (in_array('SUPERADMIN', $roles) || in_array('BAA', $roles)) {
            return $query;
        }

        // 2. KAUR: Melihat tiket yang didelegasikan kepadanya (Kecuali status Waiting)
        if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles)) {
            return $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                ->where('assign_to_kaur.nip_kaur', $nip)
                ->where('tikets.tiket_status !=', 'Waiting');
        }

        // 3. STAFF & MAHASISWA (Pelapor): 
        // - Melihat tiket yang mereka buat sendiri (nip_creator) -> STATUS APA SAJA
        // - Melihat tiket dimana mereka ditugaskan sebagai staff (nip_receive_task) -> HANYA JIKA BUKAN WAITING
        return $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
            ->join('tiket_on_progress', 'tiket_on_progress.fk_assign_to_kaur = assign_to_kaur.id', 'left')
            ->groupStart()
            ->where('tikets.nip_creator', $nip)
            ->orGroupStart()
            ->where('tiket_on_progress.nip_receive_task', $nip)
            ->where('tikets.tiket_status !=', 'Waiting')
            ->groupEnd()
            ->groupEnd();
    }

    public function countTiket($roles = [], $nip = null)
    {
        $query = $this->db->table('tikets');
        return $this->applyRoleFilters($query, $roles, $nip)->countAllResults();
    }

    public function getTiketOnProgress($roles = [], $nip = null)
    {
        $query = $this->db->table('tikets')->where('tiket_status', 'In Progress');
        return $this->applyRoleFilters($query, $roles, $nip)->countAllResults();
    }

    public function getTiketOnWaiting($roles = [], $nip = null)
    {
        $query = $this->db->table('tikets')->where('tiket_status', 'Waiting');
        return $this->applyRoleFilters($query, $roles, $nip)->countAllResults();
    }

    public function getTiketOnOpen($roles = [], $nip = null)
    {
        $query = $this->db->table('tikets')->where('tiket_status', 'Open');
        return $this->applyRoleFilters($query, $roles, $nip)->countAllResults();
    }

    public function getTiketClosed($roles = [], $nip = null)
    {
        $query = $this->db->table('tikets')->where('tiket_status', 'Closed');
        return $this->applyRoleFilters($query, $roles, $nip)->countAllResults();
    }

    public function getTiketReject($roles = [], $nip = null)
    {
        $query = $this->db->table('tikets')->where('tiket_status', 'Rejected');
        return $this->applyRoleFilters($query, $roles, $nip)->countAllResults();
    }

    public function getTiketByKategori()
    {
        $kategori = $this->db->table('kategoris')
            ->select('id, kategori_layanan')
            ->get()
            ->getResultArray();

        foreach ($kategori as $k) {
            $data[] = [
                'kategori' => $k['kategori_layanan'],
                'total' => $this->db->table('tikets')
                    ->where('id_layanan', $k['id'])
                    ->countAllResults()
            ];
        }

        return $data;
    }
}
