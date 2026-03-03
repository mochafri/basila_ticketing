<?php

namespace App\Controllers;

class MasterDataController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Data User',
        ];
        
        return view('user/index', $data);
    }
}
