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
<div class="d-flex align-items-center gap-3">
    <iconify-icon icon="<?= $icon ?>" class="text-white btn <?= $btnClass ?>"></iconify-icon>
    <p class="m-0 fw-bold custom-small-font text-uppercase"><?= $statusText ?></p>
</div>
