<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-4" id="daftar-tiket">
    <div class="row header mb-5">
        <div class="col-6">
            <h2 class="text-uppercase fw-bold">Daftar Tiket Layanan</h2>
            <span>Manajemen dan pantau status seluruh permohonan aktif anda</span>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <button class="btn add-btn fw-bold d-flex align-items-center gap-2" onclick="window.location.href='<?= site_url('tiket/create') ?>'">
                <iconify-icon icon="hugeicons:plus-sign" class="text-white"></iconify-icon>
                <span class="text-uppercase" style="color: white;">tiket baru</span>
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2 text-muted me-2" style="white-space: nowrap;">
                <iconify-icon icon="solar:filter-linear" style="font-size: 20px;"></iconify-icon>
                <span class="small fw-bold text-uppercase" style="letter-spacing: 1px;">Filter Tiket</span>
            </div>
            <form action="<?= site_url('tiket') ?>" method="get" class="d-flex flex-wrap align-items-center gap-3">
                <div style="min-width: 200px;">
                    <select name="kategori" class="form-select custom-input bg-white border-0 shadow-sm rounded-pill px-4" style="height: 45px; font-size: 0.85rem; font-weight: 600;">
                        <option value="" <?= empty($filter_kategori) ? 'selected' : '' ?>>SEMUA KATEGORI</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($filter_kategori) && $filter_kategori != '' && $filter_kategori == $cat['id']) ? 'selected' : '' ?>>
                                <?= esc($cat['kategori_layanan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="min-width: 180px;">
                    <select name="status" class="form-select custom-input bg-white border-0 shadow-sm rounded-pill px-4" style="height: 45px; font-size: 0.85rem; font-weight: 600;">
                        <option value="" <?= empty($filter_status) ? 'selected' : '' ?>>SEMUA STATUS</option>
                        <?php 
                        $statuses = ['Waiting', 'On Progress', 'Selesai', 'Reject'];
                        foreach($statuses as $s): ?>
                            <option value="<?= $s ?>" <?= (isset($filter_status) && $filter_status == $s) ? 'selected' : '' ?>>
                                <?= strtoupper($s) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger shadow-sm rounded-pill px-4 fw-bold text-uppercase" style="height: 45px; font-size: 0.85rem;">
                        <iconify-icon icon="solar:filter-bold-duotone" class="me-1"></iconify-icon>
                        Filter
                    </button>
                    <a href="<?= site_url('tiket') ?>" class="btn btn-white shadow-sm rounded-pill px-4 fw-bold text-uppercase d-flex align-items-center justify-content-center bg-white border-0 text-muted" style="height: 45px; font-size: 0.85rem;">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- daftar tiket admin -->
            <?php if (
                session('role_name') === 'SUPERADMIN' ||
                session('role_name') === 'KEPALA URUSAN ADMINISTRASI AKADEMIK' ||
                session('role_name') === 'PEGAWAI' ||
                session('role_name') === 'ADMIN AKADEMIK' ||
                session('role_name') === 'BAA'
            ): ?>
                <?= $this->include('component/daftar-tiket/daftar-admin', ['tiket' => $tiket]); ?>
            <?php endif; ?>
            <!-- daftar tiket user -->
            <?php if (session('role_name') == 'MAHASISWA'): ?>
                <?= $this->include('component/daftar-tiket/daftar-user', ['tiket' => $tiket]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
