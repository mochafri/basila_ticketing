<?php

namespace App\Services;

use App\Models\Tiket;
use App\Models\AssignTiket;

class TiketService
{
    protected $tiketModel;
    protected $assignTiket;

    public function __construct()
    {
        $this->tiketModel = new Tiket();
        $this->assignTiket = new AssignTiket();
    }

    // Bagian get + detail tiket 
    public function getDataTiket()
    {
        return $this->tiketModel
            ->select(
                'tikets.id, tikets.judul_permohonan, tikets.deskripsi_permohonan, tikets.tiket_status, tikets.created_at, 
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan'
            )
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = layanans.fk_kategori', 'left')
            ->findAll();
    }

    public function showTiket($id)
    {
        return $this->tiketModel
            ->select('
                tikets.id, tikets.judul_permohonan, tikets.deskripsi_permohonan, 
                tikets.tiket_status, tikets.created_at, tikets.dokumen_lampiran, 
                tikets.original_dokumen_name,
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan
            ')
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = layanans.fk_kategori', 'left')
            ->find($id);
    }

    // Create data tiket
    public function create(array $data, $file)
    {
        $filePath = null;
        $originalName = null;

        if (!empty($file) && $file->isValid()) {
            $newName = $file->getRandomName();
            $originalName = $file->getClientName();

            $uploadPath = WRITEPATH . 'uploads/tiket/';
            $file->move($uploadPath, $newName);

            $filePath = $newName;
        }

        $insertData = $this->tiketModel->insert([
            'judul_permohonan' => $data['judul'],
            'deskripsi_permohonan' => $data['deskripsi'],
            'id_kategori' => $data['kategori'],
            'id_layanan' => $data['layanan'],
            'dokumen_lampiran' => $filePath,
            'original_dokumen_name' => $originalName
        ]);

        return $insertData ? [
            'status' => 'success',
            'message' => 'Berhasil menambahkan tiket'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menambahkan tiket'
        ];
    }

    // Update data tiket approve by kaur
    public function approveTiket(array $data)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($data as $kabag) {

        }

        $this->tiketModel->update($data['id'], [
            'tiket_status' => 'Open'
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil approve tiket'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal approve tiket'
        ];
    }

    public function isEscalated($id)
    {
        $tiket = $this->tiketModel->find($id);

        if (!$tiket) {
            return [
                'status' => 'fail',
                'message' => 'Tiket tidak ada'
            ];
        }

        $update = $this->tiketModel->update($id, [
            'is_escalated' => true
        ]);

        return [
            'status' => $update ? 'success' : 'fail',
            'message' => $update ? 'Tiket berhasil di-eskalasi' : 'Gagal update tiket'
        ];
    }

    public function rejectTiket($id)
    {
        log_message('info', 'PARAM SLUG: ' . $id);
        $tiket = $this->tiketModel->find($id);

        log_message('error', 'Hasil query : ' . json_encode($tiket));
        if (!$tiket) {
            return [
                'status' => 'fail',
                'message' => 'Tiket tidak ada'
            ];
        }

        $update = $this->tiketModel->update($id, [
            'tiket_status' => 'Rejected'
        ]);

        return [
            'status' => $update ? 'success' : 'fail',
            'message' => $update ? 'Tiket berhasil di-reject' : 'Gagal update tiket'
        ];
    }

    // Update data tiket approve by kabag to staff
}