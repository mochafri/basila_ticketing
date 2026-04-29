<nav class="navbar navbar-expand-lg navbar-header border-bottom px-3">

    <div class="container-fluid">

        <iconify-icon id="sidebarToggleIcon" icon="material-symbols:arrow-back-rounded" class="me-3 sidebar-toggle"
            style="color: white;"></iconify-icon>

        <!-- SEARCH (Kiri) -->
        <div class="d-flex align-items-center">
            <input type="text" class="form-control form-control-sm d-none d-lg-block" placeholder="Search"
                style="width:200px;">
        </div>

        <!-- RIGHT SIDE -->
        <div class="d-flex align-items-center gap-3 ms-auto">

            <!-- Dark mode -->
            <button class="btn btn-sm text-light d-none d-md-block">
                <iconify-icon icon="si:sun-duotone" width="20"></iconify-icon>
            </button>

            <!-- Language -->
            <button class="btn btn-sm text-light d-none d-md-block">
                <iconify-icon icon="material-symbols-light:language" width="20"></iconify-icon>
            </button>

            <div class="position-relative">

                <!-- FOTO USER -->
                <img src="<?= session()->get('profilephoto') ?? base_url('assets/images/user.png') ?>" width="35"
                    height="35" class="rounded-circle d-none d-md-block" style="object-fit: cover; cursor: pointer;"
                    id="profileToggle">

                <!-- DROPDOWN -->
                <div id="dropdownProfile" class="position-absolute end-0 mt-2 bg-white rounded shadow p-3 d-none"
                    style="width: 250px; z-index: 999;">

                    <!-- HEADER -->
                    <div class="p-3 rounded bg-light mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">

                            <div>
                                <h6 class="mb-0 text-dark">
                                    <?= session()->get('username') ?? 'Username' ?>
                                </h6>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle p-0 text-muted border-0 bg-transparent d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.75rem; font-weight: 600;" title="<?= session()->get('role_name') ?>">
                                        <span class="text-truncate d-inline-block" style="max-width: 120px;">
                                            <?= session()->get('role_name') ?? 'Role' ?>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu shadow border-0 rounded-3 mt-2" style="font-size: 0.75rem; min-width: 180px; max-width: 250px;">
                                        <li class="dropdown-header text-uppercase opacity-50" style="font-size: 0.65rem; letter-spacing: 0.5px;">Ganti Role</li>
                                        <?php 
                                        $session_roles = session()->get('roles') ?? [];
                                        foreach($session_roles as $r): 
                                            $isActive = ($r['role'] === session('role_name'));
                                        ?>
                                            <li>
                                                <a class="dropdown-item <?= $isActive ? 'active bg-danger' : '' ?> d-flex align-items-center justify-content-between gap-3 py-2" href="<?= $isActive ? '#' : site_url('switch-role/' . $r['id']) ?>" title="<?= $r['role'] ?>">
                                                    <span class="text-truncate d-inline-block" style="max-width: 150px;">
                                                        <?= $r['role'] ?>
                                                    </span>
                                                    <?php if($isActive): ?>
                                                        <iconify-icon icon="solar:check-circle-bold" class="flex-shrink-0"></iconify-icon>
                                                    <?php endif; ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <button id="closeDropdown" class="btn btn-sm text-danger">
                            ✕
                        </button>
                    </div>

                    <!-- MENU -->
                    <ul class="list-unstyled mb-0">

                        <li>
                            <a href="<?= site_url('profile') ?>"
                                class="d-flex align-items-center gap-2 py-2 text-dark text-decoration-none">
                                <iconify-icon icon="solar:user-linear"></iconify-icon>
                                My Profile
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('setting') ?>"
                                class="d-flex align-items-center gap-2 py-2 text-dark text-decoration-none">
                                <iconify-icon icon="icon-park-outline:setting-two"></iconify-icon>
                                Setting
                            </a>
                        </li>

                        <li>
                            <form action="<?= site_url('logout') ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="btn btn-link text-start w-100 p-0 py-2 text-danger d-flex align-items-center gap-2 text-decoration-none">
                                    <iconify-icon icon="lucide:power"></iconify-icon>
                                    Log Out
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>

            </div>

            <!-- Sidebar Toggle (PALING KANAN) -->
            <button type="button" class="sidebar-toggle btn btn-sm btn-outline-light d-lg-none">
                ☰
            </button>

        </div>

    </div>

    <script>
        document.getElementById('profileToggle').addEventListener('click', function () {
            document.getElementById('dropdownProfile').classList.toggle('d-none');
        });

        document.getElementById('closeDropdown').addEventListener('click', function () {
            document.getElementById('dropdownProfile').classList.add('d-none');
        });

        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('dropdownProfile');
            const toggle = document.getElementById('profileToggle');

            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('d-none');
            }
        });
    </script>

</nav>