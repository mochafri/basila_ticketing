<div class="d-flex align-items-center gap-3">
    <div class="timeline-icon-box <?= ($detail['tiket_status'] === 'Waiting') ? 'bg-secondary' : 'bg-success' ?> text-white">
        <span class="step-num">2</span>
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

<?php
$nipMe = session('user_identifier');
$currentKaurAssign = array_filter($kaurByTiketOpen, fn($k) => $k['nip_kaur'] === $nipMe);
$currentKaurAssign = !empty($currentKaurAssign) ? reset($currentKaurAssign) : null;
$sudahMulaiKaur = in_array($currentKaurAssign['flag'] ?? '', ['Start', 'Progress']);
$sudahSelesaiKaur = ($currentKaurAssign['flag'] ?? '') === 'Finish';

// Cek apakah ada staff dan SEMUA task_status-nya 'Selesai'
$semuaSelesai = !empty($taskStaffOnKaur) && count(array_filter($taskStaffOnKaur, fn($task) => $task['task_status'] !== 'Selesai')) === 0;

// Cari tugas yang dikerjakan sendiri oleh kaur
$mySelfTask = null;
if (!empty($taskStaffOnKaur)) {
    foreach ($taskStaffOnKaur as $t) {
        if ($t['is_kaur_accepted'] == 1 && $t['nip_receive_task'] === $nipMe) {
            $mySelfTask = $t;
            break;
        }
    }
}
?>

<div class="d-flex gap-3 w-100">
    <div class="timeline-icon-box <?= ($semuaSelesai || $sudahSelesaiKaur) ? 'bg-success text-white' : (in_array($detail['tiket_status'], ['Open', 'In Progress']) ? 'bg-danger text-white' : 'bg-light text-dark') ?>">
        <span class="step-num">3</span>
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
                <!-- Catatan Log Aktifitas dihapus sesuai request -->
            <?php endif; ?>
        </div>
        
        <?php if (($currentKaurAssign['flag'] ?? '') === 'Revisi' && !empty($currentKaurAssign['catatan_revisi'] && !in_array('Selesai', array_column($taskStaffOnKaur, 'task_status')))): ?>
            <div class="mt-2 p-3 rounded-3 border-start border-4 border-danger bg-danger bg-opacity-10 shadow-sm mb-3">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                    <iconify-icon icon="ph:warning-circle-bold" class="fs-5"></iconify-icon>
                    <span class="fw-bold text-uppercase" style="font-size: .7rem; letter-spacing: 1px;">Catatan Revisi dari Kepala Bagian</span>
                </div>
                <p class="m-0 custom-text fw-bold text-dark italic">
                    "<?= esc($currentKaurAssign['catatan_revisi']) ?>"
                </p>
                <small class="text-muted mt-2 d-block" style="font-size: 0.6rem;">* Mohon perbaiki pekerjaan dan selesaikan kembali untuk verifikasi ulang.</small>
            </div>
        <?php endif; ?>

        <?php if ($detail['tiket_status'] === 'Open' && !$sudahMulaiKaur): ?>
            <div class="d-flex gap-3">
                <button class="btn btn-acc-task btn-primary rounded-3 w-100 mt-2 text-uppercase fw-bold custom-small-font py-3" style="letter-spacing: 3px;">Terima Tugas</button>
                <button class="btn btn-approve-kaur btn-danger rounded-3 w-100 mt-2 text-uppercase fw-bold custom-small-font py-3" style="letter-spacing: 3px;">Delegasi ke staff</button>
            </div>
        <?php endif; ?>

        <!-- akan aktif kalau button sudah di klik -->
        <div class="delegasi-wrapper w-100" style="<?= (in_array($detail['tiket_status'], ['In Progress']) || ($detail['tiket_status'] === 'Open' && $sudahMulaiKaur)) ? 'display:block;' : 'display:none;' ?>">
            <?php if (in_array($detail['tiket_status'], ['Open', 'In Progress'])): ?>
                <?php if ($mySelfTask): ?>
                    <!-- Tampilan Mandiri (Kaur mengerjakan sendiri) -->
                    <?php
                    $statusMapping = [
                        'Selesai' => ['color' => 'success', 'icon' => 'ph:check-circle-fill'],
                        'Menunggu Approve' => ['color' => 'warning', 'icon' => 'ph:clock-bold'],
                        'Revisi' => ['color' => 'danger', 'icon' => 'ph:warning-circle-fill'],
                        'Sedang Pengerjaan' => ['color' => 'primary', 'icon' => 'ph:play-circle-fill'],
                    ];

                    $currentStatus = $mySelfTask['task_status'] ?? 'Sedang Pengerjaan';
                    $config = $statusMapping[$currentStatus] ?? ['color' => 'secondary', 'icon' => 'ph:dot-bold'];
                    ?>
                    <div class="rounded-3 w-100 d-flex flex-column gap-3 shadow-md border p-2 mt-2 bg-white">
                        <div class="d-flex gap-3 align-items-center p-3 rounded">
                            <iconify-icon icon="icon-park-outline:dot" class="text-warning fs-3"></iconify-icon>
                            <div class="d-flex flex-column gap-2">
                                <span class="custom-small-font fw-bold">Instruksi: <?= esc($mySelfTask['task_instruction'] ?: 'Mengerjakan tugas tiket secara mandiri.') ?></span>
                                <div class="d-flex gap-2">
                                    <span style="font-size: .65rem;" class="text-danger bg-danger bg-opacity-10 px-3 py-1 fw-bold text-center rounded-pill text-uppercase">
                                        <iconify-icon icon="ph:user-bold" class="me-1"></iconify-icon>
                                        <?= esc($mySelfTask['received_by']) ?>
                                    </span>
                                    <span style="font-size: .65rem;" class="text-<?= $config['color'] ?> bg-<?= $config['color'] ?> bg-opacity-10 px-3 py-1 fw-bold text-center rounded-pill text-uppercase">
                                        <iconify-icon icon="<?= $config['icon'] ?>" class="me-1"></iconify-icon>
                                        <?= esc($currentStatus) ?>
                                    </span>
                                </div>
                                
                                <?php if ($mySelfTask['task_status'] === 'Revisi' && !empty($mySelfTask['catatan_revisi'])): ?>
                                    <div class="mt-2 p-2 rounded border-start border-4 border-danger bg-danger bg-opacity-10 shadow-sm">
                                        <div class="d-flex align-items-center gap-1 mb-1 text-danger">
                                            <iconify-icon icon="ph:warning-circle-bold" style="font-size: .8rem;"></iconify-icon>
                                            <span class="fw-bold text-uppercase" style="font-size: .6rem; letter-spacing: 1px;">Catatan Revisi</span>
                                        </div>
                                        <p class="m-0 custom-small-font fw-bold text-dark">
                                            "<?= esc($mySelfTask['catatan_revisi']) ?>"
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <?php 
                                $workLogs = array_filter($riwayat, fn($r) => $r['activity_title'] === 'Catatan Pekerjaan');
                                ?>
                                <?php if (!empty($workLogs)): ?>
                                    <div class="mt-3">
                                        <div class="table-responsive rounded-3 border bg-white">
                                            <table class="table table-sm table-hover m-0" style="font-size: 0.7rem;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="ps-3 py-2 text-uppercase" style="width: 100px;">Waktu</th>
                                                        <th class="py-2 text-uppercase" style="width: 120px;">Oleh</th>
                                                        <th class="py-2 text-uppercase">Catatan Pekerjaan</th>
                                                        <th class="pe-3 py-2 text-uppercase text-center" style="width: 80px;">Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($workLogs as $log): ?>
                                                        <tr>
                                                            <td class="ps-3 py-2 text-muted"><?= time_ago($log['created_at']) ?></td>
                                                            <td class="py-2 fw-bold text-danger"><?= esc($log['created_by']) ?></td>
                                                            <td class="py-2"><?= esc($log['message']) ?></td>
                                                            <td class="pe-3 py-2 text-center">
                                                                <?php if (!empty($log['attachment'])): ?>
                                                                    <a href="<?= base_url('tiket/file/admin/' . $log['attachment']) ?>" target="_blank" class="text-danger" title="<?= esc($log['original_attachment_name']) ?>">
                                                                        <iconify-icon icon="ph:paperclip-bold" class="fs-5"></iconify-icon>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="text-muted">-</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($mySelfTask['catatan_laporan_penyelesaian'])): ?>
                                    <div class="bg-light p-2 rounded-2 border-start border-4 border-<?= $config['color'] ?> mt-2 shadow-sm">
                                        <div class="d-flex align-items-center gap-1 mb-1 text-muted">
                                            <iconify-icon icon="ph:notebook-bold" style="font-size: .8rem;"></iconify-icon>
                                            <span class="fw-bold text-uppercase" style="font-size: .6rem; letter-spacing: 1px;">Laporan Penyelesaian</span>
                                        </div>
                                        <p class="m-0 custom-small-font fst-italic text-dark">
                                            "<?= esc($mySelfTask['catatan_laporan_penyelesaian']) ?>"
                                        </p>
                                        <?php if (!empty($mySelfTask['taks_dokumen'])): ?>
                                            <hr class="my-2">
                                            <a href="<?= base_url('tiket/file/admin/' . $mySelfTask['taks_dokumen']) ?>" target="_blank" class="py-1 px-3 rounded-2 border custom-small-font bg-white text-decoration-none text-dark d-inline-block">
                                                <iconify-icon icon="hugeicons:file-01" class="text-danger"></iconify-icon>
                                                <?= esc($mySelfTask['original_task_name'] ?: $mySelfTask['taks_dokumen']) ?>
                                            </a>
                                        <?php endif; ?>
                                        <div class="d-flex flex-wrap gap-2 mt-2" style="font-size: 0.6rem;">
                                            <span class="text-muted"><iconify-icon icon="ph:check-circle-fill" class="text-success"></iconify-icon> Selesai: <?= format_datetime_indo($mySelfTask['completed_at']) ?></span>
                                            <span class="text-muted"><iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon> Durasi: <?= format_duration($mySelfTask['started_at'], $mySelfTask['completed_at']) ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($mySelfTask['task_status'] !== 'Selesai'): ?>
                            <div id="containerBtnSelesaikan" class="d-flex align-items-center justify-content-end flex-wrap gap-2 p-2">
                                <button id="btnLogPekerjaan" type="button" class="btn btn-outline-danger text-uppercase custom-small-font fw-medium py-2 px-4">
                                    <iconify-icon icon="ph:note-pencil-bold" class="me-1"></iconify-icon>
                                    Log Catatan Pekerjaan
                                </button>
                                <button id="btnSelesaikanTugas" type="button" class="btn btn-danger text-uppercase custom-small-font fw-medium py-2 px-4 me-3">Selesaikan Tugas</button>
                            </div>

                            <!-- Form Log Catatan Pekerjaan -->
                            <div id="wrapperLogPekerjaan" class="smooth-collapse">
                                <div class="smooth-collapse-inner">
                                    <form id="formLogPekerjaan" class="bg-light flex-grow-1 p-3 rounded border border-2 mt-3 mx-1 mb-1" enctype="multipart/form-data">
                                        <div class="row align-items-center mb-3">
                                            <div class="col">
                                                <p class="custom-small-font fw-bold m-0 text-uppercase" style="letter-spacing: 0.5px;">Tambah Catatan Pekerjaan</p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="text-danger fw-bold m-0" style="font-size: .7rem;">* wajib diisi</p>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <textarea name="deskripsi" class="form-control custom-small-font" rows="3" placeholder="Jelaskan pekerjaan yang telah dilakukan..." required></textarea>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center gap-3">
                                            <div class="flex-grow-1">
                                                <input type="file" name="bukti" id="uploadBuktiLog" class="d-none">
                                                <label for="uploadBuktiLog" class="btn btn-light border border-2 d-flex align-items-center justify-content-center gap-2 custom-small-font fw-bold text-secondary py-2" style="cursor:pointer; width: 100%;">
                                                    <iconify-icon icon="ph:upload-simple-bold"></iconify-icon>
                                                    UNGGAH BUKTI (OPSIONAL)
                                                </label>
                                                <p id="fileNameLog" class="upload-filename custom-text text-center m-0 mt-1"></p>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" id="btnBatalLog" class="btn btn-light border custom-small-font fw-bold px-4">BATAL</button>
                                                <button type="submit" id="btnSimpanLog" class="btn btn-danger custom-small-font fw-bold px-4">SIMPAN LOG</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="wrapperPenyelesaian" class="smooth-collapse">
                                <div class="smooth-collapse-inner">
                                    <div id="formPenyelesaianTugas" class="bg-light flex-grow-1 p-3 rounded border border-2 mt-3 mx-1 mb-1">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p class="custom-small-font fw-bold m-0">Form penyelesaian tugas</p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="text-danger fw-bold m-0" style="font-size: .7rem;">* wajib diisi</p>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <textarea class="form-control" rows="4" placeholder="Tuliskan detail pekerjaan yang telah Anda selesaikan..."></textarea>
                                        </div>

                                        <div class="mt-4 d-flex flex-wrap gap-2">
                                            <div class="">
                                                <input type="file" id="uploadBukti" class="d-none">
                                                <label for="uploadBukti" class="border border-2 rounded bg-light d-flex align-items-center justify-content-center text-center fw-bold text-secondary p-1" style="width:160px;cursor:pointer;">
                                                    <span class="custom-text">UNGGAH BUKTI (OPSIONAL)</span>
                                                </label>
                                                <p id="fileName" class="upload-filename custom-text text-center m-0"></p>
                                            </div>

                                            <div class="w-100 mt-2 px-1">
                                                <div class="form-check form-switch d-flex align-items-center gap-3 p-0">
                                                    <input class="form-check-input ms-0" type="checkbox" role="switch" id="isDownloadable" checked style="width: 2.5rem; height: 1.25rem; cursor: pointer;">
                                                    <div class="d-flex flex-column">
                                                        <label class="form-check-label fw-bold custom-small-font mb-0" for="isDownloadable" style="cursor: pointer;">Izinkan pemohon mengunduh file ini</label>
                                                        <small class="text-muted custom-text" style="font-size: 0.65rem;">Nonaktifkan jika file hanya untuk internal</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="flex-fill btn btn-success fw-bold custom-small-font" type="button" id="btnKirimLaporan">Kirim laporan</button>
                                            <button type="button" id="btnBatalPenyelesaian" class="flex-fill btn btn-light border fw-bold custom-small-font">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif (!$sudahSelesaiKaur && !$semuaSelesai): ?>
                    <!-- Tampilan Delegasi (Existing) -->
                    <div class="p-4 bg-light rounded-3 w-100 d-flex gap-3 flex-column shadow-md mt-2 border">
                        <p class="m-0 fw-medium custom-text">delegasi penugasan staff</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php if (!empty($staff)):
                                // Ambil daftar NIP staf yang sudah ditugaskan
                                $assignedNips = array_column($taskStaffOnKaur, 'nip_receive_task');
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
                        <?php if ((int)$task['is_kaur_accepted'] === 1) continue; ?>
                        <?php if ($task['task_status'] === 'Menunggu Approve' || $task['task_status'] === 'Selesai'): ?>
                            <!-- ini akan muncul jika staff telah mengerjakan dan menyerahkan tugas -->
                            <div class="p-3 my-4 rounded border shadow-sm w-100 d-flex flex-column gap-3">
                                <div class="d-flex align-items-center gap-3 px-2 pt-2">
                                    <iconify-icon icon="<?= $task['task_status'] === 'Selesai' ? 'ph:check-bold' : 'icon-park-outline:dot' ?>" class="<?= $task['task_status'] === 'Selesai' ? 'text-success' : 'text-warning' ?> fs-3"></iconify-icon>
                                    <div class="d-flex flex-column gap-2 flex-grow-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="custom-small-font fw-bold m-0"><?= esc($task['task_instruction']) ?></p>
                                            <button class="btn btn-sm btn-outline-secondary border-0 p-1 btn-edit-instruction"
                                                data-id="<?= esc($task['id']) ?>"
                                                data-instruction="<?= esc($task['task_instruction']) ?>"
                                                title="Edit Instruksi">
                                                <iconify-icon icon="ph:pencil-simple-line-bold"></iconify-icon>
                                            </button>
                                        </div>
                                        <p style="font-size: .7rem;" class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded m-0 w-50"><?= esc($task['received_by']) ?></p>

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
                                    </div>
                                </div>

                                <?php 
                                $workLogs = array_filter($riwayat, fn($r) => $r['activity_title'] === 'Catatan Pekerjaan');
                                ?>
                                <?php if (!empty($workLogs)): ?>
                                    <div class="px-2">
                                        <div class="table-responsive rounded-3 border bg-white">
                                            <table class="table table-sm table-hover m-0" style="font-size: 0.7rem;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="ps-3 py-2 text-uppercase" style="width: 100px;">Waktu</th>
                                                        <th class="py-2 text-uppercase" style="width: 120px;">Oleh</th>
                                                        <th class="py-2 text-uppercase">Catatan Pekerjaan</th>
                                                        <th class="pe-3 py-2 text-uppercase text-center" style="width: 80px;">Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($workLogs as $log): ?>
                                                        <tr>
                                                            <td class="ps-3 py-2 text-muted"><?= time_ago($log['created_at']) ?></td>
                                                            <td class="py-2 fw-bold text-danger"><?= esc($log['created_by']) ?></td>
                                                            <td class="py-2"><?= esc($log['message']) ?></td>
                                                            <td class="pe-3 py-2 text-center">
                                                                <?php if (!empty($log['attachment'])): ?>
                                                                    <a href="<?= base_url('tiket/file/admin/' . $log['attachment']) ?>" target="_blank" class="text-danger" title="<?= esc($log['original_attachment_name']) ?>">
                                                                        <iconify-icon icon="ph:paperclip-bold" class="fs-5"></iconify-icon>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="text-muted">-</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="px-2">
                                    <div class="bg-light p-3 rounded border">
                                        <p class="custom-text fw-medium">laporan penyelesaian staff</p>
                                        <p class="custom-small-font fw-semibold">"<?= esc($task['catatan_laporan_penyelesaian']) ?: 'Staf telah menyelesaikan tugas.' ?>"</p>
                                        <?php if (!empty($task['taks_dokumen'])): ?>
                                            <hr>
                                            <a href="<?= base_url('tiket/file/admin/' . $task['taks_dokumen']) ?>" target="_blank" class="py-2 px-4 rounded-2 border custom-small-font bg-white text-decoration-none text-dark d-inline-block">
                                                <iconify-icon icon="hugeicons:file-01" class="text-danger"></iconify-icon>
                                                <?= esc($task['original_task_name'] ?: $task['taks_dokumen']) ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (($task['task_status'] ?? '') === 'Revisi' && !empty($task['catatan_revisi'])): ?>
                                            <div class="mt-2 p-3 rounded border border-warning bg-warning bg-opacity-10">
                                                <p class="custom-text fw-bold text-warning mb-1">CATATAN REVISI:</p>
                                                <p class="custom-small-font fw-medium mb-0 fst-italic">"<?= esc($task['catatan_revisi']) ?>"</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if ($task['task_status'] === 'Menunggu Approve'): ?>
                                    <div class="d-flex flex-wrap gap-2 px-2 pb-2">
                                        <button class="btn btn-success flex-fill px-4 py-2 fw-semibold btn-verifikasi-task" data-id="<?= esc($task['id']) ?>">Verifikasi</button>
                                        <button class="btn btn-warning flex-fill px-4 py-2 fw-semibold text-white btn-revisi-task" data-id="<?= esc($task['id']) ?>">Revisi</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <!-- akan muncul setelah tugas diberikan kepada staff -->
                            <div class="p-3 my-4 rounded border shadow-sm w-100 d-flex flex-column gap-3">
                                <!-- Info Bar -->
                                <div class="d-flex align-items-center gap-3 px-2 pt-2">
                                    <iconify-icon icon="icon-park-outline:dot" class="text-warning fs-3"></iconify-icon>
                                    <div class="d-flex flex-column gap-2 flex-grow-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="custom-small-font fw-bold"><?= esc($task['task_instruction'] ?: 'TIDAK ADA INSTRUKSI') ?></span>
                                            <button class="btn btn-sm btn-outline-secondary border-0 p-1 btn-edit-instruction"
                                                data-id="<?= esc($task['id']) ?>"
                                                data-instruction="<?= esc($task['task_instruction']) ?>"
                                                title="Edit Instruksi">
                                                <iconify-icon icon="ph:pencil-simple-line-bold"></iconify-icon>
                                            </button>
                                        </div>
                                        <span style="font-size: .7rem;" class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded m-0 w-25"><?= esc($task['received_by']) ?></span>
                                    </div>
                                </div>
                                
                                <!-- Log Catatan Pekerjaan -->
                                <?php 
                                $workLogs = array_filter($riwayat, fn($r) => $r['activity_title'] === 'Catatan Pekerjaan');
                                ?>
                                <?php if (!empty($workLogs)): ?>
                                    <div class="px-2">
                                        <div class="table-responsive rounded-3 border bg-white">
                                            <table class="table table-sm table-hover m-0" style="font-size: 0.7rem;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="ps-3 py-2 text-uppercase" style="width: 100px;">Waktu</th>
                                                        <th class="py-2 text-uppercase" style="width: 120px;">Oleh</th>
                                                        <th class="py-2 text-uppercase">Catatan Pekerjaan</th>
                                                        <th class="pe-3 py-2 text-uppercase text-center" style="width: 80px;">Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($workLogs as $log): ?>
                                                        <tr>
                                                            <td class="ps-3 py-2 text-muted"><?= time_ago($log['created_at']) ?></td>
                                                            <td class="py-2 fw-bold text-danger"><?= esc($log['created_by']) ?></td>
                                                            <td class="py-2"><?= esc($log['message']) ?></td>
                                                            <td class="pe-3 py-2 text-center">
                                                                <?php if (!empty($log['attachment'])): ?>
                                                                    <a href="<?= base_url('tiket/file/admin/' . $log['attachment']) ?>" target="_blank" class="text-danger" title="<?= esc($log['original_attachment_name']) ?>">
                                                                        <iconify-icon icon="ph:paperclip-bold" class="fs-5"></iconify-icon>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="text-muted">-</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>
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
        <div class="timeline-icon-box <?= $detail['tiket_status'] === 'Closed' ? 'bg-success' : ($semuaSelesai ? 'bg-danger' : 'bg-secondary') ?> text-white">
            <span class="step-num">4</span>
            <iconify-icon icon="ph:flow-arrow"></iconify-icon>
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
        </div>
    </div>
<?php endif; ?>

<script>
    // Log Catatan Pekerjaan Script
    const uploadLog = document.getElementById("uploadBuktiLog");
    const fileNameLog = document.getElementById("fileNameLog");
    if (uploadLog && fileNameLog) {
        uploadLog.addEventListener("change", function() {
            if (this.files.length > 0) {
                fileNameLog.textContent = this.files[0].name;
            }
        });
    }

    const btnLogPekerjaan = document.getElementById("btnLogPekerjaan");
    const wrapperLogPekerjaan = document.getElementById("wrapperLogPekerjaan");
    const btnBatalLog = document.getElementById("btnBatalLog");
    
    // Note: btnSelesaikanTugas and wrapperPenyelesaian are handled in approveKaur.js
    const btnSelesaikanInline = document.getElementById("btnSelesaikanTugas");
    const wrapperPenyelesaianInline = document.getElementById("wrapperPenyelesaian");

    if (btnLogPekerjaan && wrapperLogPekerjaan) {
        btnLogPekerjaan.addEventListener("click", function() {
            wrapperLogPekerjaan.classList.toggle("show");
            
            // Close the completion form if it's open (it's handled by IDs, so we can still access it)
            if (wrapperPenyelesaianInline) {
                wrapperPenyelesaianInline.classList.remove("show");
                if (btnSelesaikanInline) {
                    btnSelesaikanInline.textContent = "Selesaikan Tugas";
                    btnSelesaikanInline.classList.remove("btn-secondary");
                    btnSelesaikanInline.classList.add("btn-danger");
                }
            }
        });
    }

    if (btnBatalLog && wrapperLogPekerjaan) {
        btnBatalLog.addEventListener("click", function() {
            wrapperLogPekerjaan.classList.remove("show");
            const form = document.getElementById('formLogPekerjaan');
            if (form) form.reset();
            if (fileNameLog) fileNameLog.textContent = '';
        });
    }

    const formLog = document.getElementById('formLogPekerjaan');
    if (formLog) {
        formLog.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btnSimpan = document.getElementById('btnSimpanLog');
            btnSimpan.disabled = true;
            btnSimpan.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            fetch('<?= base_url('tiket/log-pekerjaan/' . $detail['id']) ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: typeof data.message === 'object' ? Object.values(data.message).join('\n') : data.message
                    });
                    btnSimpan.disabled = false;
                    btnSimpan.innerHTML = 'SIMPAN LOG';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    text: 'Terjadi kesalahan sistem.'
                });
                btnSimpan.disabled = false;
                btnSimpan.innerHTML = 'SIMPAN LOG';
            });
        });
    }
</script>