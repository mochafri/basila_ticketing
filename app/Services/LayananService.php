<?php

namespace App\Services;

use App\Models\Layanan;
use App\Models\Kategori;

class LayananService
{
    protected $layananModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->layananModel = new Layanan();
        $this->kategoriModel = new Kategori();
    }

    public function getLayanan($id)
    {
        $check = $this->layananModel
            ->find($id);

        $getData =  $this->layananModel
            ->select('id, per_kategori_layanan')
            ->where('fk_kategori', $id)
            ->findAll();
        
        return $check ? [
            'status' => 'success',
            'data' => $getData
        ] : [
            'status' => 'fail',
            'message' => 'Kategori tidak ada'
        ]; 
    }

    public function create(array $data)
    {
        $checkFk = $this->kategoriModel->find($data['kategori_id']);

        if (!$checkFk) {
            return [
                'status' => 'fail',
                'message' => 'Kategori dalam pilihan tidak ditemukan'
            ];
        }

        $insertData = $this->layananModel
            ->insert([
                'per_kategori_layanan' => $data['nama_layanan'],
                'fk_kategori' => $data['kategori_id']
            ]);

        return $insertData ? [
            'status' => 'success',
            'message' => 'Berhasil menambahkan layanan'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menambahkan layanan'
        ];
    }
}