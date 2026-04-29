<?php

namespace App\Services;

class LayananService
{
    protected $layananModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->layananModel = model('Layanan');
        $this->kategoriModel = model('Kategori');
    }

    public function getLayanan()
    {
        return $this->layananModel
            ->select('layanans.*, kategoris.kategori_layanan')
            ->join('kategoris', 'kategoris.id = layanans.fk_kategori')
            ->findAll();
    }
    
    public function getLayananById($id)
    {

        $getData = $this->layananModel
            ->select('id, per_kategori_layanan')
            ->where('fk_kategori', $id)
            ->findAll();

        return $getData ? [
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

    public function delete($id)
    {
        $deleteData = $this->layananModel->delete($id);

        return $deleteData ? [
            'status' => 'success',
            'message' => 'Layanan berhasil dihapus'
        ] : [
            'status' => 'fail',
            'message' => 'Layanan gagal dihapus'
        ];
    }
}