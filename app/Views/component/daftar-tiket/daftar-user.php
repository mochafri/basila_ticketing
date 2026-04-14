<?php
    $no = 1;
    foreach ($tiket as $data): ?>
    <div class="col-12">
        <div class="card mt-3 border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 d-flex align-items-center gap-4">
                        <span class="kodePengajuan text-uppercase"><?= $no++ ?></span>
                        <span
                            class="statusPengajuan text-uppercase fw-bold bg-body-secondary px-2 py-1 rounded-5 "><?= $data['tiket_status'] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5 class="card-title text-uppercase fw-bold py-3"><?= $data['judul_permohonan'] ?></h5>
                        <a href="<?= site_url('tiket/'. $data['id']) ?>" class="stretched-link"></a>
                    </div>
                </div>
                <div class="row end-row">
                    <div class="col-12 d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="hugeicons:group-01"></iconify-icon>
                            <span class="kodePengajuan text-uppercase fw-bold"><?= $data['kategori_layanan'] ?></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="hugeicons:clock-01"></iconify-icon>
                            <span class="kodePengajuan text-uppercase fw-bold"><?= date('Y-m-d', strtotime($data['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>