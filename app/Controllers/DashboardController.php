<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $roles = [session('role_name')];
        $nip = session('user_identifier');
        $dashboard = service('dashboard');

        $kategoriModel = new \App\Models\Kategori();
        $kategoris = $kategoriModel->findAll();

        $db = \Config\Database::connect();
        
        // Only if not mahasiswa we might need to show these filters, but we can pass them anyway
        $fakultasRaw = $db->table('tikets')->select('fakultas')->where('fakultas !=', null)->where('fakultas !=', '')->groupBy('fakultas')->get()->getResultArray();
        $prodiRaw = $db->table('tikets')->select('prodi')->where('prodi !=', null)->where('prodi !=', '')->groupBy('prodi')->get()->getResultArray();
        
        $fakultas = array_column($fakultasRaw, 'fakultas');
        $prodis = array_column($prodiRaw, 'prodi');

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'totalTiket' => $dashboard->countTiket($roles, $nip),
            'onProgress' => $dashboard->getTiketOnProgress($roles, $nip),
            'onWaiting' => $dashboard->getTiketOnWaiting($roles, $nip),
            'onOpen' => $dashboard->getTiketOnOpen($roles, $nip),
            'closedTiket' => $dashboard->getTiketClosed($roles, $nip),
            'rejectTiket' => $dashboard->getTiketReject($roles, $nip),
            'totalTIketPerKategori' => $dashboard->getTiketByKategori(),
            'kategoris' => $kategoris,
            'fakultas' => $fakultas,
            'prodis' => $prodis,
        ]);
    }
}
