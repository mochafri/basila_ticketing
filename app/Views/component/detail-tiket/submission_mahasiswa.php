<?php
$statusText = '';
$icon = '';
$btnClass = '';

    switch ($detail['tiket_status']) {
        case 'Open':
            $statusText = empty($kaurByTiketOpen) ? 'Sedang ditinjau : Kepala Bagian (Pendelegasian Tugas)' : 'Sedang ditinjau : Kepala Urusan (Bu Farida / Pak Bagas)';
            $icon = 'streamline-ultimate:task-list-approve';
            $btnClass = 'btn-warning';
            break;
        case 'In Progress':
            $statusText = 'Sedang diproses oleh Petugas Terkait';
            $icon = 'hugeicons:task-done-01';
            $btnClass = 'btn-info';
            break;
        case 'Closed':
            $statusText = 'Tiket telah selesai dan ditutup';
            $icon = 'ph:check-bold';
            $btnClass = 'btn-success';
            break;
        case 'Rejected':
            $statusText = 'Tiket ditolak';
            $icon = 'ph:x-bold';
            $btnClass = 'btn-danger';
            break;
        default:
            $statusText = 'Status pengajuan: ' . $detail['tiket_status'];
            $icon = 'ph:clock';
            $btnClass = 'btn-secondary';
            break;
    }
?>
<div class="d-flex gap-3 w-100">
    <div class="timeline-icon-box <?= str_replace('btn-', 'bg-', $btnClass) ?> text-white">
        <span class="step-num"><?= $step ?? 2 ?></span>
        <iconify-icon icon="<?= $icon ?>"></iconify-icon>
    </div>
    <div class="flex-grow-1">
        <p class="m-0 fw-bold custom-small-font text-uppercase"><?= $statusText ?></p>
        
        <?php if ($detail['tiket_status'] === 'Closed' && !empty($allTaskStaffOnKaur)): ?>
            <div class="mt-3 p-4 bg-light rounded-4 border shadow-sm">
                <p class="m-0 fw-bold custom-small-font mb-3 text-dark">HASIL PENYELESAIAN TUGAS</p>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($allTaskStaffOnKaur as $task): ?>
                        <?php if (($task['task_status'] ?? '') === 'Selesai'): ?>
                            <div class="p-3 bg-white rounded-3 border-start border-4 border-success shadow-sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <iconify-icon icon="ph:check-circle-fill" class="text-success fs-5"></iconify-icon>
                                    <span class="fw-bold custom-small-font text-dark text-uppercase"><?= esc($task['received_by']) ?></span>
                                </div>
                                <p class="m-0 custom-text text-muted mb-3 fst-italic">"<?= esc($task['catatan_laporan_penyelesaian']) ?: 'Tugas telah diselesaikan.' ?>"</p>
                                
                                <?php if (!empty($task['taks_dokumen'])): ?>
                                    <div class="pt-2 border-top">
                                        <?php if ($task['is_downloadable']): ?>
                                            <a href="<?= base_url('tiket/file/admin/' . $task['taks_dokumen']) ?>" target="_blank" 
                                                class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 transition-all hov-shadow">
                                                <iconify-icon icon="ph:download-simple-bold" class="fs-5"></iconify-icon>
                                                <span class="custom-small-font fw-bold text-uppercase">Unduh Bukti</span>
                                            </a>
                                        <?php else: ?>
                                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 bg-light text-muted border border-light opacity-75" title="File ini hanya untuk keperluan internal" data-bs-toggle="tooltip">
                                                <iconify-icon icon="ph:lock-key-bold" class="fs-5"></iconify-icon>
                                                <span class="custom-small-font fw-bold text-uppercase">File tidak tersedia untuk diunduh</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
