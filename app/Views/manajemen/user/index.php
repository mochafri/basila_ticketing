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
                            <h5 class="fw-bold mb-0 text-uppercase">Mapping User Role</h5>
                        </div>
                        
                        <div class="row g-3">
                            <!-- CUSTOM MULTISELECT USER -->
                            <div class="col-md-7 position-relative">
                                <div class="custom-multiselect" id="multiselect-user">
                                    <div class="select-trigger custom-input d-flex justify-content-between align-items-center bg-light border-0 rounded-4 px-3 py-2" style="cursor: pointer; min-height: 45px;">
                                        <span class="text-muted small fw-bold" id="selected-users-label">PILIH USER</span>
                                        <iconify-icon icon="solar:alt-arrow-down-outline" class="text-muted"></iconify-icon>
                                    </div>
                                    <div class="multiselect-dropdown shadow-lg border-0 rounded-4 p-3 d-none position-absolute w-100 bg-white" style="z-index: 1000; margin-top: 5px;">
                                        <div class="form-check mb-2 border-bottom pb-2">
                                            <input class="form-check-input" type="checkbox" id="check-all-users">
                                            <label class="form-check-label small fw-bold text-danger" for="check-all-users" style="cursor: pointer;">PILIH SEMUA USER</label>
                                        </div>
                                        <div class="scrollable-area" style="max-height: 180px; overflow-y: auto;">
                                            <?php foreach($users as $user): ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input user-checkbox" type="checkbox" value="<?= esc($user['username']) ?>" data-nip="<?= esc($user['nip']) ?>" id="user_<?= esc($user['username']) ?>">
                                                    <label class="form-check-label small fw-bold text-dark" for="user_<?= esc($user['username']) ?>" style="cursor: pointer;">
                                                        <?= esc($user['username']) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-5">
                                <input type="text" id="nip_display" class="form-control custom-input bg-light border-0 rounded-4" placeholder="NIP TERPILIH" readonly style="background: #f8fafc; font-size: 0.8rem; height: 45px;">
                            </div>

                            <!-- CUSTOM MULTISELECT ROLE -->
                            <div class="col-md-7 position-relative">
                                <div class="custom-multiselect" id="multiselect-role">
                                    <div class="select-trigger custom-input d-flex justify-content-between align-items-center bg-light border-0 rounded-4 px-3 py-2" style="cursor: pointer; min-height: 45px;">
                                        <span class="text-muted small fw-bold" id="selected-roles-label">PILIH ROLE</span>
                                        <iconify-icon icon="solar:alt-arrow-down-outline" class="text-muted"></iconify-icon>
                                    </div>
                                    <div class="multiselect-dropdown shadow-lg border-0 rounded-4 p-3 d-none position-absolute w-100 bg-white" style="z-index: 1000; margin-top: 5px;">
                                        <div class="form-check mb-2 border-bottom pb-2">
                                            <input class="form-check-input" type="checkbox" id="check-all-roles">
                                            <label class="form-check-label small fw-bold text-danger" for="check-all-roles" style="cursor: pointer;">PILIH SEMUA ROLE</label>
                                        </div>
                                        <div class="scrollable-area" style="max-height: 180px; overflow-y: auto;">
                                            <?php foreach($roles as $role): ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input role-checkbox" type="checkbox" value="<?= $role['id'] ?>" data-name="<?= esc($role['role_name']) ?>" id="role_<?= $role['id'] ?>">
                                                    <label class="form-check-label small fw-bold text-dark" for="role_<?= $role['id'] ?>" style="cursor: pointer;">
                                                        <?= esc($role['role_name']) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <button class="btn btn-danger btn-master w-100 justify-content-center" id="add-user-mapping" style="height: 45px; border-radius: 12px;">
                                    <iconify-icon icon="mdi:link-variant"></iconify-icon>
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
                        <small class="text-muted">Kelola akses user dalam sistem</small>
                    </div>
                    <div class="badge bg-blue-custom py-2 px-3" style="border-radius: 10px;">
                        <?= $pager->getTotal('user_roles') ?> USER TERDAFTAR
                    </div>
                </div>

                <!-- FILTER & SEARCH -->
                <form action="" method="GET" class="row g-3 mb-4">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4">
                                <iconify-icon icon="ph:magnifying-glass-bold" class="text-muted"></iconify-icon>
                            </span>
                            <input type="text" name="search" class="form-control bg-light border-0 rounded-end-4 custom-input ps-0" placeholder="Cari nama atau NIP..." value="<?= esc($search) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="select-wrapper">
                            <select name="role" class="form-select bg-light border-0 rounded-4 custom-input" onchange="this.form.submit()">
                                <option value="">Semua Role</option>
                                <?php foreach($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= $roleFilter == $role['id'] ? 'selected' : '' ?>><?= esc($role['role_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-danger w-100 rounded-4 fw-bold">FILTER</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="ps-3 py-3 text-uppercase small fw-bold text-muted" style="width: 60%;">User</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted text-center" style="width: 40%;">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($userRoles as $ur): 
                                $roleList = explode('|', $ur['roles_list']);
                                $idList = explode('|', $ur['ids_list']);
                            ?>
                                <tr>
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="icon-box shadow-sm" style="width: 42px; height: 42px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                                <iconify-icon icon="solar:user-circle-bold-duotone" style="font-size: 24px; color: #64748b;"></iconify-icon>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= esc($ur['user_fullname']) ?></div>
                                                <small class="text-muted font-monospace" style="font-size: 0.75rem; letter-spacing: 0.5px;">NIP: <?= esc($ur['user_nip']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center py-3">
                                        <div class="d-flex align-items-center justify-content-center gap-2 role-badges-grid-container">
                                            <div class="role-badges-grid">
                                                <?php foreach($roleList as $index => $roleName): ?>
                                                    <span class="badge role-badge-compact shadow-sm">
                                                        <span><?= esc($roleName) ?></span>
                                                        <iconify-icon icon="ph:x-bold" class="delete-icon" onclick="deleteMapping(<?= $idList[$index] ?>)"></iconify-icon>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php if(count($roleList) > 1): ?>
                                                <iconify-icon icon="solar:alt-arrow-down-outline" class="text-danger opacity-25 roles-expand-indicator fs-5"></iconify-icon>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(empty($userRoles)): ?>
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted bg-white">
                                        <iconify-icon icon="ph:user-minus-duotone" class="fs-1 d-block mb-2 text-danger opacity-50"></iconify-icon>
                                        <p class="m-0 fw-medium">Tidak ada mapping user yang ditemukan.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="mt-5 d-flex justify-content-center">
                    <?= $pager->links('user_roles', 'premium') ?>
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
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: JSON.stringify({ role_name: roleName })
        }).then(res => res.json()).then(data => {
            if (data.status === 'success') {
                Swal.fire('Success', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    });

    // --- Custom Multiselect Logic ---
    function setupMultiselect(id, labelId) {
        const wrapper = document.getElementById(id);
        const trigger = wrapper.querySelector('.select-trigger');
        const dropdown = wrapper.querySelector('.multiselect-dropdown');
        const label = document.getElementById(labelId);
        const checkboxes = wrapper.querySelectorAll('input[type="checkbox"]:not(#check-all-users):not(#check-all-roles)');

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('.multiselect-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.add('d-none');
            });
            dropdown.classList.toggle('d-none');
        });

        wrapper.addEventListener('click', (e) => e.stopPropagation());

        function updateLabel() {
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const originalText = id.includes('user') ? 'PILIH USER' : 'PILIH ROLE';
            
            if (checkedCount === 0) {
                label.textContent = originalText;
                label.classList.add('text-muted');
            } else if (checkedCount === checkboxes.length) {
                label.textContent = 'SEMUA TERPILIH';
                label.classList.remove('text-muted');
            } else {
                label.textContent = `${checkedCount} TERPILIH`;
                label.classList.remove('text-muted');
            }

            if (id.includes('user')) {
                const checkedUsers = Array.from(checkboxes).filter(cb => cb.checked);
                const nipDisplay = document.getElementById('nip_display');
                if (checkedUsers.length === 1) {
                    nipDisplay.value = checkedUsers[0].getAttribute('data-nip') || '-';
                } else if (checkedUsers.length > 1) {
                    nipDisplay.value = 'MULTIPLE NIP';
                } else {
                    nipDisplay.value = '';
                }
            }
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateLabel));
        return updateLabel;
    }

    const updateLabelUser = setupMultiselect('multiselect-user', 'selected-users-label');
    const updateLabelRole = setupMultiselect('multiselect-role', 'selected-roles-label');

    document.addEventListener('click', () => {
        document.querySelectorAll('.multiselect-dropdown').forEach(d => d.classList.add('d-none'));
    });

    document.getElementById('check-all-users').addEventListener('change', function() {
        document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = this.checked);
        updateLabelUser();
    });

    document.getElementById('check-all-roles').addEventListener('change', function() {
        document.querySelectorAll('.role-checkbox').forEach(cb => cb.checked = this.checked);
        updateLabelRole();
    });

    document.getElementById('add-user-mapping').addEventListener('click', function() {
        const selectedUsers = [];
        document.querySelectorAll('.user-checkbox:checked').forEach(cb => {
            selectedUsers.push({
                username: cb.value,
                nip: cb.getAttribute('data-nip')
            });
        });

        const selectedRoles = [];
        document.querySelectorAll('.role-checkbox:checked').forEach(cb => {
            selectedRoles.push(cb.value);
        });

        if (selectedUsers.length === 0 || selectedRoles.length === 0) {
            return Swal.fire('Error', 'Pilih minimal satu User dan satu Role', 'error');
        }

        fetch('/create-user-mapping', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: JSON.stringify({ users: selectedUsers, roles: selectedRoles })
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
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    }
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