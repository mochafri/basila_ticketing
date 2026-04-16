<div class="d-flex gap-3 w-100">
    <iconify-icon icon="hugeicons:task-01" class="text-white btn btn-danger h-25"></iconify-icon>
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
            <p class="m-0 fw-bold mb-2 custom-small-font">penugasan : <?= esc(strtoupper($taskStaff['assign_task_to_staff'])) ?></p>
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
                    </div>
                </div>
                <!-- button selesaikan tugas -->
                <div id="containerBtnSelesaikan" class="d-flex align-items-center justify-content-end flex-grow-1 p-2">
                    <?php if($taskStaff['task_status'] !== 'Selesai' && $taskStaff['task_status'] !== 'Menunggu Approve'): ?>
                    <button id="btnSelesaikanTugas" type="button" class="btn btn-danger text-uppercase custom-small-font fw-medium py-2 px-4 me-3">Selesaikan Tugas</button>
                    <?php endif; ?>
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
    <iconify-icon icon="<?php if ($detail['tiket_status'] === 'In Progress'): ?>streamline-ultimate:task-list-approve<?php else: ?>ic:round-check<?php endif; ?>" class="text-white <?php if ($detail['tiket_status'] === 'In Progress'): ?>btn btn-secondary<?php else: ?>btn btn-success<?php endif; ?> "></iconify-icon>
    <p class="m-0 fw-bold custom-small-font">approval kepala urusan (pak bagas)</p>
</div>

<script>
    // ini adalah script untuk menampilkan nama file yang diunggah pada label setelah user memilih file, bisa dipindahkan nanti
    const upload = document.getElementById("uploadBukti");
    const fileName = document.getElementById("fileName");

    if (upload && fileName) {
        upload.addEventListener("change", function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
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
</script>