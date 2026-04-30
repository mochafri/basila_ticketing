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
    <!-- INPUT SECTION -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card master-card p-5">
                <div class="row g-5">
                    <!-- ADD KATEGORI -->
                    <div class="col-md-6 border-end">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="icon-box" style="width: 45px; height: 45px; background: #ffe5e5; color: var(--primaryColor); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="solar:folder-plus-bold-duotone" style="font-size: 24px;"></iconify-icon>
                            </div>
                            <h5 class="fw-bold mb-0">TAMBAH KATEGORI</h5>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="kategori form-control custom-input" placeholder="NAMA KATEGORI BARU" id="inputKategori">
                        </div>
                        <div class="d-flex gap-3">
                            <input type="text" class="form-control custom-input" placeholder="DESKRIPSI KATEGORI" id="inputDeskripsi">
                            <button class="btn-kategori btn btn-danger btn-master">
                                <iconify-icon icon="mdi:plus"></iconify-icon>
                                SIMPAN
                            </button>
                        </div>
                    </div>

                    <!-- ADD LAYANAN -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="icon-box" style="width: 45px; height: 45px; background: #eef2ff; color: #4f46e5; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="solar:settings-bold-duotone" style="font-size: 24px;"></iconify-icon>
                            </div>
                            <h5 class="fw-bold mb-0">TAMBAH LAYANAN</h5>
                        </div>
                        <div class="mb-3">
                            <div class="select-wrapper w-100">
                                <select class="select-kategori form-select custom-input">
                                    <option selected disabled>PILIH KATEGORI TUJUAN</option>
                                    <?php foreach ($kategori as $data): ?>
                                        <option value="<?= $data['id'] ?>"><?= esc($data['kategori_layanan']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <input type="text" class="layanan form-control custom-input" id="inputLayanan" placeholder="NAMA LAYANAN BARU">
                            <button class="btn-layanan btn btn-danger btn-master">
                                <iconify-icon icon="mdi:plus"></iconify-icon>
                                SIMPAN
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LIST SECTION -->
    <div class="mb-4 d-flex justify-content-between align-items-end">
        <div>
            <h5 class="fw-bold mb-0">DAFTAR KATEGORI & LAYANAN</h5>
            <small class="text-muted">Kelola detail layanan untuk setiap kategori</small>
        </div>
        <div class="badge bg-danger-custom py-2 px-3" style="border-radius: 10px;">
            <?= count($kategori) ?> KATEGORI
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($kategori as $data): ?>
            <div class="col">
                <div class="card master-card category-box-card h-100 p-4 shadow-sm border-0">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 1.15rem; color: #1e293b; letter-spacing: 0.5px;"><?= esc($data['kategori_layanan']) ?></h6>
                            <?php if($data['deskripsi']): ?>
                                <small class="text-muted d-block" style="font-size: 0.85rem; line-height: 1.4;"><?= esc($data['deskripsi']) ?></small>
                            <?php endif; ?>
                        </div>
                        <button class="btn btn-light btn-sm rounded-circle delete-kategori btn-delete" data-id="<?= $data['id'] ?>" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none; background: #f8fafc;">
                            <iconify-icon icon="mdi:close" style="color: #64748b; font-size: 1.1rem;"></iconify-icon>
                        </button>
                    </div>

                    <div class="mt-auto">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 20px; height: 2px; background: var(--primaryColor);"></div>
                            <small class="label-list fw-bold text-uppercase" style="font-size: 10px; color: #94a3b8; letter-spacing: 1px;">Daftar Layanan</small>
                        </div>
                        <div class="layanan-wrapper d-flex flex-wrap gap-2">
                            <?php $listLayanan = $group[$data['id']] ?? null; ?>
                            <?php if (!empty($listLayanan)): ?>
                                <?php foreach ($listLayanan as $ly): ?>
                                    <div class="layanan-tag d-flex align-items-center gap-2" style="background: #f8fafc; padding: 7px 14px; border-radius: 12px; font-size: 0.85rem; font-weight: 500; color: #475569; border: 1px solid #f1f5f9;">
                                        <?= esc($ly['per_kategori_layanan']) ?>
                                        <iconify-icon icon="mdi:close" class="btn-delete-layanan" data-id="<?= $ly['id'] ?>" style="font-size: 14px; color: #cbd5e1; cursor: pointer;"></iconify-icon>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="w-100 text-center py-3 bg-light rounded-3" style="border: 1px dashed #e2e8f0;">
                                    <small class="text-muted"><i>Tidak ada layanan</i></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
    <script type="module" src="<?= base_url('assets/js/inputKategori.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/inputLayanan.js') ?>"></script>
<?= $this->endSection(); ?>