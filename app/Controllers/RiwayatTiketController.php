<?php

namespace App\Controllers;

class RiwayatTiketController extends BaseController
{
    protected $tiketService;
    protected $kategoriService;

    public function __construct()
    {
        $this->tiketService = service('tiket');
        $this->kategoriService = service('kategori');
    }

    public function index() {
        $roles = [session('role_name')];
        $nip = session('user_identifier');
        $kategori = $this->request->getGet('kategori');
        $search = $this->request->getGet('search');

        $status = $this->request->getGet('status') ?? 'All';

        return view('tiket/riwayat_tiket/riwayat_tiket', [
            'title' => 'Riwayat Tiket',
            'tiket' => $this->tiketService->getRiwayatTiket($roles, $nip, $kategori, $status, $search),
            'categories' => $this->kategoriService->getKategori(),
            'filter_kategori' => $kategori,
            'filter_status' => $status,
            'search' => $search
        ]);
    }
}