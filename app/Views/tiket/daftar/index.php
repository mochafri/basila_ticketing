<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-4" id="daftar-tiket">
    <div class="row header mb-5">
        <div class="col-6">
            <h2 class="text-uppercase fw-bold">Daftar Tiket Layanan</h2>
            <span>Manajemen dan pantau status seluruh permohonan aktif anda</span>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <button class="btn add-btn fw-bold d-flex align-items-center gap-2">
                <iconify-icon icon="hugeicons:plus-sign" class="text-white"></iconify-icon>
                <span class="text-uppercase">tiket baru</span>
            </button>
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
            <?= $this->include('component/daftar-tiket/daftar-admin', $tiket); ?>
        <?php endif; ?>
        <!-- daftar tiket user -->
        <?php if (session('role_name') == 'MAHASISWA'): ?>
            <?= $this->include('component/daftar-tiket/daftar-user', $tiket); ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>