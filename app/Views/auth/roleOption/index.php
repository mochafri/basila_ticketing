<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>

<div class="w-full max-w-4xl p-6 mx-auto">
    <h1 class="text-xl font-semibold text-center text-gray-800 mb-6">
        Pilih Role
    </h1>

    <?php if (session()->get('roles')): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

            <?php foreach (session()->get('roles') as $data): ?>
                <form method="post" action="<?= site_url('role-choice'); ?>">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="role_name" value="<?= esc($data['role']); ?>">
                    <input type="hidden" name="role_id" value="<?= esc($data['id']); ?>">

                    <button type="submit"
                        class="w-full h-24 bg-white border border-gray-200 rounded-lg p-4 
                               hover:bg-gray-50 text-left flex items-center gap-3">

                        <div class="text-blue-500 text-xl shrink-0">👤</div>

                        <p class="text-gray-800 font-medium truncate w-full">
                            <?= esc($data['role']); ?>
                        </p>

                    </button>
                </form>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <p class="text-center text-gray-500">
            Data role tidak ditemukan
        </p>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>