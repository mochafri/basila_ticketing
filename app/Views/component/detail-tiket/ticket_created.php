<div class="d-flex align-items-center gap-3">
    <div class="timeline-icon-box bg-success text-white">
        <span class="step-num"><?= $step ?? 1 ?></span>
        <iconify-icon icon="hugeicons:plus-sign"></iconify-icon>
    </div>
    <div class="flex-grow-1">
        <p class="m-0 fw-bold custom-small-font">Tiket berhasil di ajukan</p>
        <div class="d-flex flex-wrap gap-2 mt-1">
            <span class="custom-text text-muted small d-flex align-items-center gap-1">
                <iconify-icon icon="ph:check-circle-bold" class="text-success"></iconify-icon>
                Selesai: <?= format_datetime_indo($detail['completed_at'] ?? $detail['created_at']) ?>
            </span>
            <span class="custom-text text-muted small d-flex align-items-center gap-1" title="Durasi dihitung dari waktu mulai hingga selesai" data-bs-toggle="tooltip">
                <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                Durasi: <?= format_duration($detail['created_at'], $detail['completed_at']) ?>
            </span>
        </div>
    </div>
</div>