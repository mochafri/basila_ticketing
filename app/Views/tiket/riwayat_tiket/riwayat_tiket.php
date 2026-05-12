<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-2" id="riwayat-tiket">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
        <div>
            <h2 class="text-uppercase fw-bold m-0">Riwayat Tiket</h2>
            <p class="text-muted small m-0">Daftar seluruh tiket yang telah selesai atau ditolak</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="row mt-4">
        <div class="col-12">
            <form action="<?= site_url('riwayat-tiket') ?>" method="get" class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 bg-white p-3 px-4 rounded-4 border shadow-sm" style="min-height: 80px;">
                
                <!-- Search -->
                <div class="input-group shadow-sm rounded-pill overflow-hidden border bg-light flex-grow-1" style="max-width: 400px; height: 45px;">
                    <span class="input-group-text bg-transparent border-0 pe-1 ps-3">
                        <iconify-icon icon="ph:magnifying-glass-bold" class="text-muted fs-5"></iconify-icon>
                    </span>
                    <input type="text" name="search" class="form-control border-0 bg-transparent ps-2 fw-medium" style="box-shadow: none; font-size: 0.85rem;" placeholder="Cari ID, Judul, Deskripsi..." value="<?= esc($search ?? '') ?>">
                </div>

                <div class="vr opacity-25 d-none d-lg-block mx-2" style="height: 2rem;"></div>

                <!-- Kategori Dropdown -->
                <div style="min-width: 220px;">
                    <select name="kategori" class="form-select border-0 bg-light shadow-sm rounded-pill px-4 fw-bold text-uppercase text-muted" style="height: 45px; font-size: 0.75rem; letter-spacing: 0.5px;">
                        <option value="" <?= empty($filter_kategori) ? 'selected' : '' ?>>SEMUA KATEGORI</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($filter_kategori) && $filter_kategori != '' && $filter_kategori == $cat['id']) ? 'selected' : '' ?>>
                                <?= esc($cat['kategori_layanan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Status Dropdown -->
                <div style="min-width: 200px;">
                    <select name="status" class="form-select border-0 bg-light shadow-sm rounded-pill px-4 fw-bold text-uppercase text-muted" style="height: 45px; font-size: 0.75rem; letter-spacing: 0.5px;">
                        <option value="Closed" <?= ($filter_status == 'Closed') ? 'selected' : '' ?>>SELESAI (CLOSED)</option>
                        <option value="Rejected" <?= ($filter_status == 'Rejected') ? 'selected' : '' ?>>DITOLAK (REJECTED)</option>
                        <option value="All" <?= ($filter_status == 'All') ? 'selected' : '' ?>>SEMUA DATA</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 ms-lg-auto">
                    <button type="submit" class="btn btn-danger shadow-sm rounded-pill px-4 fw-bold text-uppercase d-flex align-items-center gap-2" style="height: 45px; font-size: 0.75rem;">
                        <iconify-icon icon="solar:filter-bold-duotone" class="fs-5"></iconify-icon>
                        Filter
                    </button>
                    <a href="<?= site_url('riwayat-tiket') ?>" class="btn btn-outline-secondary border shadow-sm rounded-pill px-4 fw-bold text-uppercase d-flex align-items-center justify-content-center bg-white" style="height: 45px; font-size: 0.75rem;">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <?php 
                        $role = session('role_name');
                        $isMahasiswa = ($role === 'MAHASISWA');
                    ?>

                    <!-- Desktop & Non-Mahasiswa Mobile View -->
                    <div class="table-responsive <?= $isMahasiswa ? 'd-none d-md-block' : '' ?>">
                        <table class="table table-hover align-middle m-0">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="px-4 py-4 text-uppercase fw-bold text-secondary" style="font-size: 0.75rem; width: 100px;">ID</th>
                                    <th class="px-4 py-4 text-uppercase fw-bold text-secondary" style="font-size: 0.75rem;">Informasi Tiket</th>
                                    <th class="px-4 py-4 text-uppercase fw-bold text-secondary" style="font-size: 0.75rem;">Kategori</th>
                                    <th class="px-4 py-4 text-uppercase fw-bold text-secondary" style="font-size: 0.75rem;">Waktu</th>
                                    <th class="px-4 py-4 text-uppercase fw-bold text-secondary" style="font-size: 0.75rem;">Status</th>
                                    <th class="px-4 py-4 text-uppercase fw-bold text-secondary text-center" style="font-size: 0.75rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tiket['data'])): ?>
                                    <?php 
                                        // Menghitung nomor urut awal berdasarkan halaman saat ini
                                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $perPage = 10; // Sesuai dengan paginate(10) di Service
                                        $no = ($currentPage - 1) * $perPage + 1;
                                    ?>
                                    <?php foreach ($tiket['data'] as $row): ?>
                                        <tr style="transition: all 0.2s;">
                                            <td class="px-4 py-3 fw-bold text-muted"><?= $no++ ?>.</td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark text-truncate" style="max-width: 350px; font-size: 0.95rem;">
                                                        <?= esc($row['deskripsi_permohonan']) ?>
                                                    </span>
                                                    <div class="d-flex align-items-center gap-2 mt-1">
                                                        <iconify-icon icon="solar:user-bold-duotone" class="text-muted" style="font-size: 14px;"></iconify-icon>
                                                        <span class="text-muted fw-medium" style="font-size: 0.75rem;"><?= esc($row['nama_creator']) ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-soft-danger text-danger text-uppercase px-3 py-2 rounded-pill fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                                    <?= esc($row['kategori_layanan']) ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-semibold" style="font-size: 0.85rem;"><?= date('d M Y', strtotime($row['created_at'])) ?></span>
                                                    <span class="text-muted" style="font-size: 0.75rem;"><?= date('H:i', strtotime($row['created_at'])) ?> WIB</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <?php if ($row['tiket_status'] === 'Closed'): ?>
                                                    <div class="d-flex align-items-center gap-2 text-success fw-bold" style="font-size: 0.8rem;">
                                                        <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-5"></iconify-icon>
                                                        <span>SELESAI</span>
                                                    </div>
                                                <?php elseif ($row['tiket_status'] === 'Rejected'): ?>
                                                    <div class="d-flex align-items-center gap-2 text-danger fw-bold" style="font-size: 0.8rem;">
                                                        <iconify-icon icon="solar:close-circle-bold-duotone" class="fs-5"></iconify-icon>
                                                        <span>DITOLAK</span>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary text-white px-3 py-2 rounded-pill"><?= strtoupper($row['tiket_status']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="<?= site_url('tiket/' . $row['id']) ?>" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-uppercase d-inline-flex align-items-center gap-1" style="font-size: 0.7rem; transition: all 0.2s;">
                                                    <iconify-icon icon="solar:eye-bold-duotone" class="fs-6"></iconify-icon>
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($isMahasiswa): ?>
                        <!-- Mobile Card View (Hanya Mahasiswa) -->
                        <div class="d-md-none p-3">
                            <?php if (!empty($tiket['data'])): ?>
                                <?php foreach ($tiket['data'] as $row): ?>
                                    <div class="card border-0 shadow-sm rounded-4 mb-3 p-3 position-relative overflow-hidden">
                                        <div class="position-absolute top-0 start-0 h-100 bg-<?= $row['tiket_status'] === 'Closed' ? 'success' : ($row['tiket_status'] === 'Rejected' ? 'danger' : 'secondary') ?>" style="width: 4px; opacity: 0.6;"></div>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-soft-danger text-danger text-uppercase px-2 py-1 rounded-pill fw-bold" style="font-size: 0.6rem;">
                                                <?= esc($row['kategori_layanan']) ?>
                                            </span>
                                            <span class="text-muted" style="font-size: 0.7rem;"><?= date('d/m/y H:i', strtotime($row['created_at'])) ?></span>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem; line-height: 1.4;">
                                            <?= esc($row['deskripsi_permohonan']) ?>
                                        </h6>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <iconify-icon icon="solar:user-bold-duotone" class="text-muted" style="font-size: 14px;"></iconify-icon>
                                            <span class="text-muted" style="font-size: 0.75rem;"><?= esc($row['nama_creator']) ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                            <?php if ($row['tiket_status'] === 'Closed'): ?>
                                                <span class="text-success fw-bold small">SELESAI</span>
                                            <?php elseif ($row['tiket_status'] === 'Rejected'): ?>
                                                <span class="text-danger fw-bold small">DITOLAK</span>
                                            <?php else: ?>
                                                <span class="text-secondary fw-bold small"><?= strtoupper($row['tiket_status']) ?></span>
                                            <?php endif; ?>
                                            <a href="<?= site_url('tiket/' . $row['id']) ?>" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold text-uppercase" style="font-size: 0.65rem;">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($tiket['data'])): ?>
                        <div class="text-center py-5">
                            <div class="py-4">
                                <iconify-icon icon="solar:box-minimalistic-linear" class="text-muted mb-3" style="font-size: 60px;"></iconify-icon>
                                <h5 class="text-muted fw-bold">Tidak ada riwayat ditemukan</h5>
                                <p class="text-muted small">Coba ubah filter atau kata kunci pencarian Anda.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pagination -->
            <?php if (!empty($tiket['data'])): ?>
                <div class="mt-4 d-flex justify-content-between align-items-center bg-white p-3 rounded-4 border shadow-sm px-4">
                    <span class="text-muted small fw-medium">Menampilkan <?= count($tiket['data']) ?> data tiket</span>
                    <div class="custom-pagination">
                        <?= $tiket['pager']->links() ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .bg-soft-danger {
        background-color: rgba(220, 53, 69, 0.08);
    }
    
    .table tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.02);
        transform: translateY(-1px);
    }

    .btn-light:hover {
        background-color: var(--bs-danger) !important;
        color: white !important;
        border-color: var(--bs-danger) !important;
    }

    /* Custom Pagination Styling Overrides */
    .custom-pagination ul {
        margin: 0;
        padding: 0;
        display: flex;
        gap: 5px;
    }
    
    .custom-pagination li {
        list-style: none;
    }
    
    .custom-pagination a, .custom-pagination span {
        padding: 8px 14px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--bs-secondary);
        transition: all 0.2s;
    }
    
    .custom-pagination li.active span {
        background-color: var(--bs-danger);
        color: white;
    }
    
    .custom-pagination a:hover {
        background-color: #f8f9fa;
        color: var(--bs-danger);
    }
</style>
<?= $this->endSection(); ?>
