<?php
$titleKabag = ($detail['tiket_status'] === 'Escalated Process') ? 'PROSES ESKALASI OLEH DIREKTUR' : 'approval kepala bagian (bu fira)';
$kabagFinishedAt = !empty($kaurByTiketOpen) ? min(array_column($kaurByTiketOpen, 'started_at')) : null;
?>
<?php if (($detail['tiket_status'] === 'Open' && empty($kaurByTiketOpen)) || $detail['tiket_status'] === 'Approve Escalated' || $detail['tiket_status'] === 'Escalated Process' || $detail['tiket_status'] === 'Reject'): ?>
    <div class="d-flex gap-3 w-100">
        <div class="timeline-icon-box bg-danger text-white">
            <span class="step-num"><?= $step ?? 2 ?></span>
            <iconify-icon icon="streamline-ultimate:task-list-approve"></iconify-icon>
        </div>
        <div class="flex-grow-1">
            <p class="m-0 fw-bold mb-2 custom-small-font text-uppercase"><?= $titleKabag ?></p>
            <?php if ($detail['tiket_status'] === 'Escalated Process'): ?>
                <div class="d-flex flex-wrap gap-2 mt-1 mb-2">
                    <span class="custom-text text-warning small d-flex align-items-center gap-1">
                        <iconify-icon icon="ph:clock-countdown-bold"></iconify-icon>
                        Menunggu direktor menyetujui eskalasi...
                    </span>
                </div>
                <?php if (!empty($detail['notes_request_escalated'])): ?>
                    <div class="p-4 bg-white rounded-4 shadow-sm border mb-3">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <iconify-icon icon="ph:info-bold" class="text-warning fs-5"></iconify-icon>
                            <span class="fw-bold text-uppercase custom-small-font" style="letter-spacing: 0.5px;">Catatan Permintaan Eskalasi</span>
                        </div>
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-warning">
                            <p class="m-0 small text-dark" style="line-height: 1.6;"><?= esc($detail['notes_request_escalated']) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($detail['tiket_status'] === 'Approve Escalated' || $detail['tiket_status'] === 'Reject'): ?>
                <?php if (!empty($detail['notes_after_escalated'])): ?>
                    <div class="p-4 bg-white rounded-4 shadow-sm border mb-3">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <iconify-icon icon="ph:chat-centered-dots-bold" class="<?= $detail['tiket_status'] === 'Approve Escalated' ? 'text-success' : 'text-danger' ?> fs-5"></iconify-icon>
                            <span class="fw-bold text-uppercase custom-small-font" style="letter-spacing: 0.5px;">Respon Eskalasi (Direktur)</span>
                        </div>
                        <div class="p-3 <?= $detail['tiket_status'] === 'Approve Escalated' ? 'bg-success' : 'bg-danger' ?> bg-opacity-10 rounded-3 border-start border-4 <?= $detail['tiket_status'] === 'Approve Escalated' ? 'border-success' : 'border-danger' ?>">
                            <p class="m-0 small text-dark fst-italic" style="line-height: 1.6;">"<?= esc($detail['notes_after_escalated']) ?>"</p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($detail['tiket_status'] !== 'Escalated Process'): ?>
                <div class="p-4 bg-light rounded-3 w-100 d-flex gap-3 flex-column shadow-md border">
                    <p class="m-0 fw-medium custom-text">Pilih delegasi kepala bagian</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <?php if (!empty($kaur)): ?>
                            <?php foreach ($kaur as $kr): ?>
                                <label
                                    class="flex-fill p-4 bg-white d-flex justify-content-between align-items-center rounded-3 shadow-sm"
                                    style="cursor: pointer;">
                                    <span class="text-uppercase fw-bold"><?= esc($kr['nama_kaur']); ?></span>
                                    <input type="checkbox" name="kaur_id[]" value="<?= esc($kr['nip_kaur']); ?>"
                                        data-name="<?= esc($kr['nama_kaur']); ?>" class="form-check-input kabag-checkbox mb-0"
                                        style="width: 1.25rem; height: 1.25rem;">
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted mb-0 w-100">Data delegasi kepala urusan tidak tersedia.</p>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4">
                        <p class="m-0 fw-medium custom-text mb-2 text-uppercase">Level Kesulitan Tiket</p>
                        <select id="level_kesulitan" class="form-select p-3 rounded-3 fw-bold text-uppercase custom-small-font border-0 shadow-sm" style="cursor: pointer; background-color: #fff;">
                            <?php if (!empty($detail['level_kesulitan'])): ?>
                                <option value="<?= $detail['level_kesulitan'] ?>" selected>🔴 <?= $detail['level_kesulitan'] ?></option>
                            <?php else: ?>
                                <option value="" selected disabled>-- Pilih Level Kesulitan --</option>
                                <option value="low">🟢 Low</option>
                                <option value="medium">🟡 Medium</option>
                                <option value="high">🔴 High</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mt-4">
                        <button type="button"
                            class="btn btn-approve btn-success flex-fill p-4 text-uppercase fw-bold rounded-4">DELEGASIKAN TUGAS</button>
                        <button type="button"
                            class="btn btn-escalated btn-primary flex-fill p-4 text-uppercase fw-bold rounded-4">eskalasi</button>
                        <button class="btn btn-reject btn-danger flex-fill p-4 text-uppercase fw-bold rounded-4">tolak</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php elseif (!empty($kaurByTiketOpen)): ?>
    <div class="d-flex gap-3 w-100">
        <div class="timeline-icon-box bg-success text-white">
            <span class="step-num"><?= $step ?? 2 ?></span>
            <iconify-icon icon="ic:round-check"></iconify-icon>
        </div>
        <div class="flex-grow-1">
            <p class="m-0 fw-bold custom-small-font text-uppercase"><?= $titleKabag ?></p>
            <div class="d-flex flex-wrap gap-2 mt-1">
                <span class="custom-text text-muted small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:check-circle-bold" class="text-success"></iconify-icon>
                    Selesai: <?= format_datetime_indo($kabagFinishedAt) ?>
                </span>
                <span class="custom-text text-muted small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                    Durasi: <?= format_duration($detail['created_at'], $kabagFinishedAt) ?>
                </span>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
$kaurFinished = array_filter($kaurByTiketOpen, fn($k) => ($k['flag'] ?? '') === 'Finish');
$maxCompleted = !empty($kaurFinished) ? max(array_column($kaurFinished, 'completed_at')) : null;
$allFinished = !empty($kaurByTiketOpen) && count($kaurFinished) === count($kaurByTiketOpen);
?>
<div class="d-flex align-items-center gap-3">
    <div class="timeline-icon-box <?= empty($kaurByTiketOpen) ? 'bg-secondary' : ($allFinished ? 'bg-success' : 'bg-danger') ?> text-white">
        <span class="step-num"><?= ($step ?? 2) + 1 ?></span>
        <iconify-icon icon="<?= empty($kaurByTiketOpen) ? 'streamline-ultimate:task-list-approve' : 'hugeicons:task-done-01' ?>"></iconify-icon>
    </div>
    <div class="flex-grow-1">
        <p class="m-0 fw-bold custom-small-font text-uppercase">
            penugasan :
            <span id="penugasan-list" class="text-secondary fw-normal fst-italic">
                <?php if (!empty($kaurByTiketOpen)): ?>
                    <?php foreach ($kaurByTiketOpen as $k): ?>
                        <span class="badge bg-secondary">
                            <?= strtoupper($k['kaur_name']) ?>
                        </span>
                    <?php endforeach; ?>
                <?php else: ?>
                    Belum ada pilihan
                <?php endif; ?>
            </span>
        </p>
        <div class="d-flex flex-wrap gap-2 mt-1">
            <?php if ($allFinished): ?>
                <span class="custom-text text-muted small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:check-circle-bold" class="text-success"></iconify-icon>
                    Selesai: <?= format_datetime_indo($maxCompleted) ?>
                </span>
                <span class="custom-text text-muted small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                    Durasi: <?= format_duration($kabagFinishedAt, $maxCompleted) ?>
                </span>
            <?php elseif (!empty($kaurByTiketOpen)): ?>
                <span class="custom-text text-warning small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:clock-countdown-bold"></iconify-icon>
                    Sedang berjalan... (Mulai: <?= format_datetime_indo($detail['completed_at']) ?>)
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if (!empty($kaurByTiketOpen)): ?>
    <div class="d-flex gap-3 w-100">
        <div class="timeline-icon-box <?= $allFinished ? 'bg-success' : 'bg-danger' ?> text-white">
            <span class="step-num">4</span>
            <iconify-icon icon="solar:clipboard-check-bold"></iconify-icon>
        </div>
        <div class="flex-grow-1">
            <p class="m-0 fw-bold custom-small-font mb-2 text-uppercase">Detail Pengerjaan Kaur & Staff</p>
            <div class="list-group list-group-flush border rounded-3 shadow-sm bg-white overflow-hidden">
                <?php foreach ($kaurByTiketOpen as $kr):
                    $isKaurFinished = ($kr['flag'] ?? '') === 'Finish';
                    $hasStaffProgress = false;
                    $kaurStaffTasks = array_filter($allTaskStaffOnKaur, fn($tsk) => $tsk['fk_assign_to_kaur'] == $kr['id']);
                    if (!empty($kaurStaffTasks)) $hasStaffProgress = true;
                ?>
                    <div class="list-group-item d-flex justify-content-between align-items-start py-3 bg-white">
                        <div class="flex-grow-1 me-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="fw-bold text-uppercase small text-dark"><?= esc($kr['kaur_name']) ?></span>
                                <?php if ($isKaurFinished): ?>
                                    <span class="badge bg-success-subtle text-success border border-success me-2" style="font-size: 0.6rem;">SELESAI</span>
                                    <span class="custom-text text-muted" style="font-size: 0.65rem;">
                                        ⏱️ <?= format_duration($kr['started_at'], $kr['completed_at']) ?>
                                    </span>
                                <?php elseif ($hasStaffProgress):
                                    $isMandiri = !empty(array_filter($kaurStaffTasks, fn($t) => (int)($t['is_kaur_accepted'] ?? 0) === 1));
                                ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger me-2" style="font-size: 0.6rem;"><?= $isMandiri ? 'DIKERJAKAN KAUR' : 'SEDANG DIKERJAKAN STAFF' ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary me-2" style="font-size: 0.6rem;">MENUNGGU PROSES KAUR</span>
                                <?php endif; ?>
                            </div>

                            <div class="ps-2 border-start border-2">
                                <?php if (!empty($kaurStaffTasks)): ?>
                                    <?php foreach ($kaurStaffTasks as $tsk): ?>
                                        <div class="mb-2 small">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="<?= $tsk['task_status'] === 'Selesai' ? 'text-success' : 'text-danger' ?> fw-bold text-uppercase" style="font-size: 0.7rem;">
                                                    <iconify-icon icon="<?= $tsk['task_status'] === 'Selesai' ? 'ph:check-circle-bold' : 'ph:clock-countdown-bold' ?>"></iconify-icon>
                                                    <?= esc($tsk['received_by']) ?>
                                                </div>
                                                <?php if ($tsk['task_status'] === 'Selesai'): ?>
                                                    <span class="text-muted" style="font-size: 0.6rem;">(⏱️ <?= format_duration($tsk['started_at'], $tsk['completed_at']) ?>)</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border-0" style="font-size: 0.55rem;">PROSES</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($tsk['task_status'] === 'Selesai'): ?>
                                                <p class="text-muted m-0 small mt-1">"<?= esc($tsk['catatan_laporan_penyelesaian']) ?: 'Staf telah menyelesaikan tugas.' ?>"</p>
                                                <?php if (!empty($tsk['taks_dokumen'])): ?>
                                                    <a href="<?= base_url('/tiket/file/admin/' . $tsk['taks_dokumen']) ?>" target="_blank" class="text-decoration-none fw-bold small text-info"><iconify-icon icon="ph:paperclip-bold" class="align-middle"></iconify-icon> Dokumen</a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <p class="text-muted m-0 small mt-1 italic opacity-75"><?= (int)($tsk['is_kaur_accepted'] ?? 0) === 1 ? 'Kaur mengambil alih tugas tiket.' : 'Staf sedang mengerjakan instruksi kaur...' ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <small class="text-muted fst-italic">Belum ada delegasi staff untuk bagian ini.</small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($isKaurFinished && $detail['tiket_status'] !== 'Closed'): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-revisi-kaur-individual fw-bold px-3"
                                data-id="<?= $kr['id'] ?>" data-name="<?= $kr['kaur_name'] ?>" style="font-size: 0.7rem;">
                                REVISI
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="d-flex gap-3 w-100">
    <div class="timeline-icon-box <?= $detail['tiket_status'] === 'Closed' ? 'bg-success' : ($detail['tiket_status'] === 'In Progress' ? (in_array('Finish', array_column($kaurByTiketOpen, 'flag')) ? 'bg-danger' : 'bg-secondary') : 'bg-secondary') ?> text-white">
        <span class="step-num"><?php if (!empty($kaurByTiketOpen)): ?>5<?php else: ?>4<?php endif; ?></span>
        <iconify-icon icon="<?= $detail['tiket_status'] === 'Closed' ? 'ph:check-bold' : 'ph:flow-arrow' ?>"></iconify-icon>
    </div>
    <div class="flex-grow-1 gap-2 d-flex flex-column">
        <p class="m-0 fw-bold custom-small-font text-uppercase">konfirmasi penyelesaian</p>

        <?php if ($detail['tiket_status'] === 'Closed' && !empty($detail['completed_at'])): ?>
            <div class="d-flex flex-wrap gap-3 mt-1">
                <span class="custom-text text-muted small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:check-circle-bold" class="text-success"></iconify-icon>
                    Selesai: <?= format_datetime_indo($detail['completed_at']) ?>
                </span>
                <span class="custom-text text-muted small d-flex align-items-center gap-1" title="Total durasi pengerjaan tiket" data-bs-toggle="tooltip">
                    <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                    Durasi: <?= format_duration($detail['created_at'], $detail['completed_at']) ?>
                </span>
            </div>
        <?php endif; ?>

        <?php if ($detail['tiket_status'] === 'In Progress'): ?>
            <div class="d-flex flex-wrap gap-2">
                <?php if (in_array('Finish', array_column($kaurByTiketOpen, 'flag'))): ?>
                    <button
                        class="btn btn-tutup-tiket btn-success flex-fill text-uppercase fw-bold rounded-3 custom-small-font py-3 px-4">tutup
                        tiket (selesai)</button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.kabag-checkbox');
        const penugasanList = document.getElementById('penugasan-list');

        function updatePenugasan() {
            const selected = [];
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selected.push(cb.getAttribute('data-name').toUpperCase());
                }
            });

            if (selected.length > 0) {
                penugasanList.textContent = selected.join(', ');
                penugasanList.classList.remove('text-secondary', 'fw-normal');
            } else {
                penugasanList.textContent = 'Belum ada pilihan';
                penugasanList.classList.add('text-secondary', 'fw-normal');
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updatePenugasan);
        });
    });
</script>