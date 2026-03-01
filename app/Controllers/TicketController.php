<?php

namespace App\Controllers;

class TicketController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Daftar Tiket',
        ];

        return view('tiket/daftar/index', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => 'Pengajuan Tiket',
        ];

        return view('tiket/pengajuan/index', $data);
    }
}
