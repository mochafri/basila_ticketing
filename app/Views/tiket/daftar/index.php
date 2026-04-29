<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-2" id="daftar-tiket">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="text-uppercase fw-bold m-0">Daftar Tiket</h2>
            <p class="text-muted small m-0">Pantau status permohonan aktif anda secara real-time</p>
        </div>

        <div class="d-flex flex-fill justify-content-md-end gap-2">
            <form action="" method="get" class="d-flex gap-2 flex-grow-1 flex-md-grow-0" style="min-width: 350px;">
                <div class="input-group shadow-sm rounded-3 overflow-hidden border flex-grow-1">
                    <span class="input-group-text bg-white border-0">
                        <iconify-icon icon="ph:magnifying-glass-bold" class="text-muted"></iconify-icon>
                    </span>
                    <input type="text" name="search" class="form-control border-0 ps-0" placeholder="Cari ID, Judul, Kategori..." value="<?= esc($search ?? '') ?>">
                    <?php if ($search): ?>
                        <a href="<?= site_url('tiket') ?>" class="btn btn-white border-0 d-flex align-items-center">
                            <iconify-icon icon="ph:x-circle-fill" class="text-muted"></iconify-icon>
                        </a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-danger fw-bold text-uppercase px-3 shadow-sm rounded-3">Cari</button>
            </form>

            <a href="tiket/create" class="btn btn-danger fw-bold text-uppercase d-flex align-items-center gap-2 px-3 shadow-sm rounded-3">
                <iconify-icon icon="hugeicons:plus-sign" class="fs-5"></iconify-icon>
                <span>Baru</span>
            </a>
        </div>
    </div>
    <div class="row">
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