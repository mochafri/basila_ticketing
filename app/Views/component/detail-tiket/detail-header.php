<div class="card mb-4 border-0">
    <div class="card-header p-5 pb-3 bg-transparent">
        <div class="card-title">
            <h2 class="text-uppercase fw-bold" style="letter-spacing: -1px;"><?= $detail['judul_permohonan'] ?></h2>
            <div class="d-flex gap-4 align-items-center mt-3">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="basil:stack-outline" class="text-danger"></iconify-icon>
                    <span class="text-uppercase fw-medium custom-text"><?= $detail['kategori_layanan'] ?> /
                        <?= $detail['per_kategori_layanan'] ?></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="bi:person" class="text-danger"></iconify-icon>
                    <span class="text-uppercase fw-medium custom-text">oleh : staff
                        user</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-5 d-flex flex-column gap-4 task-desc">
        <p class="fs-5 fw-medium"><?= $detail['deskripsi_permohonan'] ?></p>
        <span class="text-uppercase custom-text">dokumen pendukung:</span>
        <a href="<?= base_url('tiket/file/users/' . $detail['dokumen_lampiran']) ?>" target="_blank"
            class="btn btn-light col-3 d-flex align-items-center gap-2 justify-content-center">
            <iconify-icon icon="fluent:document-20-regular"></iconify-icon>
            <span class="custom-small-font">
                <?= $detail['original_dokumen_name'] ?>
            </span>
        </a>
    </div>
</div>