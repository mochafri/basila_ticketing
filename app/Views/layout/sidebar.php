<aside class="sidebar text-dark vh-100 position-relative d-none d-md-block">
    <div class="text-center border-bottom bg-danger d-flex align-items-center justify-content-center"
        style="height: 70px;">
        <a href="/" class="text-decoration-none text-white">
            <img src="<?= base_url('assets/img/basila_white.png') ?>" width="120" alt="logo" class="first-logo">
            <img src="<?= base_url('assets/img/logo_basila.png') ?>" width="30" alt="logo" class="second-logo d-none">
        </a>
    </div>

    <div class="sidebar-menu-area p-3 ">

        <!-- IDENTITAS (Hardcode) -->
        <div class="text-center my-4 d-flex flex-column align-items-center gap-2">

    <img src="<?= session()->get('profilephoto') ?? base_url('assets/images/user.png') ?>"
        class="rounded-circle"
        width="120"
        height="120"
        style="object-fit: cover; object-position: top;"
        alt="profile"
        id="logo">

    <div class="w-100 d-flex flex-column align-items-center">
        <h5 class="text-uppercase text-truncate"
            style="max-width: 80%;"
            id="sidebar-name">
            <?= session()->get('username') ?? 'Username' ?>
        </h5>

        <small id="sidebar-nim">
            <?= session()->get('user_identifier') ?? 'NIM' ?>
        </small>
    </div>

</div>

        <ul class="list-unstyled sidebar-menu mt-5">

            <!-- BERANDA -->
            <li class="mb-2">
                <a href="/dashboard"
                    class="menu-item p-2 rounded d-flex align-items-center gap-2 text-decoration-none text-dark">
                    <iconify-icon icon="hugeicons:home-09" width="20"></iconify-icon>
                    <span>Beranda</span>
                </a>
            </li>

            <!-- KELOLA SURAT -->
            <!-- KELOLA TIKET -->
            <li class="mb-2">

                <div class="menu-item side-task p-2 rounded d-flex align-items-center" data-bs-toggle="collapse"
                    data-bs-target="#kelolaTiket" role="button">

                    <!-- Icon kiri -->
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="hugeicons:ticket-03" width="20"></iconify-icon>
                        <span>Kelola Tiket</span>
                    </div>

                    <!-- Arrow kanan -->
                    <iconify-icon icon="material-symbols:chevron-right-rounded" class="ms-auto arrow-icon">
                    </iconify-icon>

                </div>

                <ul class="collapse list-unstyled ps-4 mt-2" id="kelolaTiket">
                    <li>
                        <div class="submenu-item p-2 rounded d-flex align-items-center gap-2">
                            <iconify-icon icon="icon-park-outline:dot" width="15" class="text-secondary"></iconify-icon>
                            <a href="<?= site_url('tiket'); ?>" class="text-decoration-none d-block">Daftar Tiket</a>
                        </div>
                    </li>
                    <li>
                        <div class="submenu-item p-2 rounded d-flex align-items-center gap-2">
                            <iconify-icon icon="icon-park-outline:dot" width="15" class="text-secondary"></iconify-icon>
                            <a href="<?= site_url('tiket/create'); ?>" class="text-decoration-none d-block">Permohonan
                                Tiket</a>
                        </div>
                    </li>
                </ul>

            </li>

            <!-- MASTER DATA -->
            <?php if (!in_array(session('role_name'), ['MAHASISWA', 'PEGAWAI', 'ADMIN AKADEMIK'])): ?>
            <li class="mb-2">

                <div class="menu-item side-task p-2 rounded d-flex align-items-center" data-bs-toggle="collapse"
                    data-bs-target="#kelolaMasterData" role="button">

                    <!-- Icon kiri -->
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="hugeicons:database" width="20"></iconify-icon>
                        <span>Master Data</span>
                    </div>

                    <!-- Arrow kanan -->
                    <iconify-icon icon="material-symbols:chevron-right-rounded" class="ms-auto arrow-icon">
                    </iconify-icon>

                </div>

                <ul class="collapse list-unstyled ps-4 mt-2" id="kelolaMasterData">
                    <li>
                        <div class="submenu-item p-2 rounded d-flex align-items-center gap-2">
                            <iconify-icon icon="icon-park-outline:dot" width="15" class="text-secondary"></iconify-icon>
                            <a href="<?= site_url('user/'); ?>" class="text-decoration-none d-block">Data User</a>
                        </div>
                    </li>
                    <li>
                        <div class="submenu-item p-2 rounded d-flex align-items-center gap-2">
                            <iconify-icon icon="icon-park-outline:dot" width="15" class="text-secondary"></iconify-icon>
                            <a href="<?= site_url('kategori/'); ?>" class="text-decoration-none d-block">Data
                                Kategori</a>
                        </div>
                    </li>
                
                </ul>

            </li>
            <?php endif; ?>
             <!-- LAPORAN -->
            <?php if (!in_array(session('role_name'), ['MAHASISWA', 'PEGAWAI', 'ADMIN AKADEMIK'])): ?>
            <li class="mb-2">
                <div class="menu-item side-task p-2 rounded d-flex align-items-center" data-bs-toggle="collapse"
                    data-bs-target="#kelolaLaporan" role="button">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="hugeicons:analytics-up" width="20"></iconify-icon>
                        <span>Laporan</span>
                    </div>
                    <iconify-icon icon="material-symbols:chevron-right-rounded" class="ms-auto arrow-icon"></iconify-icon>
                </div>
                <ul class="collapse list-unstyled ps-4 mt-2" id="kelolaLaporan">
                    <li>
                        <div class="submenu-item p-2 rounded">
                            <a href="<?= site_url('laporan/kinerja'); ?>" class="text-decoration-none d-block">• Kinerja Staff</a>
                        </div>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <!-- RIWAYAT -->
            <li class="mb-2">
                <div class="menu-item p-2 rounded d-flex align-items-center gap-2">
                    <iconify-icon icon="hugeicons:transaction-history" width="20"></iconify-icon>
                    <span>Riwayat</span>
                </div>
            </li>
            <!-- PENGATURAN -->
            <li class="mb-2">
                <div class="menu-item p-2 rounded d-flex align-items-center gap-2">
                    <iconify-icon icon="hugeicons:settings-01" width="20"></iconify-icon>
                    <span>Pengaturan</span>
                </div>
            </li>
        </ul>

    </div>

</aside>