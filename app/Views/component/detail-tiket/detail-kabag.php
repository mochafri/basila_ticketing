<div class="card border-0">
    <div class="card-body p-5 d-flex flex-column gap-4 text-uppercase">
        <div class="d-flex align-items-center gap-3">
            <iconify-icon icon="material-symbols:timeline" class="text-danger fs-2"></iconify-icon>
            <h5 class="fw-bold">Timeline & alur kerja</h5>
        </div>
        <!-- status 1 -->
        <div class="d-flex align-items-center gap-3">
            <iconify-icon icon="hugeicons:plus-sign" class="text-white btn btn-success "></iconify-icon>
            <p class="m-0 fw-bold custom-small-font">Tiket berhasil di ajukan</p>
        </div>
        <!-- status 2 -->
        <div class="d-flex gap-3 w-100">
            <iconify-icon icon="ic:round-check" class="text-white btn btn-danger h-25"></iconify-icon>
            <div class="flex-grow-1">
                <p class="m-0 fw-bold mb-2 custom-small-font">approval kepala urusan (bu fira)</p>
                <div class="p-4 bg-light rounded-3 w-100 d-flex gap-3 flex-column shadow-md">
                    <p class="m-0 fw-medium custom-text">Pilih delegasi kepala bagian</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <label
                            class="flex-fill p-4 bg-white d-flex justify-content-between align-items-center rounded-3 shadow-sm">
                            <span>pak bagas</span>
                            <input type="radio" name="delegasi1">
                        </label>
                        <label
                            class="flex-fill p-4 bg-white d-flex justify-content-between align-items-center rounded-3 shadow-sm">
                            <span>bu farida</span>
                            <input type="radio" name="delegasi1">
                        </label>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mt-4">
                        <button type="button" class="btn btn-success flex-fill p-4 text-uppercase fw-bold rounded-4">setujui &
                            tugaskan</button>
                        <button type="button"
                            class="btn btn-primary flex-fill p-4 text-uppercase fw-bold rounded-4">eskalasi</button>
                        <button type="button" class="btn btn-danger flex-fill p-4 text-uppercase fw-bold rounded-4">tolak</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- status 3 -->
        <div class="d-flex align-items-center gap-3">
            <iconify-icon icon="ic:round-done-all" class=" btn btn-light shadow-sm md "></iconify-icon>
            <p class="m-0 fw-bold custom-small-font">Konfirmasi penyelesaian (final)</p>
        </div>
    </div>
</div>