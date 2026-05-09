<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $roles = [session('role_name')];
        $nip = session('user_identifier');
        $dashboard = service('dashboard');

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'totalTiket' => $dashboard->countTiket($roles, $nip),
            'onProgress' => $dashboard->getTiketOnProgress($roles, $nip),
            'onWaiting' => $dashboard->getTiketOnWaiting($roles, $nip),
            'onOpen' => $dashboard->getTiketOnOpen($roles, $nip),
            'closedTiket' => $dashboard->getTiketClosed($roles, $nip),
            'rejectTiket' => $dashboard->getTiketReject($roles, $nip),
            'totalTIketPerKategori' => $dashboard->getTiketByKategori(),
        ]);
    }
}
