<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4 px-4 dashboard-wrapper">

    <!-- Header -->
    <div class="mb-5">
        <div>
            <h2 class="fw-bold title-dashboard">MASTER DATA MANAGEMENT</h2>
            <span class="text-muted subtitle-dashboard">
                Kelola role dan user akses dalam sistem BASILA
            </span>
        </div>
    </div>

    <!-- CARD CONTEN -->
    <!-- INPUT SECTION -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card master-card p-5">
                <div class="row g-5">
                    <!-- ADD ROLE -->
                    <div class="col-md-6 border-end">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="icon-box" style="width: 45px; height: 45px; background: #ffe5e5; color: var(--primaryColor); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="solar:shield-keyhole-bold-duotone" style="font-size: 24px;"></iconify-icon>
                            </div>
                            <h5 class="fw-bold mb-0">TAMBAH ROLE</h5>
                        </div>
                        <div class="d-flex gap-3 mt-4">
                            <input type="text" id="role_name" class="form-control custom-input" placeholder="NAMA ROLE BARU">
                            <button class="btn btn-danger btn-master" id="add-role">
                                <iconify-icon icon="mdi:plus"></iconify-icon>
                                SIMPAN
                            </button>
                        </div>
                    </div>

                    <!-- USER MAPPING -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="icon-box" style="width: 45px; height: 45px; background: #eef2ff; color: #4f46e5; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="solar:user-plus-bold-duotone" style="font-size: 24px;"></iconify-icon>
                            </div>
                            <h5 class="fw-bold mb-0">MAPPING USER ROLE</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-7">
                                <div class="select-wrapper w-100">
                                    <select id="user_select" class="form-select custom-input">
                                        <option selected disabled>PILIH USER</option>
                                        <?php foreach($users as $user): ?>
                                            <option value="<?= esc($user['username']) ?>" data-nip="<?= esc($user['nip']) ?>">
                                                <?= esc($user['username']) ?> (<?= esc($user['nip'] ?? '-') ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="nip" class="form-control custom-input" placeholder="NIP (OTOMATIS)" readonly style="background: #f8fafc;">
                            </div>
                            <div class="col-md-7">
                                <div class="select-wrapper w-100">
                                    <select id="role_id" class="form-select custom-input">
                                        <option selected disabled>PILIH ROLE</option>
                                        <?php foreach($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>"><?= esc($role['role_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <button class="btn btn-danger btn-master w-100 justify-content-center" id="add-user-mapping">
                                    <iconify-icon icon="mdi:plus"></iconify-icon>
                                    MAPPING
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LIST SECTION -->
    <div class="row g-4">
        <!-- ROLE LIST -->
        <div class="col-md-4">
            <div class="card master-card p-4 h-100 shadow-sm border-0">
                <h5 class="fw-bold mb-4">DAFTAR ROLE</h5>
                <div class="list-wrapper scrollable-list" style="max-height: 500px; overflow-y: auto;">
                    <?php foreach($roles as $role): ?>
                        <div class="list-item mb-3 p-3 bg-light rounded-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <span class="dot-red"></span>
                                <span class="fw-bold text-uppercase" style="font-size: 0.9rem; color: #1e293b;"><?= esc($role['role_name']) ?></span>
                            </div>
                            <span class="badge bg-danger-custom" style="font-size: 10px; border-radius: 8px;">SYSTEM</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- MAPPING LIST -->
        <div class="col-md-8">
            <div class="card master-card p-4 h-100 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-0">DAFTAR MAPPING USER</h5>
                        <small class="text-muted">Akses user yang terdaftar dalam sistem</small>
                    </div>
                    <div class="badge bg-blue-custom py-2 px-3" style="border-radius: 10px;">
                        <?= count($userRoles) ?> USER TERDAFTAR
                    </div>
                </div>
                <div class="list-wrapper scrollable-list" style="max-height: 500px; overflow-y: auto; padding-right: 8px;">
                    <div class="row g-3">
                        <?php foreach($userRoles as $ur): ?>
                            <div class="col-md-6">
                                <div class="list-item p-3 bg-light rounded-4 d-flex justify-content-between align-items-center category-box-card">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon-box" style="width: 40px; height: 40px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                            <iconify-icon icon="solar:user-circle-bold" style="font-size: 20px; color: #64748b;"></iconify-icon>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size: 0.95rem; color: #1e293b;"><?= esc($ur['user_fullname']) ?></div>
                                            <div class="d-flex gap-2 align-items-center mt-1">
                                                <small class="badge bg-white text-danger border border-danger-subtle" style="font-size: 9px;"><?= esc($ur['role_name']) ?></small>
                                                <small class="text-muted" style="font-size: 11px;"><?= esc($ur['user_nip']) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-white btn-sm rounded-circle shadow-sm" onclick="deleteMapping(<?= $ur['id'] ?>)" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none; background: white;">
                                        <iconify-icon icon="mdi:close" style="color: #ef4444; font-size: 1rem;"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-role').addEventListener('click', function() {
        const roleName = document.getElementById('role_name').value;
        if (!roleName) return Swal.fire('Error', 'Nama role harus diisi', 'error');

        fetch('/create-role', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ role_name: roleName })
        }).then(res => res.json()).then(data => {
            if (data.status === 'success') {
                Swal.fire('Success', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    });

    document.getElementById('user_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const nip = selectedOption.getAttribute('data-nip');
        document.getElementById('nip').value = nip || '-';
    });

    document.getElementById('add-user-mapping').addEventListener('click', function() {
        const username = document.getElementById('user_select').value;
        const nip = document.getElementById('nip').value;
        const role_id = document.getElementById('role_id').value;

        if (!username || username === 'PILIH USER' || !role_id || role_id === 'PILIH ROLE') {
            return Swal.fire('Error', 'User dan Role harus diisi', 'error');
        }

        fetch('/create-user-mapping', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, nip, role_id })
        }).then(res => res.json()).then(data => {
            if (data.status === 'success') {
                Swal.fire('Success', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    });

    function deleteMapping(id) {
        Swal.fire({
            title: 'Hapus mapping?',
            text: "User tidak akan memiliki akses role ini lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/delete-user-mapping/${id}`, {
                    method: 'DELETE'
                }).then(res => res.json()).then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection(); ?>