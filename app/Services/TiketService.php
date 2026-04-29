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

    # Bagian get all data tiket dengan filtering Role
    public function getDataTiket($roles = [], $nip = null)
    {
        $query = $this->tiketModel
            ->select(
                'tikets.id, tikets.judul_permohonan, tikets.deskripsi_permohonan, tikets.tiket_status, 
                tikets.created_at, tikets.nip_creator, tikets.nama_creator,
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan'
            )
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = layanans.fk_kategori', 'left')
            ->orderBy('tikets.created_at', 'DESC');

        // 1. KABAG (SUPERADMIN): Melihat semua tiket
        if (in_array('SUPERADMIN', $roles)) {
            return [
                'data' => $query->paginate(10),
                'pager' => $query->pager,
            ];
        }
        // 2. KAUR: Melihat tiket yang didelegasikan kepadanya (Kecuali status Waiting)
        if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles)) {
            return [
                'data' => $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id')
                    ->where('assign_to_kaur.nip_kaur', $nip)
                    ->where('tikets.tiket_status !=', 'Waiting')
                    ->paginate(10),
                'pager' => $query->pager,
            ];
        }
        // 3. STAFF & MAHASISWA (Pelapor): 
        // - Melihat tiket yang mereka buat sendiri (nip_creator) -> STATUS APA SAJA
        // - Melihat tiket dimana mereka ditugaskan sebagai staff (nip_staff) -> HANYA JIKA BUKAN WAITING
        return [
            'data' => $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                ->join('assign_to_staff', 'assign_to_staff.fk_assign_to_kaur = assign_to_kaur.id', 'left')
                ->groupStart()
                ->where('tikets.nip_creator', $nip)
                ->orGroupStart()
                ->where('assign_to_staff.nip_staff', $nip)
                ->where('tikets.tiket_status !=', 'Waiting')
                ->groupEnd()
                ->groupEnd()
                ->distinct()
                ->paginate(10),
            'pager' => $query->pager
        ];
    }

    # Bagian get detail tiket
    public function showTiket($id)
    {
        return $this->tiketModel
            ->select('
                tikets.id, tikets.judul_permohonan, tikets.deskripsi_permohonan, 
                tikets.tiket_status, tikets.created_at, tikets.dokumen_lampiran, 
                tikets.original_dokumen_name,tikets.is_escalated,
                tikets.nip_creator, tikets.nama_creator,
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
            'original_dokumen_name' => $originalName,
            'nip_creator' => session('user_identifier'),
            'nama_creator' => session('username')
        ]);

        $insertId = $this->tiketModel->getInsertID();

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Laporan Tugas',
            'message' => 'Staf telah mengunggah laporan penyelesaian tugas.',
            'created_by' => $username,
            'fk_tiket' => $insertId
        ]);

        $db->transComplete();

        return $db->transStatus() ? [
            'status' => 'success',
            'message' => 'Berhasil menambahkan tiket',
        ] : [
            'status' => 'fail',
            'message' => 'Gagal menambahkan tiket'
        ];
    }
}
