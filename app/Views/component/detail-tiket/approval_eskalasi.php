<?php if ($detail['tiket_status'] === 'Escalated Process'): ?>
    <div class="d-flex gap-3 w-100 mb-4">
        <div class="timeline-icon-box bg-warning text-white">
            <span class="step-num"><?= $step ?? 2 ?></span>
            <iconify-icon icon="fluent:person-feedback-16-filled"></iconify-icon>
        </div>
        <div class="flex-grow-1">
            <p class="m-0 fw-bold mb-2 custom-small-font">approval eskalasi</p>
            <div class="p-4 bg-light rounded-3 w-100 d-flex gap-3 flex-column shadow-md border">
                <p class="m-0 fw-medium custom-text text-danger italic">Tiket ini sedang dalam proses eskalasi dan membutuhkan persetujuan.</p>
                <?php if (session('role_name') === 'BAA'): ?>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        <button type="button"
                            class="btn btn-approve-escalated btn-success flex-fill p-4 text-uppercase fw-bold rounded-4">Setujui Eskalasi</button>
                        <button type="button"
                            class="btn btn-reject-escalated btn-danger flex-fill p-4 text-uppercase fw-bold rounded-4">Tolak Eskalasi</button>
                    </div>
                <?php else: ?>
                    <p class="m-0 text-muted custom-small-font fst-italic">Menunggu persetujuan dari pihak BAA...</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (in_array($detail['tiket_status'], ['Approve Escalated', 'Open', 'In Progress', 'Closed'])): ?>
    <?php if ($detail['is_escalated']): ?>
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="timeline-icon-box bg-success text-white">
                <span class="step-num"><?= $step ?? 2 ?></span>
                <iconify-icon icon="ic:round-check"></iconify-icon>
            </div>
            <p class="m-0 fw-bold custom-small-font">approval eskalasi (Selesai)</p>
        </div>
    <?php endif; ?>
<?php endif; ?>
