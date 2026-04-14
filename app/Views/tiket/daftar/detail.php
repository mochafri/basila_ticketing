<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="detail-tiket">
    <div class="row">
        <div class="col-8">
            <!-- nanti ini pakai pengkondisian sesuai role -->
            <?= $this->include('component/detail-tiket/detail-header', $detail); ?>
            <!-- detail kabag (default) -->
            <?= $this->include('component/detail-tiket/detail-body', $detail); ?>
            <!-- detail kaur 1 (pak bagas) -->
            <!-- detail kaur 2 (pak bagas) -->
             <!-- detail staff (pak bagas) -->
        </div>
        <div class="col-4">
            <?= $this->include('component/detail-tiket/riwayat'); ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>