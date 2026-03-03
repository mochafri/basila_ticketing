<?php

namespace App\Controllers;

class TicketController extends BaseController
{
    public function index(): string
    {
        return view('tiket/daftar/index', [
            'title' => 'Daftar Tiket',
        ]);
    }

    public function create(): string
    {
        return view('tiket/pengajuan/index', [
            'title' => 'Pengajuan Tiket',
        ]);
    }

    public function show($id): string
    {
        return view('tiket/daftar/detail', [
            'title' => 'Detail Tiket',
            'id' => $id
        ]);
    }
}
