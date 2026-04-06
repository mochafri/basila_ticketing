<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="pengajuan-tiket">
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="card mt-4 border-0 shadow-lg rounded-4">
                <!-- Created Tiket succesed -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <iconify-icon icon="hugeicons:plus-sign" class="text-white btn btn-success"></iconify-icon>
                            <p class="m-0 fw-bold custom-small-font">
                                <?= session()->getFlashdata('success') ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Tambahin aja disini 1 lagi buat gagal membuat tiket nya -->
                <div class="card-body p-5">
                    <div class="row header mb-5">
                        <div class="col-6">
                            <h2 class="text-uppercase fw-bold">Pengajuan Tiket Layanan</h2>
                        </div>
                    </div>
                    <form class="row g-4 needs-validation" action="/tiket/baru" method="post"
                        enctype="multipart/form-data" novalidate>
                        <?= csrf_field() ?>
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label text-uppercase ">Judul permohonan</label>
                            <input type="text" name="judul" class="form-control" id="validationCustom01" value=""
                                required placeholder="Masukkan judul permohonan...">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label text-uppercase">kategori layanan</label>
                            <select class="form-select kategori" name="kategori" id="validationCustom04" required>
                                <option selected disabled value="">Pilih...</option>
                                <?php foreach ($kategori as $data): ?>
                                    <option value="<?= $data['id'] ?>">
                                        <?= $data['kategori_layanan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Silahkan pilih kategori layanan yang sesuai.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label text-uppercase">spesifikasi
                                layanan</label>
                            <select class="form-select layanan" name="layanan" id="validationCustom04" required>
                                <option selected disabled value="">Pilih...</option>
                            </select>
                            <div class="invalid-feedback">
                                Silahkan pilih spesifikasi layanan yang sesuai dengan kebutuhan anda.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationTextarea" class="form-label text-uppercase">
                                deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="validationTextarea"
                                placeholder="Silahkan jelaskan secara detail kebutuhan layanan yang anda ajukan"
                                required rows="5"></textarea>
                            <div class="invalid-feedback">
                                Jelaskan kebutuhan layanan yang anda ajukan dengan detail agar dapat diproses dengan
                                cepat dan tepat.
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="validationCustom04" class="form-label text-uppercase">Lampiran Dokumen </label>
                            <div class="input-group mb-3">
                                <input type="file" name="lampiran_dokumen" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                    Agree to terms and conditions
                                </label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-danger" type="submit">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.querySelector('.alert');

        if (!alert)
            return;

        // slide in
        setTimeout(() => {
            alert.classList.add('show')
        }, 200);

        // slide out
        setTimeout(() => {
            alert.classList.remove('show');
        }, 3000);
    });
</script>
<?= $this->endSection() ?>