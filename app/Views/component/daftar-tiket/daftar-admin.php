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

<style>
    .text-truncate-custom {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    /* Max widths for columns to force truncation */
    .col-kategori { max-width: 120px; }
    .col-layanan { max-width: 150px; }
    .col-pemohon { max-width: 130px; }
    .col-nim { max-width: 100px; }
    .col-fakultas { max-width: 150px; }
    .col-prodi { max-width: 150px; }
    .col-status { max-width: 120px; }
</style>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="table-layout: fixed; width: 100%;">
            <thead class="bg-light border-bottom">
                <tr>
                    <th class="ps-4 py-3 text-uppercase custom-small-font fw-bold text-secondary" style="width: 60px;">No</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary col-kategori" title="Kategori" data-bs-toggle="tooltip">
                        <span class="text-truncate-custom">Kategori</span>
                    </th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary col-layanan" title="Layanan" data-bs-toggle="tooltip">
                        <span class="text-truncate-custom">Layanan</span>
                    </th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary col-pemohon" title="Pemohon" data-bs-toggle="tooltip">
                        <span class="text-truncate-custom">Pemohon</span>
                    </th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary col-nim" title="NIM" data-bs-toggle="tooltip">
                        <span class="text-truncate-custom">NIM</span>
                    </th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary col-fakultas" title="Fakultas" data-bs-toggle="tooltip">
                        <span class="text-truncate-custom">Fakultas</span>
                    </th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary col-prodi" title="Prodi" data-bs-toggle="tooltip">
                        <span class="text-truncate-custom">Prodi</span>
                    </th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary" style="width: 100px;">Tanggal</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center" style="width: 120px;">Status</th>
                    <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center" style="width: 80px;">Level</th>
                    <th class="pe-4 py-3 text-uppercase custom-small-font fw-bold text-secondary text-end" style="width: 70px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = (($tiket['pager']->getCurrentPage() - 1) * $tiket['pager']->getPerPage()) + 1;
                foreach ($tiket['data'] as $data): 
                    $color = $statusColors[$data['tiket_status']] ?? 'secondary';
                    $levelColor = [
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger'
                    ][$data['level_kesulitan'] ?? ''] ?? 'secondary';
                ?>
                    <tr>
                        <td class="ps-4">
                            <span class="font-monospace fw-bold text-muted small"><?= $i++ ?></span>
                        </td>

                        <td class="col-kategori">
                            <div class="d-flex align-items-center gap-1" title="<?= esc($data['kategori_layanan']) ?>" data-bs-toggle="tooltip">
                                <span class="custom-small-font fw-bold text-dark text-uppercase text-truncate-custom"><?= esc($data['kategori_layanan']) ?></span>
                            </div>
                        </td>
                        <td class="col-layanan">
                            <div class="d-flex align-items-center gap-1" title="<?= esc($data['per_kategori_layanan']) ?>" data-bs-toggle="tooltip">
                                <span class="custom-small-font fw-medium text-dark text-truncate-custom"><?= esc($data['per_kategori_layanan']) ?></span>
                            </div>
                        </td>
                        <td class="col-pemohon">
                            <div class="d-flex align-items-center gap-1" title="<?= esc($data['nama_creator']) ?>" data-bs-toggle="tooltip">
                                <span class="custom-small-font fw-medium text-truncate-custom"><?= esc($data['nama_creator']) ?></span>
                            </div>
                        </td>
                        <td class="col-nim">
                            <span class="custom-small-font text-muted text-truncate-custom" title="<?= esc($data['nip_creator']) ?>" data-bs-toggle="tooltip"><?= esc($data['nip_creator']) ?></span>
                        </td>
                        <td class="col-fakultas">
                            <div class="d-flex align-items-center gap-1 text-muted" title="<?= esc($data['fakultas'] ?? '-') ?>" data-bs-toggle="tooltip">
                                <span class="custom-small-font text-truncate-custom"><?= esc($data['fakultas'] ?? '-') ?></span>
                            </div>
                        </td>
                        <td class="col-prodi">
                            <div class="d-flex align-items-center gap-1 text-muted" title="<?= esc($data['prodi'] ?? '-') ?>" data-bs-toggle="tooltip">
                                <span class="custom-small-font text-truncate-custom"><?= esc($data['prodi'] ?? '-') ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1 text-muted">
                                <iconify-icon icon="ph:calendar-blank-duotone" class="fs-6"></iconify-icon>
                                <span class="custom-small-font"><?= date('d/m/Y', strtotime($data['created_at'])) ?></span>
                            </div>
                        </td>
                        <td class="text-center col-status">
                            <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> px-2 py-1 rounded-pill fw-bold text-uppercase d-inline-flex align-items-center gap-1" style="font-size: 0.6rem; letter-spacing: 0.5px; max-width: 100%;" title="<?= $data['tiket_status'] ?>" data-bs-toggle="tooltip">
                                <iconify-icon icon="ph:dot-bold" class="fs-5 flex-shrink-0"></iconify-icon>
                                <span class="text-truncate-custom"><?= $data['tiket_status'] ?></span>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($data['level_kesulitan']): ?>
                                <span class="badge bg-<?= $levelColor ?> px-2 py-1 rounded-pill fw-bold text-uppercase" style="font-size: 0.55rem; letter-spacing: 0.5px;">
                                    <?= $data['level_kesulitan'] ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted small fst-italic">-</span>
                            <?php endif; ?>
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
                        <td colspan="7" class="text-center py-5">
                            <div class="py-5">
                                <iconify-icon icon="solar:document-add-bold-duotone" class="text-danger opacity-25 mb-3" style="font-size: 80px;"></iconify-icon>
                                <h5 class="fw-bold text-dark">TIDAK ADA TIKET DITEMUKAN</h5>
                                <p class="text-muted small mb-4">
                                    <?php if (!empty($search)): ?>
                                        Pencarian "<b><?= esc($search) ?></b>" tidak ditemukan. Coba sesuaikan kata kunci atau filter Anda.
                                    <?php else: ?>
                                        Coba sesuaikan filter Anda atau buat tiket baru.
                                    <?php endif; ?>
                                </p>
                                <a href="<?= site_url('tiket') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold text-uppercase">
                                    Bersihkan Filter
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination Footer -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 p-md-4 pt-0 gap-2">
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