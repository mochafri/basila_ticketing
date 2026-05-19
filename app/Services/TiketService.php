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
    public function getDataTiket($roles = [], $nip = null, $kategori = null, $status = null, $search = null)
    {
        $query = $this->tiketModel
            ->select('
                tikets.id, 
                tikets.deskripsi_permohonan, 
                tikets.tiket_status, 
                tikets.created_at, 
                tikets.nip_creator, 
                tikets.nama_creator, 
                tikets.fakultas, tikets.prodi, tikets.level_kesulitan,
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan
            ')
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = tikets.id_kategori', 'left')
            ->orderBy('tikets.created_at', 'DESC');

        if ($kategori) {
            $query->where('kategoris.id', $kategori);
        }

        if ($status === 'Active') {
            $query->where('tikets.tiket_status !=', 'Closed');
        } elseif ($status && $status !== 'All') {
            $query->where('tikets.tiket_status', $status);
        }

        if ($search) {
            $query->groupStart()
                ->like('tikets.id', $search)
                ->orLike('tikets.deskripsi_permohonan', $search)
                ->orLike('tikets.nama_creator', $search)
                ->orLike('tikets.nip_creator', $search)
                ->orLike('kategoris.kategori_layanan', $search)
                ->orLike('layanans.per_kategori_layanan', $search)
                ->orLike('tikets.fakultas', $search)
                ->orLike('tikets.prodi', $search)
                ->groupEnd();
        }

        # 1. KABAG (SUPERADMIN / BAA): Melihat semua tiket
        if (in_array('SUPERADMIN', $roles) || in_array('BAA', $roles)) {
            return [
                'data' => $query
                    ->paginate(10),
                'pager' => $query->pager,
            ];
        }

        # 2. KAUR: Melihat tiket yang didelegasikan kepadanya (Kecuali status Waiting)
        if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles) || in_array('ADMIN DATA MAHASISWA FAKULTAS', $roles)) {
            return [
                'data' => $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id')
                    ->where('assign_to_kaur.nip_kaur', $nip)
                    ->paginate(10),
                'pager' => $query->pager,
            ];
        }
        # 3. STAFF & MAHASISWA (Pelapor): 
        return [
            'data' => $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id', 'left')
                ->join('tiket_on_progress', 'tiket_on_progress.fk_assign_to_kaur = assign_to_kaur.id', 'left')
                ->groupStart()
                ->where('tikets.nip_creator', $nip)
                ->orGroupStart()
                ->where('tiket_on_progress.nip_receive_task', $nip)
                ->groupEnd()
                ->groupEnd()
                ->distinct()
                ->paginate(10),
            'pager' => $query->pager
        ];
    }

    # Bagian khusus untuk riwayat tiket (status Closed/Rejected)
    public function getRiwayatTiket($roles = [], $nip = null, $kategori = null, $status = null, $search = null)
    {
        $query = $this->tiketModel
            ->select('
                tikets.id, 
                tikets.deskripsi_permohonan, 
                tikets.tiket_status, 
                tikets.created_at, 
                tikets.nip_creator, 
                tikets.nama_creator, 
                tikets.fakultas, tikets.prodi,
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan
            ')
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = tikets.id_kategori', 'left')
            ->orderBy('tikets.created_at', 'DESC');

        # Jika status tidak ditentukan, ambil yang sudah final secara default
        if ($status && $status !== 'All') {
            $query->where('tikets.tiket_status', $status);
        } else {
            $query->whereIn('tikets.tiket_status', ['Closed', 'Rejected']);
        }

        if ($kategori) {
            $query->where('kategoris.id', $kategori);
        }

        if ($search) {
            $query->groupStart()
                ->like('tikets.id', $search)
                ->orLike('tikets.deskripsi_permohonan', $search)
                ->groupEnd();
        }

        # Filter berdasarkan Role (Sama seperti getDataTiket tapi versi simple untuk riwayat)
        if (in_array('SUPERADMIN', $roles) || in_array('BAA', $roles)) {
            # No extra filter
        } else if (in_array('KEPALA URUSAN ADMINISTRASI AKADEMIK', $roles) || in_array('ADMIN DATA MAHASISWA FAKULTAS', $roles)) {
            $query->join('assign_to_kaur', 'assign_to_kaur.fk_tiket = tikets.id')
                ->where('assign_to_kaur.nip_kaur', $nip);
        } else {
            $query->where('tikets.nip_creator', $nip);
        }

        return [
            'data' => $query->paginate(10),
            'pager' => $query->pager
        ];
    }

    # Bagian get detail tiket
    public function showTiket($id)
    {
        return $this->tiketModel
            ->select('
                tikets.id, 
                tikets.deskripsi_permohonan, 
                tikets.tiket_status, 
                tikets.created_at, 
                tikets.completed_at, 
                tikets.dokumen_lampiran, 
                tikets.original_dokumen_name,
                tikets.is_escalated, 
                tikets.notes_request_escalated, 
                tikets.notes_after_escalated,
                tikets.level_kesulitan,
                tikets.nip_creator, 
                tikets.nama_creator, tikets.fakultas, tikets.prodi,
                tikets.catatan_penyelesaian,
                layanans.per_kategori_layanan,
                kategoris.kategori_layanan
            ')
            ->join('layanans', 'layanans.id = tikets.id_layanan', 'left')
            ->join('kategoris', 'kategoris.id = tikets.id_kategori', 'left')
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

        $idLayanan = $data['layanan'];

        $this->tiketModel->insert([
            'deskripsi_permohonan' => $data['deskripsi'],
            'id_kategori' => $data['kategori'],
            'id_layanan' => $idLayanan,
            'dokumen_lampiran' => $filePath,
            'original_dokumen_name' => $originalName,
            'nip_creator' => session('user_identifier'),
            'nama_creator' => session('username'),
            'fakultas' => $data['fakultas'] ?? session('fakultas'),
            'prodi' => $data['prodi'] ?? session('prodi'),
            'tiket_status' => 'Open'
        ]);

        $insertId = $this->tiketModel->getInsertID();

        $this->riwayatAktifitas->insert([
            'activity_title' => 'Pembuatan Tiket',
            'message' => 'Tiket diajukan oleh pemohon.',
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
