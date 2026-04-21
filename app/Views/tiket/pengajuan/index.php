<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid" id="pengajuan-tiket">
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="card mt-4 border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="row header mb-5">
                        <div class="col-6">
                            <h2 class="text-uppercase fw-bold">Pengajuan Tiket Layanan</h2>
                        </div>
                    </div>
                    <div class="row g-4 needs-validation">
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
                            <button class="btn btn-danger btn-submit" type="button">Submit form</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkBox = document.getElementById('invalidCheck');
        const btnSubmit = document.querySelector('.btn-submit');

        btnSubmit.disabled = true;

        checkBox.addEventListener('change', function() {
            btnSubmit.disabled = !this.checked;
        });
    });
</script>
<?= $this->endSection() ?>