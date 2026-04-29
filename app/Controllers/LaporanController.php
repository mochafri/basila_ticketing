<?php

namespace App\Controllers;

use App\Services\LaporanService;
use App\Services\KaurService;

class LaporanController extends BaseController
{
    protected $laporanService;
    protected $kaurService;

    public function __construct()
    {
        $this->laporanService = new LaporanService();
        $this->kaurService = new KaurService();
    }

    public function kinerja()
    {
        $filters = [
            'start_date' => $this->request->getGet('start_date'),
            'end_date' => $this->request->getGet('end_date'),
            'staff_nip' => $this->request->getGet('staff_nip'),
        ];

        $data = [
            'title' => 'Laporan Kinerja Staff',
            'kinerja' => $this->laporanService->getKinerjaStaff($filters),
            'staffList' => $this->kaurService->getStaff(null) ?? [], // Get all staff
            'filters' => $filters
        ];

        return view('laporan/kinerja', $data);
    }

    public function detailKinerja($nip)
    {
        $filters = [
            'status' => $this->request->getGet('status'),
        ];

        $detail = $this->laporanService->getDetailKinerja($nip, $filters);
        
        if (empty($detail)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        $data = [
            'title' => 'Detail Kinerja Staff',
            'detail' => $detail,
            'nama_staff' => $detail[0]['assign_task_to_staff'] ?? 'Staff',
            'nip_staff' => $nip
        ];

        return view('laporan/detail_kinerja', $data);
    }
}
