<div class="d-flex gap-3 w-100">
    <div class="timeline-icon-box <?= ($taskStaff['task_status'] ?? '') === 'Selesai' ? 'bg-success' : 'bg-danger' ?> text-white">
        <span class="step-num">2</span>
        <iconify-icon icon="<?= ($taskStaff['task_status'] ?? '') === 'Selesai' ? 'ph:check-bold' : 'hugeicons:task-01' ?>"></iconify-icon>
    </div>
    <div class="flex-grow-1">
        <?php if (!empty($taskStaff)): ?>
            <?php
            $statusMapping = [
                'Selesai' => ['color' => 'success', 'icon' => 'ph:check-circle-fill'],
                'Menunggu Approve' => ['color' => 'warning', 'icon' => 'ph:clock-bold'],
                'Revisi' => ['color' => 'danger', 'icon' => 'ph:warning-circle-fill'],
                'Sedang Pengerjaan' => ['color' => 'primary', 'icon' => 'ph:play-circle-fill'],
            ];

            $currentStatus = $taskStaff['task_status'] ?? 'Sedang Pengerjaan';
            $config = $statusMapping[$currentStatus] ?? ['color' => 'secondary', 'icon' => 'ph:dot-bold'];
            ?>
            <div class="flex-grow-1">
                <p class="m-0 fw-bold custom-small-font text-uppercase">penugasan : <?= esc($taskStaff['assign_task_to_staff']) ?></p>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    <?php if ($taskStaff['task_status'] === 'Selesai'): ?>
                        <span class="custom-text text-muted small d-flex align-items-center gap-1">
                            <iconify-icon icon="ph:check-circle-bold" class="text-success"></iconify-icon>
                            Selesai: <?= format_datetime_indo($taskStaff['completed_at']) ?>
                        </span>
                        <span class="custom-text text-muted small d-flex align-items-center gap-1" title="Durasi dihitung dari waktu mulai hingga selesai" data-bs-toggle="tooltip">
                            <iconify-icon icon="ph:timer-bold" class="text-primary"></iconify-icon>
                            Durasi: <?= format_duration($taskStaff['started_at'], $taskStaff['completed_at']) ?>
                        </span>
                    <?php else: ?>
                        <span class="custom-text text-warning small d-flex align-items-center gap-1">
                            <iconify-icon icon="ph:clock-countdown-bold"></iconify-icon>
                            Sedang berjalan... (Mulai: <?= format_datetime_indo($taskStaff['started_at']) ?>)
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="rounded-3 w-100 d-flex flex-column gap-3 shadow-md border p-2">
                <div class="d-flex gap-3 align-items-center p-3 rounded">
                    <iconify-icon icon="icon-park-outline:dot" class="text-warning fs-3"></iconify-icon>
                    <div class="d-flex flex-column gap-2">
                        <span class="custom-small-font fw-bold">Instruksi: <?= esc($taskStaff['task_instruction']) ?></span>
                        <div class="d-flex gap-2">
                            <span style="font-size: .65rem;" class="text-danger bg-danger bg-opacity-10 px-3 py-1 fw-bold text-center rounded-pill text-uppercase">
                                <iconify-icon icon="ph:user-bold" class="me-1"></iconify-icon>
                                <?= esc($taskStaff['assign_task_to_staff']) ?>
                            </span>
                            <span style="font-size: .65rem;" class="text-<?= $config['color'] ?> bg-<?= $config['color'] ?> bg-opacity-10 px-3 py-1 fw-bold text-center rounded-pill text-uppercase">
                                <iconify-icon icon="<?= $config['icon'] ?>" class="me-1"></iconify-icon>
                                <?= esc($currentStatus) ?>
                            </span>
                        </div>
                        <?php if (!empty($taskStaff['catatan_laporan_penyelesaian'])): ?>
                            <div class="bg-light p-2 rounded-2 border-start border-4 border-<?= $config['color'] ?> mt-2 shadow-sm">
                                <div class="d-flex align-items-center gap-1 mb-1 text-muted">
                                    <iconify-icon icon="ph:notebook-bold" style="font-size: .8rem;"></iconify-icon>
                                    <span class="fw-bold text-uppercase" style="font-size: .6rem; letter-spacing: 1px;">Laporan Penyelesaian Staff</span>
                                </div>
                                <p class="m-0 custom-small-font fst-italic text-dark">
                                    "<?= esc($taskStaff['catatan_laporan_penyelesaian']) ?>"
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php 
                $workLogs = array_filter($riwayat, fn($r) => $r['activity_title'] === 'Catatan Pekerjaan');
                ?>
                <?php if (!empty($workLogs)): ?>
                    <div class="px-3 pb-2">
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

                <!-- button selesaikan tugas & log catatan -->
                <div id="containerBtnSelesaikan" class="d-flex align-items-center justify-content-end flex-wrap gap-2 p-2">
                    <button id="btnLogPekerjaan" type="button" class="btn btn-outline-danger text-uppercase custom-small-font fw-medium py-2 px-4">
                        <iconify-icon icon="ph:note-pencil-bold" class="me-1"></iconify-icon>
                        Log Catatan Pekerjaan
                    </button>
                    <?php if($taskStaff['task_status'] !== 'Selesai' && $taskStaff['task_status'] !== 'Menunggu Approve'): ?>
                    <button id="btnSelesaikanTugas" type="button" class="btn btn-danger text-uppercase custom-small-font fw-medium py-2 px-4">Selesaikan Tugas</button>
                    <?php endif; ?>
                </div>

                <!-- Form Log Catatan Pekerjaan -->
                <div id="wrapperLogPekerjaan" class="smooth-collapse">
                    <div class="smooth-collapse-inner">
                        <form id="formLogPekerjaan" class="bg-light flex-grow-1 p-3 rounded border border-2 mt-3 mx-1 mb-1" enctype="multipart/form-data">
                            <div class="row align-items-center mb-3">
                                <div class="col">
                                    <p class="custom-small-font fw-bold m-0 text-uppercase" style="letter-spacing: 0.5px;">
                                        Tambah Catatan Pekerjaan
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <p class="text-danger fw-bold m-0" style="font-size: .7rem;">
                                        * wajib diisi
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <textarea name="deskripsi" class="form-control custom-small-font" rows="3"
                                    placeholder="Jelaskan pekerjaan yang telah dilakukan..." required></textarea>
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <div class="flex-grow-1">
                                    <input type="file" name="bukti" id="uploadBuktiLog" class="d-none">
                                    <label for="uploadBuktiLog"
                                        class="btn btn-light border border-2 d-flex align-items-center justify-content-center gap-2 custom-small-font fw-bold text-secondary py-2"
                                        style="cursor:pointer; width: 100%;">
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

                <!-- ini akan muncul setelah button "selesaikan tugas diklik" -->
                <div id="wrapperPenyelesaian" class="smooth-collapse">
                    <div class="smooth-collapse-inner">
                        <div id="formPenyelesaianTugas" class="bg-light flex-grow-1 p-3 rounded border border-2 mt-3 mx-1 mb-1">

                            <div class="row align-items-center">
                                <div class="col">
                                    <p class="custom-small-font fw-bold m-0">
                                        Form penyelesaian tugas
                                    </p>
                                </div>

                                <div class="col-auto">
                                    <p class="text-danger fw-bold m-0" style="font-size: .7rem;">
                                        * wajib diisi
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <textarea class="form-control" rows="4"
                                    placeholder="Tuliskan keterangan penyelesaian tugas anda secara mendetail disini"></textarea>
                            </div>
                            <div class="mt-4 d-flex flex-wrap gap-2">
                                <div class="">
                                    <input type="file" id="uploadBukti" class="d-none">

                                    <label for="uploadBukti"
                                        class="border border-2 rounded bg-light d-flex align-items-center justify-content-center text-center fw-bold text-secondary p-1"
                                        style="width:160px;cursor:pointer;">
                                        <span class="custom-text">
                                            UNGGAH
                                            BUKTI
                                            (OPSIONAL)
                                        </span>
                                    </label>
                                    <p id="fileName" class="upload-filename custom-text text-center m-0"></p>
                                </div>
                                
                                <!-- Toggle Izinkan Download -->
                                <div class="w-100 mt-2 px-1">
                                    <div class="form-check form-switch d-flex align-items-center gap-3 p-0">
                                        <input class="form-check-input ms-0" type="checkbox" role="switch" id="isDownloadable" checked style="width: 2.5rem; height: 1.25rem; cursor: pointer;">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label fw-bold custom-small-font mb-0" for="isDownloadable" style="cursor: pointer;">Izinkan pemohon mengunduh file ini</label>
                                            <small class="text-muted custom-text" style="font-size: 0.65rem;">Nonaktifkan jika file hanya untuk internal</small>
                                        </div>
                                    </div>
                                </div>

                                <button class="flex-fill btn btn-success" type="button" id="btnKirimLaporan">Kirim laporan</button>
                                <button type="button" id="btnBatalPenyelesaian" class="flex-fill btn btn-light border">batal</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="m-0 fw-bold mb-2 custom-small-font text-muted">Aksi Penugasan Staff Belum Diproses.</p>
            <div class="rounded-3 w-100 d-flex gap-3 shadow-sm border border-light bg-light p-4 justify-content-center">
                <p class="m-0 custom-text text-secondary text-center">Tugas belum di-assign atau belum ada instruksi untuk staff ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="d-flex align-items-center gap-3">
    <div class="timeline-icon-box <?= ($detail['tiket_status'] === 'In Progress') ? 'bg-secondary' : 'bg-success' ?> text-white">
        <span class="step-num">3</span>
        <iconify-icon icon="<?= ($detail['tiket_status'] === 'In Progress') ? 'streamline-ultimate:task-list-approve' : 'ic:round-check' ?>"></iconify-icon>
    </div>
    <p class="m-0 fw-bold custom-small-font">approval kepala urusan (pak bagas)</p>
</div>

<script>
    // ini adalah script untuk menampilkan nama file yang diunggah pada label setelah user memilih file
    const upload = document.getElementById("uploadBukti");
    const fileName = document.getElementById("fileName");

    if (upload && fileName) {
        upload.addEventListener("change", function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
            }
        });
    }

    const uploadLog = document.getElementById("uploadBuktiLog");
    const fileNameLog = document.getElementById("fileNameLog");
    if (uploadLog && fileNameLog) {
        uploadLog.addEventListener("change", function() {
            if (this.files.length > 0) {
                fileNameLog.textContent = this.files[0].name;
            }
        });
    }

    // Script toggle form penyelesaian
    const btnSelesaikan = document.getElementById("btnSelesaikanTugas");
    const wrapperPenyelesaian = document.getElementById("wrapperPenyelesaian");
    const btnBatal = document.getElementById("btnBatalPenyelesaian");

    if (btnSelesaikan && wrapperPenyelesaian && btnBatal) {
        btnSelesaikan.addEventListener("click", function() {
            wrapperPenyelesaian.classList.toggle("show");
            if (typeof wrapperLogPekerjaan !== 'undefined' && wrapperLogPekerjaan) wrapperLogPekerjaan.classList.remove("show");

            if (wrapperPenyelesaian.classList.contains("show")) {
                btnSelesaikan.textContent = "Tutup Form Penyelesaian";
                btnSelesaikan.classList.remove("btn-danger");
                btnSelesaikan.classList.add("btn-secondary");
            } else {
                btnSelesaikan.textContent = "Selesaikan Tugas";
                btnSelesaikan.classList.remove("btn-secondary");
                btnSelesaikan.classList.add("btn-danger");
            }
        });

        btnBatal.addEventListener("click", function() {
            wrapperPenyelesaian.classList.remove("show");
            btnSelesaikan.textContent = "Selesaikan Tugas";
            btnSelesaikan.classList.remove("btn-secondary");
            btnSelesaikan.classList.add("btn-danger");

            // opsional: reset form
            document.querySelector('#formPenyelesaianTugas textarea').value = '';
            if (upload) upload.value = '';
            if (fileName) fileName.textContent = '';
        });
    }

    // Script toggle form log pekerjaan
    const btnLogPekerjaan = document.getElementById("btnLogPekerjaan");
    const wrapperLogPekerjaan = document.getElementById("wrapperLogPekerjaan");
    const btnBatalLog = document.getElementById("btnBatalLog");

    if (btnLogPekerjaan && wrapperLogPekerjaan && btnBatalLog) {
        btnLogPekerjaan.addEventListener("click", function() {
            wrapperLogPekerjaan.classList.toggle("show");
            if (wrapperPenyelesaian) {
                wrapperPenyelesaian.classList.remove("show");
                if (btnSelesaikan) {
                    btnSelesaikan.textContent = "Selesaikan Tugas";
                    btnSelesaikan.classList.remove("btn-secondary");
                    btnSelesaikan.classList.add("btn-danger");
                }
            }
        });

        btnBatalLog.addEventListener("click", function() {
            wrapperLogPekerjaan.classList.remove("show");
            document.getElementById('formLogPekerjaan').reset();
            if (fileNameLog) fileNameLog.textContent = '';
        });
    }

    // Form Log Submission AJAX
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