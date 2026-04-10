<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>

<section class="vh-100 d-flex align-items-center justify-content-center overflow-hidden m-0 p-3">
    <div class="container">
        <div class="row w-100 justify-content-center mx-auto">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5 bg-white d-flex flex-column" style="max-height: 90vh;">
                    
                    <div class="text-center mb-5 flex-shrink-0">
                        <a href="<?= site_url('/'); ?>">
                            <img src="<?= base_url('assets/basila_images/basila_color.png'); ?>" width="120" alt="Basila Logo" class="mb-3">
                        </a>
                        <h4 class="fw-bold text-dark">Pilih Role Anda</h4>
                        <p class="text-muted small mb-0">Silakan pilih akses role Anda untuk melanjutkan</p>
                    </div>

                    <?php if (session()->get('roles')): ?>
                        <div class="row g-3 overflow-y-auto custom-scrollbar pe-2" style="max-height: 50vh;">
                            <?php foreach (session()->get('roles') as $data): ?>
                                <div class="col-12 col-md-6 col-xl-4">
                                    <form method="post" action="<?= site_url('role-choice'); ?>" class="m-0 h-100">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="role_name" value="<?= esc($data['role']); ?>">
                                        <input type="hidden" name="role_id" value="<?= esc($data['id']); ?>">
                                        
                                        <button type="submit" class="role-btn w-100 h-100 text-start d-flex align-items-center p-3 rounded-4 shadow-sm border">
                                            <span class="role-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-3 flex-shrink-0">
                                                <iconify-icon icon="solar:user-id-bold-duotone" width="28"></iconify-icon>
                                            </span>
                                            <div class="overflow-hidden">
                                                <span class="d-block fw-bold fs-6 text-dark role-title text-truncate"><?= esc($data['role']); ?></span>
                                                <small class="text-secondary role-subtitle text-truncate d-block">Akses <?= esc($data['role']); ?></small>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 flex-shrink-0">
                            <span class="fs-1 text-danger">
                                <iconify-icon icon="solar:shield-warning-bold-duotone"></iconify-icon>
                            </span>
                            <p class="text-muted mt-3 mb-0">Data role tidak ditemukan</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    
</style>

<?= $this->endSection(); ?>