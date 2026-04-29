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
        // - Melihat tiket dimana mereka ditugaskan sebagai staff (nip_staff) -> HANYA JIKA BUKAN WAITING
        return $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
            ->join('assign_to_staff', 'assign_to_staff.fk_assign_to_kaur = assign_to_kaur.id', 'left')
            ->groupStart()
                ->where('tikets.nip_creator', $nip)
                ->orGroupStart()
                    ->where('assign_to_staff.nip_staff', $nip)
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
}