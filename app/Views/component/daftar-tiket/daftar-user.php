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

<?php if (empty($tiket['data'])): ?>
    <div class="col-12 text-center py-5">
        <div class="py-5">
            <iconify-icon icon="solar:document-add-bold-duotone" class="text-danger opacity-25 mb-3" style="font-size: 80px;"></iconify-icon>
            <h5 class="fw-bold text-dark">BELUM ADA DATA TIKET</h5>
            <p class="text-muted small mb-4">
                <?php if (!empty($search)): ?>
                    Pencarian "<b><?= esc($search) ?></b>" tidak ditemukan. Coba sesuaikan kata kunci atau filter Anda.
                <?php else: ?>
                    Anda belum memiliki riwayat pengajuan tiket atau filter tidak cocok.
                <?php endif; ?>
            </p>
            <a href="<?= site_url('tiket') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold text-uppercase">
                Bersihkan Filter
            </a>
        </div>
    </div>
<?php else: ?>
    <?php
    $i = (($tiket['pager']->getCurrentPage() - 1) * $tiket['pager']->getPerPage()) + 1;

    foreach ($tiket['data'] as $data):
        $color = $statusColors[$data['tiket_status']] ?? 'secondary';
    ?>
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-4 hov-shadow transition-all position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 h-100 bg-<?= $color ?>" style="width: 4px; opacity: 0.6;"></div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="font-monospace fw-bold text-muted small"><?= $i++ ?></span>
                                <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> px-3 py-1 rounded-pill fw-bold text-uppercase d-inline-flex align-items-center gap-1" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                                    <iconify-icon icon="ph:dot-bold" class="fs-5"></iconify-icon>
                                    <?= $data['tiket_status'] ?>
                                </span>
                            </div>

                            <p class="text-muted custom-small-font mt-0 mb-0">
                                <?= strlen($data['deskripsi_permohonan']) > 100 ? substr(esc($data['deskripsi_permohonan']), 0, 100) . '...' : esc($data['deskripsi_permohonan']) ?>
                            </p>

                            <div class="d-flex flex-wrap align-items-center gap-3 mt-3 text-muted">
                                <div class="d-flex align-items-center gap-1">
                                    <iconify-icon icon="ph:stack-duotone" class="text-danger fs-5"></iconify-icon>
                                    <span class="custom-small-font fw-bold text-dark text-uppercase"><?= esc($data['kategori_layanan']) ?></span>
                                    <span class="mx-1 text-muted">•</span>
                                    <span class="custom-small-font text-muted italic"><?= esc($data['per_kategori_layanan']) ?></span>
                                </div>
                                <div class="vr opacity-25 d-none d-md-block" style="height: 1rem;"></div>
                                <div class="d-flex align-items-center gap-1">
                                    <iconify-icon icon="ph:calendar-blank-duotone" class="text-danger fs-5"></iconify-icon>
                                    <span class="custom-small-font fw-medium"><?= date('d M Y, H:i', strtotime($data['created_at'])) ?> WIB</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="<?= site_url('tiket/' . $data['id']) ?>" class="btn btn-outline-danger px-4 py-2 rounded-3 custom-small-font fw-bold text-uppercase d-inline-flex align-items-center gap-2 stretched-link">
                                Detail Tiket
                                <iconify-icon icon="ph:arrow-right-bold" class="fs-5"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 p-md-4 gap-2">
            <div class="pager-info d-none d-md-block">
                <span class="text-secondary custom-small-font">
                    Showing <b><?= (($tiket['pager']->getCurrentPage() - 1) * $tiket['pager']->getPerPage()) + 1 ?></b>
                    to <b><?= min($tiket['pager']->getCurrentPage() * $tiket['pager']->getPerPage(), $tiket['pager']->getTotal()) ?></b>
                    of <b><?= $tiket['pager']->getTotal() ?></b> entries
                </span>
            </div>
            <div class="d-flex justify-content-center justify-content-md-end w-100 w-md-auto">
                <?= $tiket['pager']->links('default', 'premium') ?>
            </div>
        </div>
    </div>
<?php endif; ?>
