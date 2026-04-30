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
                Diajukan: <?= format_datetime_indo($detail['created_at']) ?>
            </span>
        </div>
    </div>
</div>