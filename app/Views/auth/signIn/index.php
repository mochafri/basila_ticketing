<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert-custom">
        <?= session()->getFlashdata('error'); ?>
        <span class="close-alert" onclick="this.parentElement.remove()">×</span>
    </div>
<?php endif; ?>

<section class="auth-container">

    <!-- Left -->
    <div class="auth-left">
        <div class="auth-left-content">
            <img src="<?= base_url('assets/basila_images/telu.png'); ?>" width="500">
        </div>
    </div>

    <!-- Right -->
    <div class="auth-right">
        <div class="auth-box">

            <a href="<?= site_url('/'); ?>">
                <img src="<?= base_url('assets/basila_images/basila_color.png'); ?>" width="100">
            </a>

            <h4>Masuk ke akun anda</h4>
            <p class="subtitle">Selamat datang kembali! Silakan masukkan detail Anda</p>

            <?php $errors = session()->getFlashdata('validation'); ?>
            <?php if ($errors): ?>
                <div class="alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/signin'); ?>" method="post">
                <?= csrf_field(); ?>

                <!-- Username -->
                <div class="form-group">
                    <span class="auth-icon">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="text" name="username" placeholder="username SSO">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <span class="auth-icon">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" name="password" id="password" placeholder="Password">
                    <span class="toggle-password" data-toggle="#password">👁</span>
                </div>

                <!-- Forgot -->
                <div class="form-footer">
                    <a href="https://satu.telkomuniversity.ac.id/auth/forgot-password">
                        Lupa password?
                    </a>
                </div>

                <button type="submit" class="btn-login">
                    SSO Login
                </button>

            </form>
        </div>
    </div>

</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.querySelector('.alert-custom');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }, 2000);
        }

        document.querySelectorAll('.toggle-password').forEach(el => {
            el.addEventListener('click', function () {
                let input = document.querySelector(this.dataset.toggle);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    });
</script>

<?= $this->endSection(); ?>