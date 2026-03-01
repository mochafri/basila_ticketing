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
}
