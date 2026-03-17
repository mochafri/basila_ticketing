<div class="d-flex gap-3 w-100">
    <iconify-icon icon="hugeicons:plus-sign" class="btn btn-light h-25"></iconify-icon>
    <div class="flex-grow-1">
        <p class="m-0 fw-bold custom-small-font">Penugasan: pak bagas</p>
        <button class="btn btn-danger rounded-3 w-100 mt-2 text-uppercase fw-bold custom-small-font py-3"
            style="letter-spacing: 3px;">terima & mulai penugasan</button>

        <!-- akan aktif kalau button sudah di klik -->
        <div class="p-4 bg-light rounded-3 w-100 d-flex gap-3 flex-column shadow-md mt-2 border">
            <p class="m-0 fw-medium custom-text">delegasi penugasan staff</p>
            <div class="d-flex gap-2 flex-wrap">
                <input class="btn bg-white custom-text fw-bold px-4 border " type="button" value="STAFF ADM 1">
                <input class="btn bg-white custom-text fw-bold px-4 border" type="button" value="STAFF ADM 2">
            </div>
            <div class="d-flex gap-3 mt-4 align-items-stretch">
                <input type="text" class="form-control text-uppercase custom-text p-3 rounded-4 fw-medium"
                    placeholder="Instruksi pengerjaan staff">
                <button type="button" class="btn btn-danger fw-bold">
                    +
                </button>
            </div>
        </div>

        <!-- akan muncul setelah tugas diberikan kepada staff -->
        <div class="p-4 w-100 d-flex gap-3 align-items-center shadow-sm p-3 my-5 rounded">
            <iconify-icon icon="icon-park-outline:dot" class="text-warning fs-3"></iconify-icon>
            <div class="d-flex flex-column gap-2">
                <span class="custom-small-font fw-bold">Testing/Judul</span>
                <span style="font-size: .7rem;"
                    class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded">STAFF ADM 1</span>
            </div>
        </div>

        <!-- ini akan muncul jika staff telah mengerjakan dan menyerahkan tugas -->
        <div
            class="p-4 w-100 d-flex gap-3 align-items-center shadow-sm p-3 my-5 rounded flex-grow-1 justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <iconify-icon icon="icon-park-outline:dot" class="text-warning fs-3"></iconify-icon>
                <div class="d-flex flex-column gap-2 flex-grow-1">
                    <p class="custom-small-font fw-bold m-0">Testing/Judul</p>
                    <p style="font-size: .7rem;"
                        class="text-danger bg-danger bg-opacity-10 px-2 py-1 fw-bold text-center rounded m-0 w-50">STAFF
                        ADM
                        1
                    </p>
                    <div class="bg-light p-3 rounded border" style="min-width: 300px;">
                        <p class="custom-text fw-medium">laporan penyelesaian staff</p>
                        <p class="custom-small-font fw-semibold">"yesssir"</p>
                        <hr>
                        <button class="py-2 px-4 rounded-2 border custom-small-font bg-white"><iconify-icon
                                icon="hugeicons:file-01" class="text-danger"></iconify-icon> mobile.png</button>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-success flex-fill px-4 py-2 fw-semibold">Verifikasi</button>
                <button class="btn btn-warning flex-fill px-4 py-2 fw-semibold text-white">Revisi</button>
            </div>
            
            <!-- icon muncul setelah tugas di verifikasi/diterima -->
            <!-- <div class="">
                <iconify-icon icon="ph:check-bold" class="text-success fs-3"></iconify-icon>
            </div> -->
        </div>
        <button class="btn btn-success rounded-3 w-100 mt-2 text-uppercase fw-bold custom-small-font py-3">selesaikan bagian penugasan</button>
    </div>
</div>