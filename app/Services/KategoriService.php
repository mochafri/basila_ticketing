<?php

namespace App\Services;

use App\Models\Kategori;

class KategoriService
{
    protected $kategoriModel;
    public function __construct()
    {
        $this->kategoriModel = new Kategori();
    }

    public function getKategori()
    {
        return $this->kategoriModel
            ->select('id, kategori_layanan')
            ->findAll();
    }

    public function create(array $data)
    {
        $insertData = $this->kategoriModel->insert([
            'kategori_layanan' => $data['nama_kategori']
        ]);

        return $insertData ? [
            'status' => 'success',
            'message' => 'Kategori berhasil dibuat'
        ] : [
            'status' => 'fail',
            'message' => 'Kategori gagal dibuat'
        ];
    }

    public function delete($id)
    {
        $deleteData = $this->kategoriModel->delete($id);

        return $deleteData ? [
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus'
        ] : [
            'status' => 'fail',
            'message' => 'Kategori gagal dihapus'
        ];
    }
}