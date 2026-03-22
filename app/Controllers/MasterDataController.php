<?php

namespace App\Controllers;

use App\Services\KategoriService;
use App\Services\LayananService;

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
        return view('manajemen/kategori/index', [
            'title' => 'Data Kategori',
            'kategori' => service('kategori')->getKategori()
        ]);
    }

    public function createKategori()
    {
        // Set method request for client to send form
        $request = $this->request->getJSON(true);

        // Check validation request
        if (!$this->validateData($request, 'kategoriRule')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'message' => 'Failed request'
                ]);
        }

        // Call function with instance on construct
        $result = service('kategori')->create($request);

        // Set status code berdasarkan return function
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function createLayanan()
    {
        $request = $this->request->getJSON(true);

        if (!$this->validateData($request, 'layananRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Failed request'
            ]);
        }

        $result = service('layanan')->create($request);

        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }
}