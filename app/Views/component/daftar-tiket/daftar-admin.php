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

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-2">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light border-bottom">
                <tr>
                    <th class="ps-4 py-3 text-uppercase custom-small-font fw-bold text-secondary" style="width: 80px;">ID</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Judul Permohonan</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Kategori</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Pengaju</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Tanggal</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">Status</th>
                    <th class="pe-4 py-3 text-uppercase custom-small-font fw-bold text-secondary text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tiket['data'] as $data): 
                    $color = $statusColors[$data['tiket_status']] ?? 'secondary';
                ?>
                    <tr>
                        <td class="ps-4">
                            <span class="font-monospace fw-bold text-muted small">#<?= $data['id'] ?></span>
                        </td>
                        <td>
                            <div class="fw-extra-bold text-dark text-uppercase small" style="letter-spacing: -0.2px;"><?= esc($data['judul_permohonan']) ?></div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <iconify-icon icon="ph:stack-duotone" class="text-danger fs-6"></iconify-icon>
                                <span class="custom-small-font fw-bold text-dark text-uppercase"><?= esc($data['kategori_layanan']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <iconify-icon icon="ph:user-duotone" class="text-danger fs-6"></iconify-icon>
                                <span class="custom-small-font fw-medium"><?= esc($data['nama_creator']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1 text-muted">
                                <iconify-icon icon="ph:calendar-blank-duotone" class="fs-6"></iconify-icon>
                                <span class="custom-small-font"><?= date('d/m/Y', strtotime($data['created_at'])) ?></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> px-3 py-1 rounded-pill fw-bold text-uppercase d-inline-flex align-items-center gap-1" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                                <iconify-icon icon="ph:dot-bold" class="fs-5"></iconify-icon>
                                <?= $data['tiket_status'] ?>
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <a href="<?= site_url('tiket/'. $data['id']) ?>" class="btn btn-sm btn-outline-danger rounded-3 p-1 px-2 d-inline-flex align-items-center justify-content-center">
                                <iconify-icon icon="ph:arrow-right-bold" class="fs-6"></iconify-icon>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($tiket['data'])): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <iconify-icon icon="ph:empty-duotone" class="fs-1 d-block mb-2"></iconify-icon>
                            Belum ada data tiket.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination Footer -->
    <div class="d-flex justify-content-between align-items-center p-4 pt-0">
        <div class="pager-info d-none d-md-block">
            <span class="text-secondary custom-small-font">
                Showing <b><?= (($tiket['pager']->getCurrentPage() - 1) * $tiket['pager']->getPerPage()) + 1 ?></b>
                to <b><?= min($tiket['pager']->getCurrentPage() * $tiket['pager']->getPerPage(), $tiket['pager']->getTotal()) ?></b>
                of <b><?= $tiket['pager']->getTotal() ?></b> entries
            </span>
        </div>
        <div>
            <?= $tiket['pager']->links('default', 'premium') ?>
        </div>
    </div>
</div>