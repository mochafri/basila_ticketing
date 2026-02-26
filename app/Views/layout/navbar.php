

    <div class="navbar-header border-bottom px-3 w-100 d-flex justify-content-between align-items-center">

        <!-- LEFT -->
        <div class="d-flex align-items-center gap-3">

            <button type="button" class="sidebar-toggle btn btn-sm btn-outline-light">
                ☰
            </button>

            <input type="text" class="form-control form-control-sm" placeholder="Search" style="width:200px;">
        </div>

        <!-- RIGHT -->
        <div class="d-flex align-items-center gap-3">

            <button class="btn btn-sm text-light">
                <iconify-icon icon="si:sun-duotone" width="20" height="20"></iconify-icon>
            </button>

            <button class="btn btn-sm text-light">
                <iconify-icon icon="material-symbols-light:language" width="20" height="20"></iconify-icon>
            </button>

            <img src="<?= base_url('assets/images/user.png') ?>" width="35" height="35" class="rounded-circle"
                style="object-fit:cover;">

        </div>

    </div>

<script src="<?= base_url('assets/js/sidebar.js') ?>"></script>