<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
        ];
        
        return view('dashboard/index', [
            'title' => 'Dashboard',
            'totalTiket' => service('dashboard')->countTiket(),
            'onProgress' => service('dashboard')->getTiketOnProgress(),
        ]);
    }
}
