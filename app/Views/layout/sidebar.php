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

        <ul class="list-unstyled sidebar-menu">

            <!-- BERANDA -->
            <li class="mb-3">
                <div class="menu-item p-2 rounded d-flex align-items-center gap-2">
                    <iconify-icon icon="material-symbols:home-outline-rounded" width="20"></iconify-icon>
                    <span>Beranda</span>
                </div>
            </li>

            <!-- KELOLA SURAT -->
            <li class="mb-3">

                <!-- Parent -->
                <div class="menu-item side-task p-2 rounded d-flex align-items-center gap-2" data-bs-toggle="collapse"
                    data-bs-target="#kelolaSurat" role="button">

                    <iconify-icon icon="hugeicons:task-01" width="18"></iconify-icon>
                    <span>Kelola Tugas</span>
                </div>

                <!-- Collapse -->
                <ul class="collapse list-unstyled ps-4 mt-2" id="kelolaSurat">
                    <li>
                        <div class="submenu-item p-2 rounded">
                            <a href="#" class="text-decoration-none d-block">&#8226; Dashboard</a>
                        </div>
                    </li>
                    <li>
                        <div class="submenu-item p-2 rounded">
                            <a href="#" class="text-decoration-none d-block">&#8226; Pengajuan</a>
                        </div>
                    </li>
                    <li>
                        <div class="submenu-item p-2 rounded">
                            <a href="#" class="text-decoration-none d-block">&#8226; Persetujuan</a>
                        </div>
                    </li>
                    <li>
                        <div class="submenu-item p-2 rounded">
                            <a href="#" class="text-decoration-none d-block">&#8226; Status</a>
                        </div>
                    </li>
                </ul>

            </li>

        </ul>

    </div>

</aside>