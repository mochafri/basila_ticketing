<?php

namespace App\Services;

class TiketService
{
    protected $tiketModel;
    protected $assignTiket;
    protected $assignTaskStaff;
    protected $riwayatAktifitas;

    public function __construct()
    {
        $this->tiketModel = model('Tiket');
        $this->assignTiket = model('AssignTiket');
        $this->assignTaskStaff = model('AssignTask');
        $this->riwayatAktifitas = model('RiwayatAktifitas');
    }

    # Bagian get all data tiket
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

    # Bagian get detail tiket
    public function showTiket($id)
    {
        return $this->tiketModel
            ->select('
                tikets.id, tikets.judul_permohonan, tikets.deskripsi_permohonan, 
                tikets.tiket_status, tikets.created_at, tikets.dokumen_lampiran, 
                tikets.original_dokumen_name,tikets.is_escalated,
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan
            ')
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = layanans.fk_kategori', 'left')
            ->find($id);
    }

    # Create data tiket
    public function create(array $data, $file, $username)
    {
        $db = \Config\Database::connect();

        $filePath = null;
        $originalName = null;

        if (!empty($file) && $file->isValid()) {
            $newName = $file->getRandomName();
            $originalName = $file->getClientName();

            $uploadPath = WRITEPATH . 'uploads/tiket/users/';
            $file->move($uploadPath, $newName);

            $filePath = $newName;
        }

        $db->transStart();

        $this->tiketModel->insert([
            'judul_permohonan' => $data['judul'],
            'deskripsi_permohonan' => $data['deskripsi'],
            'id_kategori' => $data['kategori'],
            'id_layanan' => $data['layanan'],
            'dokumen_lampiran' => $filePath,
            'original_dokumen_name' => $originalName
        ]);

        $insertId = $this->tiketModel->getInsertID();

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Laporan Tugas',
            'message' => 'Staf telah mengunggah laporan penyelesaian tugas.',
            'created_by' => 'Staf',
            'fk_tiket' => $insertId
        ]);

        $db->transComplete();

        return $db->transStatus() ? [ 
            'status' => 'success',
            'message' => 'Berhasil menambahkan tiket'
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menambahkan tiket'
        ];
    }
}
