<?php 
    $roleName  = $roleName ?? session('role_name');
    $loginUser = $loginUser ?? strtolower(session('login_username') ?? '');
    $userId    = $userId ?? session('user_identifier');
    $isAdmin   = $isAdmin ?? ($roleName === 'SUPERADMIN' || $loginUser === 'admin' || $userId === '000000');
    $isReadOnly = $isReadOnly ?? ($loginUser === 'admin' && $roleName !== 'SUPERADMIN');
?>
<?php if (!($hideContext ?? false)): ?>
<div class="d-flex align-items-center gap-3">
    <div class="timeline-icon-box <?= ($detail['tiket_status'] === 'Waiting') ? 'bg-secondary' : 'bg-success' ?> text-white">
        <span class="step-num"><?= $step ?? 3 ?></span>
        <iconify-icon icon="<?= ($detail['tiket_status'] === 'Waiting') ? 'streamline-ultimate:task-list-approve' : 'ic:round-check' ?>"></iconify-icon>
    </div>
    <div class="flex-grow-1">
        <p class="m-0 fw-bold custom-small-font text-uppercase">approval kepala urusan (bu fira)</p>
        <div class="d-flex flex-wrap gap-2 mt-1">
            <?php if (!empty($detail['completed_at'])): ?>
            <span class="custom-text text-muted small d-flex align-items-center gap-1">
                <iconify-icon icon="ph:check-circle-bold" class="text-success"></iconify-icon>
                Selesai: <?= format_datetime_indo($detail['completed_at']) ?>
            </span>
            <span class="custom-text text-muted small d-flex align-items-center gap-1">
                <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                Durasi: <?= format_duration($detail['created_at'], $detail['completed_at']) ?>
            </span>
            <?php else: ?>
            <span class="custom-text text-warning small d-flex align-items-center gap-1">
                <iconify-icon icon="ph:clock-countdown-bold"></iconify-icon>
                Sedang berjalan... (Mulai: <?= format_datetime_indo($detail['created_at']) ?>)
            </span>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
$nipMe = session('user_identifier');
$currentKaurAssign = array_filter($kaurByTiketOpen, fn($k) => $k['nip_kaur'] === $nipMe);
$currentKaurAssign = !empty($currentKaurAssign) ? reset($currentKaurAssign) : null;
$sudahMulaiKaur = ($currentKaurAssign['flag'] ?? '') === 'Start';
$sudahSelesaiKaur = ($currentKaurAssign['flag'] ?? '') === 'Finish';

// Cek apakah ada staff dan SEMUA task_status-nya 'Selesai'
$semuaSelesai = !empty($taskStaffOnKaur) && count(array_filter($taskStaffOnKaur, fn($task) => $task['task_status'] !== 'Selesai')) === 0;
?>

<div class="d-flex gap-3 w-100">
    <div class="timeline-icon-box <?= ($semuaSelesai || $sudahSelesaiKaur) ? 'bg-success text-white' : (in_array($detail['tiket_status'], ['Open', 'In Progress']) ? 'bg-danger text-white' : 'bg-light text-dark') ?>">
        <span class="step-num"><?= ($step ?? 3) + 1 ?></span>
        <iconify-icon icon="<?= ($semuaSelesai || $sudahSelesaiKaur) ? 'ph:check-bold' : 'hugeicons:plus-sign' ?>"></iconify-icon>
    </div>

    <div class="flex-grow-1">
        
        <p class="m-0 fw-bold custom-small-font text-uppercase">Penugasan: <?= esc($currentKaurAssign['kaur_name'] ?? 'Petugas') ?></p>
        <div class="d-flex flex-wrap gap-2 mt-1 mb-2">
            <?php if ($sudahSelesaiKaur): ?>
                <span class="custom-text text-muted small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:check-circle-bold" class="text-success"></iconify-icon>
                    Selesai: <?= format_datetime_indo($currentKaurAssign['completed_at']) ?>
                </span>
                <span class="custom-text text-muted small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                    Durasi: <?= format_duration($currentKaurAssign['started_at'], $currentKaurAssign['completed_at']) ?>
                </span>
            <?php elseif ($sudahMulaiKaur): ?>
                <span class="custom-text text-warning small d-flex align-items-center gap-1">
                    <iconify-icon icon="ph:clock-countdown-bold"></iconify-icon>
                    Sedang berjalan... (Mulai: <?= format_datetime_indo($currentKaurAssign['started_at']) ?>)
                </span>
            <?php endif; ?>
        </div>

        <?php if ($detail['tiket_status'] === 'Open' && !$sudahMulaiKaur && !($isReadOnly ?? false)): ?>
            <button class="btn btn-approve-kaur btn-danger rounded-3 w-100 mt-2 text-uppercase fw-bold custom-small-font py-3" style="letter-spacing: 3px;">terima & mulai penugasan</button>
        <?php endif; ?>

        <!-- akan aktif kalau button sudah di klik -->
        <div class="delegasi-wrapper w-100" style="<?= (in_array($detail['tiket_status'], ['In Progress']) || ($detail['tiket_status'] === 'Open' && $sudahMulaiKaur)) ? 'display:block;' : 'display:none;' ?>">
            <?php if (in_array($detail['tiket_status'], ['Open', 'In Progress'])): ?>
                <?php if (!$sudahSelesaiKaur && !$semuaSelesai): ?>
                    <div class="p-4 bg-light rounded-3 w-100 d-flex gap-3 flex-column shadow-md mt-2 border">
                        <p class="m-0 fw-medium custom-text">delegasi penugasan staff</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php if (!empty($staff)): 
                                // Ambil daftar NIP staf yang sudah ditugaskan
                                $assignedNips = array_column($taskStaffOnKaur, 'nip_staff');
                                $availableStaff = array_filter($staff, fn($stf) => !in_array($stf['nip_staff'], $assignedNips));
                            ?>
                                <?php if (!empty($availableStaff)): ?>
                                    <?php foreach ($availableStaff as $stf): ?>
                                        <label class="flex-fill p-3 bg-white d-flex justify-content-between align-items-center rounded-3 shadow-sm border border-light" style="cursor: pointer;">
                                            <span class="text-uppercase fw-bold custom-small-font"><?= esc($stf['nama_staff']); ?></span>
                                            <input type="checkbox" name="staff_id[]" value="<?= esc($stf['nip_staff']); ?>" data-name="<?= esc($stf['nama_staff']); ?>" class="form-check-input staff-checkbox mb-0" style="width: 1.25rem; height: 1.25rem;">
                                        </label>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted mb-0 w-100 custom-small-font fst-italic">Semua staf telah ditugaskan.</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted mb-0 w-100 custom-small-font">Data staff tidak tersedia.</p>
                            <?php endif; ?>
                        </div>
                        <?php if (!($isReadOnly ?? false)): ?>
                        <div class="d-flex gap-3 mt-4 align-items-stretch">
                            <input type="text" class="instruksi form-control text-uppercase custom-text p-3 rounded-4 fw-medium" placeholder="Instruksi pengerjaan staff">
                            <button type="button" class="btn btn-assign-staff btn-danger fw-bold">+</button>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($taskStaffOnKaur)): ?>
                    <?php foreach ($taskStaffOnKaur as $task): ?>
                        <?php if ($task['task_status'] === 'Menunggu Approve' || $task['task_status'] === 'Selesai'): ?>
                            <!-- ini akan muncul jika staff telah mengerjakan dan menyerahkan tugas -->
                            <div class="p-4 w-100 d-flex gap-3 align-items-center shadow-sm p-3 my-4 rounded flex-grow-1 justify-content-between border">
                                <div class="d-flex align-items-center gap-3">
                                    <iconify-icon icon="<?= $task['task_status'] === 'Selesai' ? 'ph:check-bold' : 'icon-park-outline:dot' ?>" class="<?= $task['task_status'] === 'Selesai' ? 'text-success' : 'text-warning' ?> fs-3"></iconify-icon>
                                    <div class="d-flex flex-column gap-2 flex-grow-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="custom-small-font fw-bold m-0"><?= esc($task['task_instruction'] ?: $task['judul_permohonan']) ?></p>
                                            <?php if (!($isReadOnly ?? false)): ?>
                                            <button class="btn btn-sm btn-outline-secondary border-0 p-1 btn-edit-instruction"
                                                data-id="<?= esc($task['id']) ?>"
                                                data-instruction="<?= esc($task['task_instruction'] ?: $task['judul_permohonan']) ?>"
                                                title="Edit Instruksi">
                                                <iconify-icon icon="ph:pencil-simple-line-bold"></iconify-icon>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                        <p style="font-size: .7rem;" class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded m-0 w-50"><?= esc($task['assign_task_to_staff']) ?></p>
                                        
                                        <?php if (($task['task_status'] ?? '') === 'Selesai'): ?>
                                        <div class="d-flex flex-wrap gap-2 my-2">
                                            <span class="custom-text text-muted small d-flex align-items-center gap-1" style="font-size: 0.6rem;">
                                                <iconify-icon icon="ph:clock-bold"></iconify-icon>
                                                Selesai: <?= format_datetime_indo($task['completed_at']) ?>
                                            </span>
                                            <span class="custom-text text-muted small d-flex align-items-center gap-1" style="font-size: 0.6rem;">
                                                <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                                                Durasi: <?= format_duration($task['started_at'], $task['completed_at']) ?>
                                            </span>
                                        </div>
                                        <?php endif; ?>

                                        <div class="bg-light p-3 rounded border" style="min-width: 300px;">
                                            <p class="custom-text fw-medium">laporan penyelesaian staff</p>
                                            <p class="custom-small-font fw-semibold">"<?= esc($task['catatan_laporan_penyelesaian']) ?: 'Staf telah menyelesaikan tugas.' ?>"</p>
                                            <?php if (!empty($task['taks_dokumen'])): ?>
                                                <hr>
                                                <a href="<?= base_url('tiket/file/admin/' . $task['taks_dokumen']) ?>" target="_blank" class="py-2 px-4 rounded-2 border custom-small-font bg-white text-decoration-none text-dark d-inline-block">
                                                    <iconify-icon icon="hugeicons:file-01" class="text-danger"></iconify-icon>
                                                    <?= esc($task['taks_dokumen']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($task['task_status'] === 'Menunggu Approve' && !($isReadOnly ?? false)): ?>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="btn btn-success flex-fill px-4 py-2 fw-semibold btn-verifikasi-task" data-id="<?= esc($task['id']) ?>">Verifikasi</button>
                                        <button class="btn btn-warning flex-fill px-4 py-2 fw-semibold text-white btn-revisi-task" data-id="<?= esc($task['id']) ?>">Revisi</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <!-- akan muncul setelah tugas diberikan kepada staff -->
                            <div class="p-4 w-100 d-flex gap-3 align-items-center shadow-sm p-3 my-4 rounded border">
                                <iconify-icon icon="icon-park-outline:dot" class="text-warning fs-3"></iconify-icon>
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="custom-small-font fw-bold"><?= esc($task['task_instruction'] ?: $task['judul_permohonan']) ?></span>
                                        <button class="btn btn-sm btn-outline-secondary border-0 p-1 btn-edit-instruction"
                                            data-id="<?= esc($task['id']) ?>"
                                            data-instruction="<?= esc($task['task_instruction'] ?: $task['judul_permohonan']) ?>"
                                            title="Edit Instruksi">
                                            <iconify-icon icon="ph:pencil-simple-line-bold"></iconify-icon>
                                        </button>
                                    </div>
                                    <span style="font-size: .7rem;" class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded"><?= esc($task['assign_task_to_staff']) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ($semuaSelesai && !$sudahSelesaiKaur && !($isReadOnly ?? false)): ?>
                    <button class="btn btn-success rounded-3 w-100 mt-2 text-uppercase fw-bold custom-small-font py-3 btn-selesaikan-penugasan">selesaikan bagian penugasan</button>
                <?php elseif ($semuaSelesai && !$sudahSelesaiKaur && ($isReadOnly ?? false)): ?>
                    <div class="alert alert-info mt-2 rounded-3 text-center border-0 py-2 mb-0 small fw-bold">
                        MENUNGGU VERIFIKASI SELESAI DARI KAUR...
                    </div>
                <?php elseif ($sudahSelesaiKaur): ?>
                    <div class="alert alert-success mt-2 rounded-3 text-center border-0 py-3 mb-0" style="background-color: #d1e7dd; color: #0a3622;">
                        <iconify-icon icon="ph:check-circle-fill" class="me-2"></iconify-icon>
                        <span class="fw-bold text-uppercase custom-small-font" style="letter-spacing: 1px;">Tugas Selesai Terverifikasi</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if (in_array($detail['tiket_status'], ['Waiting', 'Open', 'In Progress', 'Closed'])): ?>
    <div class="d-flex align-items-center gap-3">
    <div class="timeline-icon-box <?= $detail['tiket_status'] === 'Closed' ? 'bg-success' : ($semuaSelesai ? 'bg-danger' : 'bg-secondary') ?> text-white">
        <span class="step-num"><?= ($step ?? 3) + 2 ?></span>
        <iconify-icon icon="ph:flow-arrow"></iconify-icon>
    </div>
        <div class="flex-grow-1 gap-2 d-flex flex-column">
            <p class="m-0 fw-bold custom-small-font">konfirmasi penyelesaian</p>
        </div>
    </div>
<?php endif; ?>