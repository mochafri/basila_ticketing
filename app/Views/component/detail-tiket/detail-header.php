<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-4">
        <!-- Badges & ID -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <?php 
                $statusColors = [
                    'Waiting'           => 'warning',
                    'Open'              => 'info',
                    'In Progress'       => 'primary',
                    'Closed'            => 'success',
                    'Rejected'          => 'danger'
                ];
                $sColor = $statusColors[$detail['tiket_status']] ?? 'secondary';
            ?>
            <span class="badge bg-<?= $sColor ?> bg-opacity-10 text-<?= $sColor ?> px-3 py-2 rounded-pill fw-bold text-uppercase d-flex align-items-center gap-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                <iconify-icon icon="ph:dot-bold" class="fs-4"></iconify-icon>
                <?= $detail['tiket_status'] ?>
            </span>
            
            <?php if (!empty($detail['level_kesulitan'])): 
                $levelColors = [
                    'low' => 'success',
                    'medium' => 'warning',
                    'high' => 'danger'
                ];
                $lColor = $levelColors[$detail['level_kesulitan']] ?? 'secondary';
            ?>
                <span class="badge bg-<?= $lColor ?> bg-opacity-10 text-<?= $lColor ?> px-3 py-2 rounded-pill fw-bold text-uppercase d-inline-flex align-items-center gap-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                    <iconify-icon icon="ph:gauge-duotone" class="fs-5"></iconify-icon>
                    LEVEL: <?= $detail['level_kesulitan'] ?>
                </span>
            <?php endif; ?>

            <span class="text-muted small fw-bold">#<?= $detail['id'] ?></span>
        </div>

        <!-- INFO GRID (Grey Box) -->
        <div class="bg-light bg-opacity-50 rounded-4 border border-light p-4 mb-4">
            <div class="row g-4 align-items-center">
                <!-- 1. KATEGORI & LAYANAN -->
                <div class="col-md-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-white p-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <iconify-icon icon="ph:stack-duotone" class="text-danger fs-3"></iconify-icon>
                        </div>
                        <div>
                            <h6 class="fw-bold text-uppercase m-0 mb-1" style="font-size: 0.85rem; letter-spacing: 0.5px;"><?= esc($detail['kategori_layanan'] ?? '-') ?></h6>
                            <p class="text-muted small m-0" style="font-size: 0.75rem;"><?= esc($detail['per_kategori_layanan'] ?? '-') ?></p>
                        </div>
                    </div>
                </div>

                <!-- 2. PEMOHON -->
                <div class="col-md-4 border-start border-dark border-opacity-10">
                    <div class="d-flex align-items-start gap-3 ps-md-3">
                        <div class="bg-white p-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <iconify-icon icon="ph:user-circle-duotone" class="text-danger fs-3"></iconify-icon>
                        </div>
                        <div>
                            <h6 class="fw-bold text-uppercase m-0 mb-1" style="font-size: 0.85rem; letter-spacing: 0.5px;"><?= esc($detail['nama_creator'] ?? '-') ?></h6>
                            <p class="text-muted small m-0" style="font-size: 0.75rem;">NIP / NIM: <?= esc($detail['nip_creator'] ?? '-') ?></p>
                        </div>
                    </div>
                </div>

                <!-- 3. WAKTU -->
                <div class="col-md-4 border-start border-dark border-opacity-10">
                    <div class="d-flex align-items-start gap-3 ps-md-3">
                        <div class="bg-white p-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <iconify-icon icon="ph:calendar-blank-duotone" class="text-danger fs-3"></iconify-icon>
                        </div>
                        <div>
                            <h6 class="fw-bold text-uppercase m-0 mb-1" style="font-size: 0.85rem; letter-spacing: 0.5px;">Waktu Pengajuan</h6>
                            <p class="text-muted small m-0" style="font-size: 0.75rem;"><?= date('d M Y, H:i', strtotime($detail['created_at'])) ?> WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="px-1 mb-4">
            <p class="text-muted lh-base m-0" style="font-size: 1.1rem; font-style: italic;">
                <?= nl2br(esc($detail['deskripsi_permohonan'])) ?>
            </p>
        </div>

        <!-- Dokumen Pendukung -->
        <?php if (!empty($detail['dokumen_lampiran'])): ?>
            <div class="mt-4 pt-3 border-top border-light">
                <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 1.2px;">Dokumen Pendukung:</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= site_url('tiket/file/users/' . $detail['dokumen_lampiran']) ?>" target="_blank" 
                       class="btn btn-white border shadow-sm rounded-3 px-3 py-2 d-inline-flex align-items-center gap-2 text-danger hover-bg-danger-subtle transition-all">
                        <iconify-icon icon="ph:file-pdf-duotone" class="fs-3"></iconify-icon>
                        <span class="fw-bold" style="font-size: 0.9rem;"><?= esc($detail['original_dokumen_name'] ?? 'Lihat Dokumen') ?></span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>