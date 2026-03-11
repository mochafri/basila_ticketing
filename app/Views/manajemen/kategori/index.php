<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4 px-4 dashboard-wrapper">

    <!-- Header -->
    <div class="mb-5">
        <div>
            <h2 class="fw-bold title-dashboard">MASTER DATA MANAGEMENT</h2>
            <span class="text-muted subtitle-dashboard">
                Kelola kategori dan layanan akses dalam sistem BASILA
            </span>
        </div>
    </div>

    <!-- CARD CONTEN -->
    <div class="row g-4">

        <!-- ROLE MANAGEMENT -->
        <div class="col-md-6">
            <div class="card master-card p-4 h-100">
                <h5 class="fw-bold mb-4">KATEGORI MANAGEMENT</h5>

                <div class="d-flex gap-3 mb-4">
                    <input type="text" class="form-control custom-input" placeholder="NAMA KATEGORI BARU">
                    <button class="btn btn-danger btn-master">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

                <small class="label-list">DAFTAR KATEGORI AKTIF:</small>

                <div class="kategori-card">

                    <div class="kategori-header">
                        <h6>REGISTRASI</h6>
                        <iconify-icon icon="mdi:close" class="delete-kategori"></iconify-icon>
                    </div>

                    <div class="layanan-wrapper">

                        <div class="layanan-tag">
                            REGISTRASI MATA KULIAH
                            <iconify-icon icon="mdi:close"></iconify-icon>
                        </div>

                        <div class="layanan-tag">
                            REGISTRASI ULANG
                            <iconify-icon icon="mdi:close"></iconify-icon>
                        </div>

                        <div class="layanan-tag">
                            CUTI AKADEMIK
                            <iconify-icon icon="mdi:close"></iconify-icon>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        <!-- USER MANAGEMENT -->
        <div class="col-md-6">
            <div class="card master-card p-4 h-100">

                <h5 class="fw-bold mb-4">LAYANAN MANAGEMENT</h5>

                <div class="mb-3">
                    <input type="text" class="form-control custom-input" placeholder="NAMA LAYANAN BARU">
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="select-wrapper w-100">
                        <select class="form-select custom-input">
                            <option selected disabled>PILIH KATEGORI</option>
                            <option>REGISTRASI</option>
                        </select>
                        <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                    </div>

                    <button class="btn btn-danger btn-master">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>