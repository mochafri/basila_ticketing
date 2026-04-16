<div class="d-flex align-items-center gap-3">
    <iconify-icon icon="<?php if ($detail['tiket_status'] === 'Waiting'): ?>streamline-ultimate:task-list-approve<?php else: ?>ic:round-check<?php endif; ?>" class="text-white <?php if ($detail['tiket_status'] === 'Waiting'): ?> btn btn-secondary <?php else: ?> btn btn-success <?php endif; ?> "></iconify-icon>
    <p class="m-0 fw-bold custom-small-font">approval kepala urusan (bu fira)</p>
</div>

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
    <iconify-icon icon="<?= ($semuaSelesai || $sudahSelesaiKaur) ? 'ph:check-bold' : 'hugeicons:plus-sign' ?>" class="btn h-25 <?= ($semuaSelesai || $sudahSelesaiKaur) ? 'btn-success text-white' : (in_array($detail['tiket_status'], ['Open', 'In Progress']) ? 'btn-danger text-white' : 'btn-light') ?>"></iconify-icon>

    <div class="flex-grow-1">
        
        <p class="m-0 fw-bold custom-small-font">Penugasan: pak bagas</p>

        <?php if ($detail['tiket_status'] === 'Open' && !$sudahMulaiKaur): ?>
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
                        <div class="d-flex gap-3 mt-4 align-items-stretch">
                            <input type="text" class="instruksi form-control text-uppercase custom-text p-3 rounded-4 fw-medium" placeholder="Instruksi pengerjaan staff">
                            <button type="button" class="btn btn-assign-staff btn-danger fw-bold">+</button>
                        </div>
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
                                            <button class="btn btn-sm btn-outline-secondary border-0 p-1 btn-edit-instruction" 
                                                    data-id="<?= esc($task['id']) ?>" 
                                                    data-instruction="<?= esc($task['task_instruction'] ?: $task['judul_permohonan']) ?>"
                                                    title="Edit Instruksi">
                                                <iconify-icon icon="ph:pencil-simple-line-bold"></iconify-icon>
                                            </button>
                                        </div>
                                        <p style="font-size: .7rem;" class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded m-0 w-50"><?= esc($task['assign_task_to_staff']) ?></p>
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

                                <?php if ($task['task_status'] === 'Menunggu Approve'): ?>
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

                <?php if ($semuaSelesai && !$sudahSelesaiKaur): ?>
                    <button class="btn btn-success rounded-3 w-100 mt-2 text-uppercase fw-bold custom-small-font py-3 btn-selesaikan-penugasan">selesaikan bagian penugasan</button>
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
        <iconify-icon icon="ph:flow-arrow" class="btn text-white <?= $detail['tiket_status'] === 'Closed' ? 'btn-success' : ($semuaSelesai ? 'btn-danger' : 'btn-secondary') ?>"></iconify-icon>
        <div class="flex-grow-1 gap-2 d-flex flex-column">
            <p class="m-0 fw-bold custom-small-font">konfirmasi penyelesaian</p>
        </div>
    </div>
<?php endif; ?>