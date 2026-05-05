<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="<?= site_url('laporan/kinerja') ?>" class="text-decoration-none text-muted small d-flex align-items-center gap-1 mb-2">
                <iconify-icon icon="ph:arrow-left-bold"></iconify-icon> Kembali ke Laporan Utama
            </a>
            <h4 class="fw-bold text-dark text-uppercase mb-1" style="letter-spacing: -0.5px;">Detail Kinerja: <?= esc($nama_staff) ?></h4>
            <p class="text-muted small mb-0">Rincian seluruh tugas yang dikerjakan oleh staff (NIP: <?= esc($nip_staff) ?>)</p>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="row g-4 mb-4">
        <?php 
            $completedTasks = array_filter($detail, fn($t) => $t['task_status'] === 'Selesai');
            $totalDuration = array_sum(array_map(fn($t) => ($t['task_status'] === 'Selesai' && $t['started_at'] && $t['completed_at']) ? (strtotime($t['completed_at']) - strtotime($t['started_at'])) / 60 : 0, $detail));
            $avgDuration = count($completedTasks) > 0 ? $totalDuration / count($completedTasks) : 0;
        ?>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-danger-custom text-white p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white text-opacity-75 text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Total Tugas Selesai</p>
                        <h2 class="fw-extra-bold mb-0"><?= count($completedTasks) ?></h2>
                    </div>
                    <iconify-icon icon="ph:check-circle-duotone" class="fs-1 text-white text-opacity-25"></iconify-icon>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success-custom text-white p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white text-opacity-75 text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Rata-rata Kecepatan</p>
                        <h2 class="fw-extra-bold mb-0"><?= format_minutes($avgDuration) ?></h2>
                    </div>
                    <iconify-icon icon="ph:timer-duotone" class="fs-1 text-white text-opacity-25"></iconify-icon>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-blue-custom text-white p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-white text-opacity-75 text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Total Waktu Kerja</p>
                        <h2 class="fw-extra-bold mb-0"><?= format_minutes($totalDuration) ?></h2>
                    </div>
                    <iconify-icon icon="ph:clock-duotone" class="fs-1 text-white text-opacity-25"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <!-- Task List Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase custom-small-font fw-bold text-secondary">No</th>
                        <th class="ps-4 py-3 text-uppercase custom-small-font fw-bold text-secondary">Judul Tugas / Instruksi</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">ID Tiket</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">Kategori</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">Layanan</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Mulai</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Selesai</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">Status</th>
                        <th class="pe-4 py-3 text-uppercase custom-small-font fw-bold text-secondary text-end">Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    foreach ($detail as $task): ?>
                        <tr>
                            <td class="ps-4">
                                <div class=""><?= $i++ ?></div>
                            </td>
                            <td class="ps-4">
                                <div class="fw-bold text-dark text-uppercase small"><?= esc($task['task_instruction'] ?: 'TIDAK ADA INSTRUKSI') ?></div>
                            </td>
                            <td class="text-center">
                                <a href="<?= site_url('tiket/' . $task['ticket_id']) ?>" class="text-decoration-none fw-bold text-primary small">
                                    #<?= esc($task['ticket_id']) ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-pill custom-small-font fw-bold">
                                    <?= esc($task['kategori_layanan'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 rounded-pill custom-small-font fw-bold">
                                    <?= esc($task['per_kategori_layanan'] ?? '-') ?>
                                </span>
                            </td>
                            <td>
                                <div class="custom-small-font text-muted"><?= format_datetime_indo($task['started_at']) ?></div>
                            </td>
                            <td>
                                <div class="custom-small-font text-muted"><?= format_datetime_indo($task['completed_at']) ?></div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?= $task['task_status'] === 'Selesai' ? 'success' : 'warning' ?> bg-opacity-10 text-<?= $task['task_status'] === 'Selesai' ? 'success' : 'warning' ?> px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size: 0.6rem;">
                                    <?= $task['task_status'] ?>
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <?php if ($task['started_at'] && $task['completed_at']): ?>
                                    <span class="fw-extra-bold text-dark small">
                                        <?= format_duration($task['started_at'], $task['completed_at']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted small fst-italic">Dalam proses</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
