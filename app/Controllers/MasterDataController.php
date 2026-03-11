<?php

namespace App\Controllers;

class MasterDataController extends BaseController
{
    public function user()
    {
        $data = [
            'title' => 'Data User'
        ];

        return view('manajemen/user/index', $data);
    }

    public function kategori()
    {
        $data = [
            'title' => 'Data Kategori'
        ];

        return view('manajemen/kategori/index', $data);
    }
}