<?php if ($detail['tiket_status'] === 'Waiting' || $detail['tiket_status'] === 'Approve Escalated'): ?>
    <div class="d-flex gap-3 w-100">
        <iconify-icon icon="<?php if ($detail['tiket_status'] === 'Waiting'): ?>streamline-ultimate:task-list-approve<?php else: ?>ic:round-check<?php endif; ?>" class="text-white h-25 <?php if ($detail['tiket_status'] === 'Waiting'): ?>btn btn-danger<?php else: ?>btn btn-success<?php endif; ?>"></iconify-icon>
        <div class="flex-grow-1">
            <p class="m-0 fw-bold mb-2 custom-small-font">approval kepala urusan (bu fira)</p>
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
                <div class="d-flex gap-2 flex-wrap mt-4">
                    <button type="button"
                        class="btn btn-approve btn-success flex-fill p-4 text-uppercase fw-bold rounded-4">setujui
                        &
                        tugaskan</button>
                    <button type="button"
                        class="btn btn-escalated btn-primary flex-fill p-4 text-uppercase fw-bold rounded-4">eskalasi</button>
                    <button class="btn btn-reject btn-danger flex-fill p-4 text-uppercase fw-bold rounded-4">tolak</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($detail['tiket_status'] === 'Open'): ?>
    <div class="d-flex align-items-center gap-3">
        <iconify-icon icon="<?php if ($detail['tiket_status'] === 'Waiting'): ?>streamline-ultimate:task-list-approve<?php else: ?>ic:round-check<?php endif; ?>" class="text-white <?php if ($detail['tiket_status'] === 'Waiting'): ?> btn btn-secondary <?php else: ?> btn btn-success <?php endif; ?> "></iconify-icon>
        <p class="m-0 fw-bold custom-small-font">approval kepala urusan (bu fira)</p>
    </div>
<?php endif; ?>
<div class="d-flex align-items-center gap-3">
    <iconify-icon icon="<?php if ($detail['tiket_status'] === 'Waiting'): ?>streamline-ultimate:task-list-approve<?php else: ?>hugeicons:task-done-01<?php endif; ?>" class="text-white <?php if ($detail['tiket_status'] === 'Waiting'): ?> btn btn-secondary <?php elseif ($detail['tiket_status'] === 'Open'): ?> btn btn-danger <?php else: ?> btn btn-success <?php endif; ?> "></iconify-icon>
    <p class="m-0 fw-bold custom-small-font">
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
</div>
<?php
$hasFinish = in_array('Finish', array_column($kaurByTiketOpen, 'flag'));

if ($hasFinish): ?>
    <?php
    $finishedKaurCount = 0;
    foreach ($kaurByTiketOpen as $kr) {
        if ($kr['flag'] === 'Finish') {
            $finishedKaurCount++;
        }
    }

    if ($finishedKaurCount > 0): ?>
        <div class="d-flex gap-3 w-100">
            <iconify-icon icon="solar:clipboard-check-bold" class="text-white btn h-25 btn-success"></iconify-icon>
            <div class="flex-grow-1">
                <p class="m-0 fw-bold custom-small-font mb-2">HASIL TUGAS KAUR</p>
                <div class="list-group list-group-flush border rounded-3 shadow-sm bg-white overflow-hidden">
                    <?php foreach ($kaurByTiketOpen as $kr): ?>
                        <?php if ($kr['flag'] === 'Finish'): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-start py-3 bg-white">
                                <div class="flex-grow-1 me-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="fw-bold text-uppercase small text-dark"><?= esc($kr['kaur_name']) ?></span>
                                        <span class="badge bg-success-subtle text-success border border-success" style="font-size: 0.6rem;">SELESAI</span>
                                    </div>

                                    <div class="ps-2 border-start border-2">
                                        <?php
                                        $hasStaffTask = false;
                                        foreach ($allTaskStaffOnKaur as $tsk):
                                            if ($tsk['fk_assign_to_kaur'] == $kr['id']):
                                                $hasStaffTask = true;
                                        ?>
                                                <div class="mb-2 small">
                                                    <div class="text-primary fw-bold" style="font-size: 0.75rem;"><?= esc($tsk['assign_task_to_staff']) ?></div>
                                                    <p class="text-muted m-0 small"><?= esc($tsk['catatan_laporan_penyelesaian']) ?: 'Tidak ada catatan.' ?></p>
                                                    <?php if (!empty($tsk['taks_dokumen'])): ?>
                                                        <a href="<?= base_url('/tiket/file/admin/' . $tsk['taks_dokumen']) ?>" target="_blank" class="text-decoration-none fw-bold small text-info"><iconify-icon icon="ph:paperclip-bold" class="align-middle"></iconify-icon> Dokumen</a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php
                                            endif;
                                        endforeach;
                                        if (!$hasStaffTask):
                                            ?>
                                            <small class="text-muted fst-italic">Kaur menyelesaikan tugas tanpa delegasi staff.</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($detail['tiket_status'] !== 'Closed'): ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-revisi-kaur-individual fw-bold px-3"
                                        data-id="<?= $kr['id'] ?>" data-name="<?= $kr['kaur_name'] ?>" style="font-size: 0.7rem;">
                                        REVISI
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<div class="d-flex gap-3 w-100">
    <iconify-icon icon="<?= $detail['tiket_status'] === 'Closed' ? 'ph:check-bold' : 'ph:flow-arrow' ?>"
        class="text-white btn h-25 
        <?= $detail['tiket_status'] === 'Closed' ? 'btn-success' : ($detail['tiket_status'] === 'In Progress' ? 'btn-danger' : 'btn-secondary') ?> "></iconify-icon>
    <div class="flex-grow-1 gap-2 d-flex flex-column">
        <p class="m-0 fw-bold custom-small-font">konfirmasi penyelesaian</p>
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