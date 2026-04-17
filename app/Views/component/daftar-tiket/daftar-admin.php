<div class="card mt-5 border-0 shadow-sm tiket-tabel">
    <table class="table align-middle mb-0">

        <thead>
            <tr>
                <th>ID</th>
                <th>JUDUL PERMOHONAN</th>
                <th>KATEGORI</th>
                <th>TANGGAL</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>

        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($tiket as $data): ?>
                <?php

                $rolePermission = session('role_name') === 'PEGAWAI' ||
                    session('role_name') === 'KEPALA URUSAN ADMINISTRASI AKADEMIK';
                $roleOnPermission = session('role_name') === 'SUPERADMIN';
                $tiketStatus = $data['tiket_status'] === 'Open' || $data['tiket_status'] === 'In Progress';
                $kabagStatusTiket = [
                    'Waiting',
                    'Open',
                    'In Progress',
                    'Closed',
                    'Rejected'
                ];

                $tiketStatusKabag = in_array($data['tiket_status'], $kabagStatusTiket);
                if(($rolePermission && $tiketStatus) || ($roleOnPermission && $tiketStatusKabag)): ?>
                    <tr>
                        <td class="tiket-id"><?= $no++ ?></td>
                        <td class="tiket-judul">
                            <?= $data['judul_permohonan'] ?>
                        </td>
                        <td class="tiket-kategori">
                            <div class="tiket-kategori-wrapper"></div>
                            <iconify-icon icon="hugeicons:layers-01"></iconify-icon>
                            <?= $data['kategori_layanan'] ?>
                        </td>
                        <td class="tiket-tanggal">
                            <?= date('Y-m-d', strtotime($data['created_at'])) ?>
                        </td>
                        <td>
                            <span class="tiket-status-badge">
                                <?= $data['tiket_status'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= site_url('tiket/' . $data['id']) ?>" class="tiket-btn-aksi">
                                <iconify-icon icon="hugeicons:arrow-right-02"></iconify-icon>
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>