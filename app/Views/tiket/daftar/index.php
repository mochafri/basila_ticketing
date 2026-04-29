<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-2" id="daftar-tiket">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="text-uppercase fw-bold m-0">Daftar Tiket</h2>
            <p class="text-muted small m-0">Pantau status permohonan aktif anda secara real-time</p>
        </div>
        <div class="d-flex flex-fill justify-content-md-end gap-2">
            <form action="<?= site_url('tiket') ?>" method="get" class="d-flex gap-2 flex-grow-1 flex-md-grow-0" style="min-width: 350px;">
                <?php if (!empty($filter_kategori)): ?>
                    <input type="hidden" name="kategori" value="<?= esc($filter_kategori) ?>">
                <?php endif; ?>
                <?php if (!empty($filter_status)): ?>
                    <input type="hidden" name="status" value="<?= esc($filter_status) ?>">
                <?php endif; ?>
                <div class="input-group shadow-sm rounded-3 overflow-hidden border flex-grow-1">
                    <span class="input-group-text bg-white border-0">
                        <iconify-icon icon="ph:magnifying-glass-bold" class="text-muted"></iconify-icon>
                    </span>
                    <input type="text" name="search" class="form-control border-0 ps-0" placeholder="Cari ID, Judul, Kategori..." value="<?= esc($search ?? '') ?>">
                    <?php if (!empty($search)): ?>
                        <a href="<?= site_url('tiket') ?>" class="btn btn-white border-0 d-flex align-items-center">
                            <iconify-icon icon="ph:x-circle-fill" class="text-muted"></iconify-icon>
                        </a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-danger fw-bold text-uppercase px-3 shadow-sm rounded-3">Cari</button>
            </form>

            <a href="<?= site_url('tiket/create') ?>" class="btn btn-danger fw-bold text-uppercase d-flex align-items-center gap-2 px-3 shadow-sm rounded-3">
                <iconify-icon icon="hugeicons:plus-sign" class="fs-5"></iconify-icon>
                <span>Baru</span>
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2 text-muted me-2" style="white-space: nowrap;">
                <iconify-icon icon="solar:filter-linear" style="font-size: 20px;"></iconify-icon>
                <span class="small fw-bold text-uppercase" style="letter-spacing: 1px;">Filter Tiket</span>
            </div>
            <form action="<?= site_url('tiket') ?>" method="get" class="d-flex flex-wrap align-items-center gap-3">
                <?php if (!empty($search)): ?>
                    <input type="hidden" name="search" value="<?= esc($search) ?>">
                <?php endif; ?>
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
<<<<<<< HEAD
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
=======
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
        <div class="mt-5">
>>>>>>> origin/Ilham
            <?php if (session('role_name') == 'MAHASISWA'): ?>
                <?= $this->include('component/daftar-tiket/daftar-user', ['tiket' => $tiket]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
