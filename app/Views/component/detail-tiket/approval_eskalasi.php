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
                
                <?php if (!empty($detail['notes_request_escalated'])): ?>
                    <div class="bg-white p-3 rounded-3 border-start border-4 border-warning shadow-sm">
                        <div class="d-flex align-items-center gap-2 mb-2 text-warning">
                            <iconify-icon icon="ph:info-bold"></iconify-icon>
                            <span class="fw-bold text-uppercase" style="font-size: .65rem; letter-spacing: 1px;">Alasan Eskalasi (Kabag)</span>
                        </div>
                        <p class="m-0 custom-small-font fst-italic text-dark">
                            "<?= esc($detail['notes_request_escalated']) ?>"
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (session('role_name') === 'SUPERADMIN'): ?>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        <button type="button"
                            class="btn btn-approve-escalated btn-success flex-fill p-4 text-uppercase fw-bold rounded-4">Setujui Eskalasi</button>
                        <button type="button"
                            class="btn btn-reject-escalated btn-danger flex-fill p-4 text-uppercase fw-bold rounded-4">Tolak Eskalasi</button>
                    </div>
                <?php else: ?>
                    <p class="m-0 text-muted custom-small-font fst-italic">Menunggu persetujuan dari pihak Admin (Pak Tora)...</p>
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
            <div class="flex-grow-1">
                <p class="m-0 fw-bold mb-2 custom-small-font text-uppercase">approval eskalasi (Selesai)</p>
                <div class="p-3 bg-light rounded-3 w-100 d-flex gap-3 flex-column border">
                    <?php if (!empty($detail['notes_request_escalated'])): ?>
                        <div class="bg-white p-3 rounded-2 border shadow-sm">
                            <div class="d-flex align-items-center gap-1 mb-1 text-muted">
                                <iconify-icon icon="ph:info-bold" style="font-size: .8rem;"></iconify-icon>
                                <span class="fw-bold text-uppercase" style="font-size: .6rem; letter-spacing: 1px;">Alasan Eskalasi</span>
                            </div>
                            <p class="m-0 custom-small-font fst-italic">"<?= esc($detail['notes_request_escalated']) ?>"</p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($detail['notes_after_escalated'])): ?>
                        <div class="bg-white p-3 rounded-2 border-start border-4 border-success shadow-sm">
                            <div class="d-flex align-items-center gap-1 mb-1 text-success">
                                <iconify-icon icon="ph:check-circle-bold" style="font-size: .8rem;"></iconify-icon>
                                <span class="fw-bold text-uppercase" style="font-size: .6rem; letter-spacing: 1px;">Keputusan Eskalasi</span>
                            </div>
                            <p class="m-0 custom-small-font fw-bold">"<?= esc($detail['notes_after_escalated']) ?>"</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
