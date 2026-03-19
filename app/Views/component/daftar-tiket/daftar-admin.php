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

                <tr>

                    <td class="tiket-id">#T-001</td>

                    <td class="tiket-judul">
                        PENGAJUAN REGISTRASI MK TERLAMBAT
                    </td>

                    <td class="tiket-kategori">
                        <div class="tiket-kategori-wrapper"></div>
                        <iconify-icon icon="hugeicons:layers-01"></iconify-icon>
                        REGISTRASI
                    </td>

                    <td class="tiket-tanggal">
                        11/3/2026
                    </td>

                    <td>
                        <span class="tiket-status-badge">
                            PENDING_APPROVAL
                        </span>
                    </td>

                    <td>
                        <a href="<?= site_url('tiket/1') ?>" class="tiket-btn-aksi">
                            <iconify-icon icon="hugeicons:arrow-right-02"></iconify-icon>
                        </a>
                    </td>

                </tr>

            </tbody>

        </table>
    </div>