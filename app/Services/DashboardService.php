<?php

namespace App\Services;

class DashboardService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function countTiket()
    {
        return $this->db->table('tikets')->countAll() ?? 0;
    }

    public function getTiketOnProgress()
    {
        return $this->db->table('tikets')->where('tiket_status', 'In Progress')->countAllResults() ?? 0;
    }

    public function getTiketClosed()
    {
        return $this->db->table('tikets')->where('tiket_status', 'Closed')->countAllResults() ?? 0;
    }

    public function getTiketReject()
    {
        return $this->db->table('tikets')->where('tiket_status', 'Rejected')->countAllResults() ?? 0;
    }
}