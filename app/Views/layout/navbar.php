<nav class="navbar navbar-expand-lg navbar-header border-bottom px-3">

    <div class="container-fluid">

        <iconify-icon id="sidebarToggleIcon" icon="material-symbols:arrow-back-rounded"
            class="me-3 sidebar-toggle" style="color: white;"></iconify-icon>

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

            <!-- User -->
            <img src="<?= base_url('assets/images/user.png') ?>" width="35" height="35"
                class="rounded-circle d-none d-md-block" id="logo" style="object-fit:cover;">

            <!-- Sidebar Toggle (PALING KANAN) -->
            <button type="button" class="sidebar-toggle btn btn-sm btn-outline-light d-lg-none">
                ☰
            </button>

        </div>

    </div>

</nav>