<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4 px-4 dashboard-wrapper">

    <!-- Header -->
    <div class="mb-5">
        <div>
            <h2 class="fw-bold title-dashboard">MASTER DATA MANAGEMENT</h2>
            <span class="text-muted subtitle-dashboard">
                Kelola role dan user akses dalam sistem BASILA
            </span>
        </div>
    </div>

    <!-- CARD CONTEN -->
    <div class="row g-4">

        <!-- ROLE MANAGEMENT -->
        <div class="col-md-6">
            <div class="card master-card p-4 h-100">
                <h5 class="fw-bold mb-4">ROLE MANAGEMENT</h5>

                <div class="d-flex gap-3 mb-4">
                    <input type="text" class="form-control custom-input" placeholder="NAMA ROLE BARU">
                    <button class="btn btn-danger btn-master">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

                <small class="label-list">DAFTAR ROLE AKTIF:</small>

                <div class="list-wrapper mt-3">
                    <div class="list-item">
                        <div class="d-flex align-items-center gap-3">
                            <span class="dot-red"></span>
                            <span class="fw-semibold">USER</span>
                            <span class="badge-system">SYSTEM</span>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex align-items-center gap-3">
                            <span class="dot-red"></span>
                            <span class="fw-semibold">ADMIN</span>
                            <span class="badge-system">SYSTEM</span>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex align-items-center gap-3">
                            <span class="dot-red"></span>
                            <span class="fw-semibold">KAUR AKADEMIK</span>
                            <span class="badge-system">SYSTEM</span>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex align-items-center gap-3">
                            <span class="dot-red"></span>
                            <span class="fw-semibold">KAUR LAYANAN</span>
                            <span class="badge-system">SYSTEM</span>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="d-flex align-items-center gap-3">
                            <span class="dot-red"></span>
                            <span class="fw-semibold">STAFF</span>
                            <span class="badge-system">SYSTEM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- USER MANAGEMENT -->
        <div class="col-md-6">
            <div class="card master-card p-4 h-100">

                <h5 class="fw-bold mb-4">USER MANAGEMENT</h5>

                <div class="mb-3">
                    <input type="text" class="form-control custom-input" placeholder="NAMA USER BARU">
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="select-wrapper w-100">
                        <select class="form-select custom-input">
                            <option selected disabled>PILIH ROLE</option>
                            <option>USER</option>
                            <option>ADMIN</option>
                            <option>STAFF</option>
                            <option>KAUR AKADEMIK</option>
                            <option>KAUR LAYANAN</option>
                        </select>
                        <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                    </div>

                    <button class="btn btn-danger btn-master">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

                <small class="label-list">DAFTAR USER AKTIF:</small>

                <div class="list-wrapper mt-3">
                    <div class="list-item d-flex justify-content-between">
                        <div>
                            <div class="fw-semibold">STAFF USER</div>
                            <small class="text-muted">USER</small>
                        </div>
                        <iconify-icon icon="mdi:close" class="icon-delete"></iconify-icon>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>