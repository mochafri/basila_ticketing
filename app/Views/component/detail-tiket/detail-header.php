<div class="card mb-4 border-0 shadow-sm rounded-4 overlay-container overflow-hidden">
    <div class="card-header p-5 pb-4 bg-white border-0">
        <div class="d-flex align-items-center gap-2 mb-3">
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
                $color = $statusColors[$detail['tiket_status']] ?? 'secondary';
            ?>
            <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> px-3 py-2 rounded-pill fw-bold text-uppercase d-inline-flex align-items-center gap-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                <iconify-icon icon="ph:dot-bold" class="fs-5"></iconify-icon>
                <?= $detail['tiket_status'] ?>
            </span>
            <span class="text-muted font-monospace" style="font-size: 0.7rem;">#<?= $detail['id'] ?></span>
        </div>

        <h2 class="text-uppercase fw-bold m-0 mb-4" style="letter-spacing: -1.5px; line-height: 1.1; font-size: 2.2rem; color: #1a1a1a;">
            <?= esc($detail['judul_permohonan']) ?>
        </h2>

        <!-- Metadata Section: Compact & Elegant -->
        <div class="d-flex flex-wrap align-items-center gap-3 gap-md-4 py-3 px-4 bg-light bg-opacity-50 rounded-4 border border-light">
            
            <!-- Kategori & Layanan -->
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="ph:stack-duotone" class="text-danger fs-5"></iconify-icon>
                <div>
                    <span class="d-block custom-small-font fw-bold text-dark text-uppercase" style="line-height: 1;"><?= esc($detail['kategori_layanan']) ?></span>
                    <span class="custom-small-font text-muted" style="font-size: 0.6rem;"><?= esc($detail['per_kategori_layanan']) ?></span>
                </div>
            </div>

            <div class="vr d-none d-md-block opacity-25" style="height: 1.5rem;"></div>

            <!-- Pembuat Tiket -->
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="ph:user-circle-duotone" class="text-danger fs-5"></iconify-icon>
                <div>
                    <span class="d-block custom-small-font fw-bold text-dark text-uppercase" style="line-height: 1;"><?= esc($detail['nama_creator'] ?? 'Pemohon') ?></span>
                    <span class="custom-small-font text-muted font-monospace" style="font-size: 0.6rem;">NIP: <?= esc($detail['nip_creator'] ?? '-') ?></span>
                </div>
            </div>

            <div class="vr d-none d-md-block opacity-25" style="height: 1.5rem;"></div>

            <!-- Tanggal -->
            <div class="d-flex align-items-center gap-2">
                <iconify-icon icon="ph:calendar-blank-duotone" class="text-danger fs-5"></iconify-icon>
                <div>
                    <span class="d-block custom-small-font fw-bold text-dark text-uppercase" style="line-height: 1;">Waktu Pengajuan</span>
                    <span class="custom-small-font text-muted" style="font-size: 0.6rem;"><?= date('d M Y, H:i', strtotime($detail['created_at'])) ?> WIB</span>
                </div>
            </div>

        </div>
    </div>

    <div class="card-body p-5 pt-0">
        <div class="task-desc py-4">
            <p class="fs-5 fw-medium text-secondary" style="line-height: 1.6;"><?= nl2br(esc($detail['deskripsi_permohonan'])) ?></p>
        </div>
        
        <?php if (!empty($detail['dokumen_lampiran'])): ?>
        <div class="mt-2 pt-4 border-top">
            <span class="text-uppercase custom-small-font fw-bold text-muted d-block mb-3" style="letter-spacing: 1px;">Dokumen Pendukung:</span>
            <a href="<?= base_url('tiket/file/users/' . $detail['dokumen_lampiran']) ?>" target="_blank"
                class="btn btn-outline-danger d-inline-flex align-items-center gap-2 px-4 py-2 rounded-3 transition-all hov-shadow">
                <iconify-icon icon="ph:file-pdf-duotone" class="fs-4"></iconify-icon>
                <span class="custom-small-font fw-bold">
                    <?= esc($detail['original_dokumen_name']) ?>
                </span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>