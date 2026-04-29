<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-2" id="daftar-tiket">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
        <div>
            <h2 class="text-uppercase fw-bold m-0">Daftar Tiket</h2>
            <p class="text-muted small m-0">Pantau status permohonan aktif anda secara real-time</p>
        </div>
        <div class="d-flex flex-fill justify-content-md-end gap-2">
            <a href="<?= site_url('tiket/create') ?>" class="btn btn-danger fw-bold text-uppercase d-flex align-items-center gap-2 px-4 shadow-sm rounded-3">
                <iconify-icon icon="hugeicons:plus-sign" class="fs-5"></iconify-icon>
                <span>Buat Tiket Baru</span>
            </a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <form action="<?= site_url('tiket') ?>" method="get" class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 bg-light p-3 rounded-4 border border-light shadow-sm">
                
                <!-- Search -->
                <div class="input-group shadow-sm rounded-pill overflow-hidden border bg-white flex-grow-1" style="max-width: 350px; height: 45px;">
                    <span class="input-group-text bg-transparent border-0 pe-1">
                        <iconify-icon icon="ph:magnifying-glass-bold" class="text-muted"></iconify-icon>
                    </span>
                    <input type="text" name="search" class="form-control border-0 bg-transparent ps-2 custom-small-font" style="box-shadow: none; font-weight: 500;" placeholder="Cari ID, Judul, Kategori..." value="<?= esc($search ?? '') ?>">
                </div>

                <div class="vr opacity-25 d-none d-lg-block" style="height: 2rem;"></div>

                <!-- Filter Icon -->
                <div class="d-flex align-items-center gap-2 text-muted ms-lg-2" style="white-space: nowrap;">
                    <iconify-icon icon="solar:filter-linear" style="font-size: 20px;"></iconify-icon>
                    <span class="small fw-bold text-uppercase" style="letter-spacing: 1px;">Filter</span>
                </div>

                <!-- Kategori Dropdown -->
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
                
                <!-- Status Dropdown -->
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

                <!-- Buttons -->
                <div class="d-flex gap-2 ms-lg-auto mt-2 mt-lg-0">
                    <button type="submit" class="btn btn-danger shadow-sm rounded-pill px-4 fw-bold text-uppercase d-flex align-items-center gap-2" style="height: 45px; font-size: 0.85rem;">
                        <iconify-icon icon="solar:rounded-magnifer-bold-duotone" class="fs-6"></iconify-icon>
                        Terapkan
                    </button>
                    <?php if (!empty($search) || !empty($filter_kategori) || !empty($filter_status)): ?>
                        <a href="<?= site_url('tiket') ?>" class="btn btn-white shadow-sm rounded-pill px-4 fw-bold text-uppercase d-flex align-items-center justify-content-center bg-white border-0 text-muted" style="height: 45px; font-size: 0.85rem;">
                            Reset
                        </a>
                    <?php endif; ?>
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
            <div class="mt-5">
            <?php if (session('role_name') == 'MAHASISWA'): ?>
                <?= $this->include('component/daftar-tiket/daftar-user', ['tiket' => $tiket]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
