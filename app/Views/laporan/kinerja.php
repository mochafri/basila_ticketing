<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark text-uppercase mb-1" style="letter-spacing: -0.5px;">Laporan Kinerja Staff</h4>
            <p class="text-muted small mb-0">Monitor produktivitas dan kecepatan penyelesaian tugas staf</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 rounded-3 px-3 py-2 fw-bold" onclick="window.print()">
                <iconify-icon icon="ph:printer-bold"></iconify-icon> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="<?= site_url('laporan/kinerja') ?>" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label custom-small-font fw-bold text-secondary text-uppercase">Rentang Tanggal</label>
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control border-0 bg-light rounded-start-3" value="<?= esc($filters['start_date']) ?>">
                        <span class="input-group-text border-0 bg-light">-</span>
                        <input type="date" name="end_date" class="form-control border-0 bg-light rounded-end-3" value="<?= esc($filters['end_date']) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label custom-small-font fw-bold text-secondary text-uppercase">Pilih Staff</label>
                    <select name="staff_nip" class="form-select border-0 bg-light rounded-3">
                        <option value="">Semua Staff</option>
                        <?php foreach ($staffList as $stf): ?>
                            <option value="<?= esc($stf['nip_staff']) ?>" <?= $filters['staff_nip'] == $stf['nip_staff'] ? 'selected' : '' ?>>
                                <?= esc($stf['nama_staff']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-danger w-100 rounded-3 py-2 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2">
                        <iconify-icon icon="ph:funnel-bold"></iconify-icon> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="<?= site_url('laporan/kinerja') ?>" class="btn btn-light w-100 rounded-3 py-2 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Performance Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase custom-small-font fw-bold text-secondary">Nama Staff</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">Total Tugas</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">Tugas Selesai</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary text-center">Belum Selesai</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Rata-rata Waktu</th>
                        <th class="py-3 text-uppercase custom-small-font fw-bold text-secondary">Total Waktu</th>
                        <th class="pe-4 py-3 text-uppercase custom-small-font fw-bold text-secondary text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kinerja as $row): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle bg-danger bg-opacity-10 text-danger fw-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        <?= strtoupper(substr($row['nama_staff'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-extra-bold text-dark text-uppercase small"><?= esc($row['received_by'] ?? null) ?></div>
                                        <div class="text-muted" style="font-size: 0.65rem;">NIP: <?= esc($row['nip_receive_task']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-dark"><?= $row['total_tugas'] ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 fw-bold"><?= $row['tugas_selesai'] ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 fw-bold"><?= $row['tugas_belum_selesai'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1 text-primary fw-bold small">
                                    <iconify-icon icon="ph:timer-bold"></iconify-icon>
                                    <?= format_minutes($row['avg_durasi_menit']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <?= format_minutes($row['total_durasi_menit']) ?>
                                </div>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="<?= site_url('laporan/kinerja/detail/' . $row['nip_receive_task']) ?>" class="btn btn-sm btn-outline-danger rounded-3 px-3 py-1 fw-bold text-uppercase" style="font-size: 0.65rem;">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($kinerja)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted fst-italic">
                                <div class="d-flex flex-column justify-content-center align-items-center w-100">
                                    <iconify-icon icon="ph:users-three-duotone" class="fs-1 mb-2 opacity-50"></iconify-icon>
                                    <p class="mb-0">Belum ada data kinerja staff.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
