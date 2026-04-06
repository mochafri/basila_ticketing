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
                    <input type="text" class="kategori form-control custom-input" placeholder="NAMA KATEGORI BARU">
                    <button class="btn-kategori btn btn-danger btn-master">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

                <small class="label-list">DAFTAR KATEGORI AKTIF:</small>

                <?php foreach ($kategori as $data): ?>
                    <div class="kategori-card">

                        <div class="kategori-header">
                            <h6><?= $data['kategori_layanan'] ?></h6>
                            <iconify-icon icon="mdi:close" class="delete-kategori"></iconify-icon>
                        </div>

                        <div class="layanan-wrapper">
                            <?php $listLayanan = $group[$data['id']] ?? null; ?>
                            <?php if (!empty($listLayanan)): ?>
                                <?php foreach ($listLayanan as $ly): ?>
                                    <div class="layanan-tag">
                                        <?= $ly['per_kategori_layanan'] ?>
                                        <iconify-icon icon="mdi:close"></iconify-icon>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="layanan-tag">
                                    <i>Tidak ada data layanan</i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <!-- LAYANAN MANAGEMENT -->
        <div class="col-md-6">
            <div class="card master-card p-4 h-100">

                <h5 class="fw-bold mb-4">LAYANAN MANAGEMENT</h5>

                <div class="mb-3">
                    <input type="text" class="layanan form-control custom-input" placeholder="NAMA LAYANAN BARU">
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="select-wrapper w-100">
                        <select class="select-kategori form-select custom-input">
                            <option selected disabled>PILIH KATEGORI</option>
                            <?php foreach ($kategori as $data): ?>
                                <option value="<?= $data['id'] ?>"><?= $data['kategori_layanan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                    </div>

                    <button class="btn-layanan btn btn-danger btn-master">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>