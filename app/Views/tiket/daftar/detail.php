<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php 
    $roleName  = session('role_name');
    $loginUser = strtolower(session('login_username') ?? '');
    $userId    = session('user_identifier');
    $isAdmin   = ($roleName === 'SUPERADMIN' || $loginUser === 'admin' || $userId === '000000');
    $isReadOnly = ($loginUser === 'admin' && $roleName !== 'SUPERADMIN');
?>
<div class="container-fluid" id="detail-tiket">
    <div class="row">
        <div class="col-8">
            <!-- nanti ini pakai pengkondisian sesuai role -->
            <?= $this->include('component/detail-tiket/detail-header'); ?>
            <!-- detail kabag (default) -->
            <?= $this->include('component/detail-tiket/detail-body'); ?>
            <!-- detail kaur 1 (pak bagas) -->
            <!-- detail kaur 2 (pak bagas) -->
             <!-- detail staff (pak bagas) -->
        </div>
        <div class="col-4">
            <?= $this->include('component/detail-tiket/riwayat', $riwayat); ?>
        </div>
    </div>
</div>
<?= $this->include('component/detail-tiket/user-manual-modal'); ?>
<?= $this->endSection() ?>