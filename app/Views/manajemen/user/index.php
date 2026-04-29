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
    <div class="row g-4">

        <!-- ROLE MANAGEMENT -->
        <div class="col-md-6">
            <div class="card master-card p-4 h-100">
                <h5 class="fw-bold mb-4">ROLE MANAGEMENT</h5>

                <div class="d-flex gap-3 mb-4">
                    <input type="text" id="role_name" class="form-control custom-input" placeholder="NAMA ROLE BARU">
                    <button class="btn btn-danger btn-master" id="add-role">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

                <small class="label-list">DAFTAR ROLE AKTIF:</small>

                <div class="list-wrapper mt-3">
                    <?php foreach($roles as $role): ?>
                    <div class="list-item">
                        <div class="d-flex align-items-center gap-3">
                            <span class="dot-red"></span>
                            <span class="fw-semibold text-uppercase"><?= esc($role['role_name']) ?></span>
                            <span class="badge-system">SYSTEM</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


        <!-- USER MANAGEMENT -->
        <div class="col-md-6">
            <div class="card master-card p-4 h-100">

                <h5 class="fw-bold mb-4">USER MANAGEMENT</h5>

                <div class="mb-3">
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

                <div class="mb-3">
                    <input type="text" id="nip" class="form-control custom-input" placeholder="NIP (OTOMATIS)" readonly>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="select-wrapper w-100">
                        <select id="role_id" class="form-select custom-input">
                            <option selected disabled>PILIH ROLE</option>
                            <?php foreach($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= esc($role['role_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <iconify-icon icon="solar:alt-arrow-down-outline" class="select-icon"></iconify-icon>
                    </div>

                    <button class="btn btn-danger btn-master" id="add-user-mapping">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        TAMBAH
                    </button>
                </div>

                <small class="label-list">DAFTAR USER AKTIF:</small>

                <div class="list-wrapper mt-3">
                    <?php foreach($userRoles as $ur): ?>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold"><?= esc($ur['user_fullname']) ?></div>
                            <small class="text-muted"><?= esc($ur['role_name']) ?> (<?= esc($ur['user_nip']) ?>)</small>
                        </div>
                        <iconify-icon icon="mdi:close" class="icon-delete" onclick="deleteMapping(<?= $ur['id'] ?>)"></iconify-icon>
                    </div>
                    <?php endforeach; ?>
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