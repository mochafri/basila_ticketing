<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="detail-tiket">
    <div class="row">
        <div class="col-12 col-xl-8 mb-4">
            <!-- nanti ini pakai pengkondisian sesuai role -->
            <?= $this->include('component/detail-tiket/detail-header', $detail); ?>
            <!-- detail kabag (default) -->
            <?= $this->include('component/detail-tiket/detail-body', [
                'detail' => $detail,
                'kaur' => $kaur,
                'staff' => $staff,
                'taskStaff' => $taskStaff,
                'taskStaffOnKaur' => $taskStaffOnKaur,
                'allTaskStaffOnKaur' => $allTaskStaffOnKaur,
                'kaurByTiketOpen' => $kaurByTiketOpen,
                'riwayat' => $riwayat
            ]); ?>
        </div>
        <div class="col-12 col-xl-4">
            <?= $this->include('component/detail-tiket/riwayat', ['riwayat' => $riwayat, 'detail' => $detail]); ?>
        </div>
    </div>
</div>
<?= $this->include('component/detail-tiket/user-manual-modal'); ?>
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
<?php 
    $role = session('role_name');
?>

<?php if ($role === 'SUPERADMIN'): ?>
    <script type="module" src="<?= base_url('assets/js/approveEskalasi.js') ?>"></script>
<?php elseif ($role === 'BAA'): ?>
    <script type="module" src="<?= base_url('assets/js/approveEskalasi.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/approveKabag.js') ?>"></script>
<?php elseif ($role === 'KEPALA URUSAN ADMINISTRASI AKADEMIK' || $role === 'ADMIN DATA MAHASISWA FAKULTAS'): ?>
    <script type="module" src="<?= base_url('assets/js/approveKaur.js') ?>"></script>
<?php elseif (in_array($role, ['PEGAWAI', 'ADMIN AKADEMIK'])): ?>
    <script type="module" src="<?= base_url('assets/js/staff.js') ?>"></script>
<?php endif; ?>
<?= $this->endSection(); ?>