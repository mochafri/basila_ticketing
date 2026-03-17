<div class="d-flex gap-3 w-100">
    <iconify-icon icon="hugeicons:task-01" class="text-white btn btn-danger h-25"></iconify-icon>
    <div class="flex-grow-1">
        <p class="m-0 fw-bold mb-2 custom-small-font">penugasan : pak bagas</p>
        <div class="rounded-3 w-100 d-flex gap-3 shadow-md border p-2">
            <div class="d-flex gap-3 align-items-center p-3 rounded">
                <iconify-icon icon="icon-park-outline:dot" class="text-warning fs-3"></iconify-icon>
                <div class="d-flex flex-column gap-2">
                    <span class="custom-small-font fw-bold">Testing/Judul</span>
                    <span style="font-size: .7rem;"
                        class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded">STAFF ADM
                        1</span>
                </div>
            </div>
            <!-- button selesaikan tugas -->
            <div class="d-flex align-items-center  justify-content-end flex-grow-1">
                <button class="btn btn-danger text-uppercase custom-small-font fw-medium py-2 px-4 me-3">Selesaikan Tugas</button>
            </div>

            <!-- ini akan muncul setelah button "selesaikan tugas diklik" -->
            <!-- <div class="bg-light flex-grow-1 p-3 rounded border border-2">

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
                    <button class="flex-fill btn btn-success" type="submit">Kirim laporan</button>
                    <button class="flex-fill btn btn-light border">batal</button>
                </div>

            </div> -->
        </div>
    </div>
</div>
<div class="d-flex align-items-center gap-3">
    <iconify-icon icon="ic:round-check" class="text-white btn btn-success "></iconify-icon>
    <p class="m-0 fw-bold custom-small-font">approval kepala urusan (bu fira)</p>
</div>

<script>
    // ini adalah script untuk menampilkan nama file yang diunggah pada label setelah user memilih file, bisa dipindahkan nanti
    const upload = document.getElementById("uploadBukti");
    const fileName = document.getElementById("fileName");

    upload.addEventListener("change", function () {
        if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
        }
    });
</script>