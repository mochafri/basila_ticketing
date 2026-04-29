<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                Tiket Detail #<?= $detail['id'] ?>
            </span>
            <div class="vr opacity-25" style="height: 1rem;"></div>
            <span class="custom-small-font fw-bold text-muted text-uppercase"><?= $detail['tiket_status'] ?></span>
        </div>

        <h2 class="text-uppercase fw-bold m-0 mb-4" style="letter-spacing: -1.5px; line-height: 1.2; font-size: 2.2rem; color: #1a1a1a;">
            <?= esc($detail['judul_permohonan']) ?>
        </h2>

        <!-- Metadata Section -->
        <div class="bg-light bg-opacity-50 rounded-4 border border-light p-3 mb-4">
            <!-- Row 1: Informasi Layanan & Pemohon -->
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-4 mb-3 pb-3 border-bottom border-dark border-opacity-10">
                <!-- 1. Kategori -->
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="ph:stack-duotone" class="text-danger fs-5"></iconify-icon>
                    <div>
                        <span class="d-block fw-bold text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Kategori</span>
                        <span class="custom-small-font fw-bold text-dark text-uppercase"><?= esc($detail['kategori_layanan'] ?? '-') ?></span>
                    </div>
                </div>

                <!-- 2. Layanan -->
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="ph:folder-simple-duotone" class="text-danger fs-5"></iconify-icon>
                    <div>
                        <span class="d-block fw-bold text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Layanan</span>
                        <span class="custom-small-font fw-bold text-dark text-uppercase"><?= esc($detail['per_kategori_layanan'] ?? '-') ?></span>
                    </div>
                </div>

                <div class="vr d-none d-lg-block opacity-25" style="height: 1.5rem;"></div>

                <!-- 3. Pemohon -->
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="ph:user-circle-duotone" class="text-danger fs-5"></iconify-icon>
                    <div>
                        <span class="d-block fw-bold text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pemohon</span>
                        <span class="custom-small-font fw-bold text-dark text-uppercase"><?= esc($detail['nama_creator'] ?? '-') ?></span>
                    </div>
                </div>
            </div>

            <!-- Row 2: Informasi Waktu -->
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-4">
                <!-- 4. Waktu Pengajuan -->
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="ph:calendar-blank-duotone" class="text-muted fs-5"></iconify-icon>
                    <div>
                        <span class="d-block fw-bold text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Diajukan</span>
                        <span class="custom-small-font text-dark fw-bold"><?= date('d M Y, H:i', strtotime($detail['created_at'] ?? '-')) ?></span>
                    </div>
                </div>

                <?php if ($detail['closed_at']): ?>
                    <div class="vr d-none d-lg-block opacity-25" style="height: 1.5rem;"></div>

                    <!-- 5. Waktu Selesai -->
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="ph:check-circle-duotone" class="text-success fs-5"></iconify-icon>
                        <div>
                            <span class="d-block fw-bold text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Selesai</span>
                            <span class="custom-small-font text-success fw-bold"><?= date('d M Y, H:i', strtotime($detail['closed_at'])) ?></span>
                        </div>
                    </div>

                    <div class="vr d-none d-lg-block opacity-25" style="height: 1.5rem;"></div>

                    <!-- 6. Durasi Pengerjaan -->
                    <?php
                    $awal  = new DateTime($detail['created_at']);
                    $akhir = new DateTime($detail['closed_at']);
                    $diff  = $awal->diff($akhir);

                    $parts = [];
                    if ($diff->d > 0) $parts[] = $diff->d . " Hari";
                    if ($diff->h > 0) $parts[] = $diff->h . " Jam";
                    if ($diff->i > 0) $parts[] = $diff->i . " Menit";
                    $durasi = empty($parts) ? "< 1 Menit" : implode(" ", $parts);
                    ?>
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="ph:timer-duotone" class="text-primary fs-5"></iconify-icon>
                        <div>
                            <span class="d-block fw-bold text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Durasi</span>
                            <span class="custom-small-font text-primary fw-bold"><?= $durasi ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mt-2 px-1">
            <p class="text-dark lh-base m-0" style="font-size: 1rem;">
                <?= nl2br(esc($detail['deskripsi_permohonan'])) ?>
            </p>
        </div>
    </div>
</div>