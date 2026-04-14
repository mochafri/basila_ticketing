<?= $this->extend('layout/auth'); ?>
<?= $this->section('content'); ?>

<div class="container py-5">

    <!-- Logo -->
    <div class="text-center mb-4">
        <img src="<?= base_url('assets/img/basila_color.png') ?>" width="140" alt="logo">
    </div>

    <!-- Subtitle -->
    <p class="text-center text-muted mb-5 subtitle-role">
        Pilihlah user group yang terdaftar pada akun anda <br>
        untuk menentukan hak akses pada aplikasi
        <span class="text-danger fw-semibold">BASILA</span>
    </p>


    <div class="col-md-6"></div>
    <!-- Role List -->
    <div class="row">

        <?php if (session()->get('roles')): ?>
            <?php foreach (session()->get('roles') as $data): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="role-card">

                        <!-- Icon -->
                        <div class="role-icon">
                            <iconify-icon icon="mynaui:smile-ghost-solid" width="50" height="50"
                                style="color: #E60042;"></iconify-icon>
                        </div>

                        <!-- Text + Button -->
                        <div>
                            <div class="role-title text-uppercase">
                                <?= esc($data['role']); ?>
                            </div>

                            <form method="post" action="<?= site_url('role-choice'); ?>">
                                <?= csrf_field(); ?>

                                <input type="hidden" name="role_name" value="<?= esc($data['role']); ?>">
                                <input type="hidden" name="role_id" value="<?= esc($data['id']); ?>">

                                <button type="submit" class="btn-pill-role mt-1">
                                    Pilih User Group
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
                
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Data role tidak ditemukan</p>
        <?php endif; ?>


    </div>

</div>

<?= $this->endSection(); ?>