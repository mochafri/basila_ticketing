<?php 
$statusColors = [
    'Waiting'           => 'warning',
    'Open'              => 'info',
    'Escalated Process' => 'secondary',
    'Approve Escalated' => 'primary',
    'In Progress'       => 'primary',
    'Closed'            => 'success',
    'Rejected'          => 'danger'
];
?>

<?php foreach ($tiket as $data): 
    $color = $statusColors[$data['tiket_status']] ?? 'secondary';
?>
    <div class="col-12 mb-3">
        <div class="card border-0 shadow-sm rounded-4 hov-shadow transition-all position-relative overflow-hidden">
            <!-- Subtle accent border -->
            <div class="position-absolute top-0 start-0 h-100 bg-<?= $color ?>" style="width: 4px; opacity: 0.6;"></div>
            
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="font-monospace fw-bold text-muted small">#<?= $data['id'] ?></span>
                            <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> px-3 py-1 rounded-pill fw-bold text-uppercase d-inline-flex align-items-center gap-1" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                                <iconify-icon icon="ph:dot-bold" class="fs-5"></iconify-icon>
                                <?= $data['tiket_status'] ?>
                            </span>
                        </div>
                        <h5 class="card-title fw-extra-bold text-dark text-uppercase m-0 transition-all hover-danger" style="letter-spacing: -0.5px;"><?= esc($data['judul_permohonan']) ?></h5>
                        
                        <div class="d-flex flex-wrap align-items-center gap-3 mt-3 text-muted">
                            <div class="d-flex align-items-center gap-1">
                                <iconify-icon icon="ph:stack-duotone" class="text-danger fs-5"></iconify-icon>
                                <span class="custom-small-font fw-bold text-dark text-uppercase"><?= esc($data['kategori_layanan']) ?></span>
                            </div>
                            <div class="vr opacity-25 d-none d-md-block" style="height: 1rem;"></div>
                            <div class="d-flex align-items-center gap-1">
                                <iconify-icon icon="ph:calendar-blank-duotone" class="text-danger fs-5"></iconify-icon>
                                <span class="custom-small-font fw-medium"><?= date('d M Y, H:i', strtotime($data['created_at'])) ?> WIB</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="<?= site_url('tiket/'. $data['id']) ?>" class="btn btn-outline-danger px-4 py-2 rounded-3 custom-small-font fw-bold text-uppercase d-inline-flex align-items-center gap-2 stretched-link">
                            Detail Tiket
                            <iconify-icon icon="ph:arrow-right-bold" class="fs-5"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>