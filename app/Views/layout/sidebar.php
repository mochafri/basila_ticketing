<aside class="sidebar text-dark vh-100 position-relative">
    <div class="text-center border-bottom bg-danger d-flex align-items-center justify-content-center"
        style="height: 70px;">
        <a href="/" class="text-decoration-none text-white">
            <img src="<?= base_url('assets/img/basila_white.png') ?>" width="120" alt="logo" class="first-logo">
            <img src="<?= base_url('assets/img/logo_basila.png') ?>" width="30" alt="logo" class="second-logo d-none">
        </a>
    </div>

    <div class="sidebar-menu-area p-3">

        <!-- IDENTITAS (Hardcode) -->
        <div class="text-center my-4">
            <img src="<?= base_url('assets/images/user.png') ?>" class="rounded-circle mb-3" width="120" height="120"
                id="logo" style="object-fit:cover;">

            <h5 class="text-uppercase" id="sidebar-name">John Doe</h5>
            <small id="sidebar-nim">123456789</small>
        </div>

        <ul class="list-unstyled sidebar-menu mt-5">

            <!-- BERANDA -->
            <li class="mb-2">
                <div class="menu-item p-2 rounded d-flex align-items-center gap-2">
                    <iconify-icon icon="hugeicons:home-09" width="20"></iconify-icon>
                    <span>Beranda</span>
                </div>
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
                        <div class="submenu-item p-2 rounded">
                            <a href="#" class="text-decoration-none d-block">• Daftar Tiket</a>
                        </div>
                    </li>
                    <li>
                        <div class="submenu-item p-2 rounded">
                            <a href="#" class="text-decoration-none d-block">• Pengajuan Tiket</a>
                        </div>
                    </li>
                </ul>

            </li>

            <!-- MASTER DATA -->
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
                        <div class="submenu-item p-2 rounded">
                            <a href="#" class="text-decoration-none d-block">• Data User</a>
                        </div>
                    </li>
                </ul>

            </li>
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