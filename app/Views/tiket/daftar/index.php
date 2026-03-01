<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="daftar-tiket">
    <div class="row header">
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
        <div class="col-12">
            <div class="card mt-5 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center gap-4">
                            <span class="kodePengajuan text-uppercase">ID #T-001</span>
                            <span
                                class="statusPengajuan text-uppercase fw-bold bg-body-secondary px-2 py-1 rounded-5 ">pending_approval</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title text-uppercase fw-bold py-3">pengajuan registrasi mk terlambat</h5>
                        </div>
                    </div>
                    <div class="row end-row">
                        <div class="col-12 d-flex align-items-center gap-4">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="hugeicons:group-01"></iconify-icon>
                                <span class="kodePengajuan text-uppercase fw-bold">registrasi</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="hugeicons:clock-01"></iconify-icon>
                                <span class="kodePengajuan text-uppercase fw-bold">26/02/2026</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>