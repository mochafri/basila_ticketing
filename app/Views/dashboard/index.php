<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4 px-4 dashboard-wrapper">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold title-dashboard">DASHBOARD UTAMA</h2>
            <span class="text-muted subtitle-dashboard">
                Monitoring performa layanan dan progres tugas tim Anda.
            </span>
        </div>

        <div class="d-flex align-items-center gap-3">
            <select class="form-select semester-select">
                <option>SEMESTER GANJIL 2024</option>
            </select>

            <button class="btn btn-danger btn-set-periode">
                <iconify-icon icon="arcticons:ready-for"></iconify-icon>
                SET PERIODE
            </button>
        </div>
    </div>

    <!-- Card -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card bg-danger-custom">
                <div>
                    <div class="icon-box bg-light-danger">
                        <iconify-icon icon="mdi:layers-outline"></iconify-icon>
                    </div>
                    <small>TOTAL TIKET</small>
                </div>
                <h1>1</h1>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-progress bg-warning-custom">

                <div class="progress-left">
                    <div class="icon-box bg-light-warning">
                        <iconify-icon icon="mdi:clock-outline"></iconify-icon>
                    </div>
                    <select name="status" id="status" class="bg-transparent border-0 text-white text-uppercase custom-small-font shadow-sm py-2 px-1" style="letter-spacing: 0.15rem;">
                        <option value="waiting" class="text-dark">Waiting</option>
                        <option value="open" class="text-dark">Open</option>
                        <option value="in_progress" class="text-dark">In Progress</option>
                    </select>
                </div>
                <h1><?= $onProgress ?></h1>

                <div class="progress-center">
                    <div class="progress-row">
                        <span>Open</span>
                        <strong>0</strong>
                    </div>
                    <div class="progress-row">
                        <span>Waiting</span>
                        <strong>0</strong>
                    </div>
                    <div class="progress-row">
                        <span>Progress</span>
                        <strong></strong>
                    </div>
                </div>

                <div class="progress-total">
                    <h1>0</h1>
                </div>

            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-success-custom">
                <div>
                    <div class="icon-box bg-light-success">
                        <iconify-icon icon="mdi:check-circle-outline"></iconify-icon>
                    </div>
                    <small>TIKET SELESAI</small>
                </div>
                <h1>0</h1>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-blue-custom">
                <div>
                    <div class="icon-box bg-light-dark">
                        <iconify-icon icon="mdi:close-circle-outline"></iconify-icon>
                    </div>
                    <small>TIKET DITOLAK</small>
                </div>
                <h1>0</h1>
            </div>
        </div>
    </div>

    <!-- Status & Rangkuman -->
    <div class="row g-4">
        <!-- Status Alur -->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">STATUS ALUR KERJA</h5>
                        <small class="text-muted text-uppercase">
                            Visualisasi progres real-time
                        </small>
                    </div>
                </div>

                <!-- Workflow -->
                <div class="workflow-wrapper text-center">

                    <div class="workflow-line"></div>

                    <div class="workflow-item">
                        <div class="workflow-step bg-danger">
                            <iconify-icon icon="mdi:plus"></iconify-icon>
                        </div>
                        <div class="workflow-label">Request</div>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-step bg-warning-custom">
                            <iconify-icon icon="mdi:check"></iconify-icon>
                        </div>
                        <div class="workflow-label">Approve</div>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-step bg-blue-custom">
                            <iconify-icon icon="mdi:briefcase-outline"></iconify-icon>
                        </div>
                        <div class="workflow-label">Task 1</div>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-step bg-purple">
                            <iconify-icon icon="mdi:briefcase-outline"></iconify-icon>
                        </div>
                        <div class="workflow-label">Task 2</div>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-step bg-success-custom">
                            <iconify-icon icon="mdi:check-circle-outline"></iconify-icon>
                        </div>
                        <div class="workflow-label">Done</div>
                    </div>

                </div>

                <button class="btn btn-lihat w-100 mt-4">
                    LIHAT DAFTAR TUGAS
                </button>
            </div>
        </div>

        <!-- Rangkuman Per Kategori-->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-1">RANGKUMAN PER KATEGORI</h5>
                <small class="text-muted text-uppercase">
                    Distribusi Layanan Akademik
                </small>

                <div class="mt-4">

                    <!-- Registrasi -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold text-uppercase small">
                                Layanan Registrasi
                            </span>
                            <span class="small text-muted">1 Tiket</span>
                        </div>
                        <div class="progress mt-2 progress-custom">
                            <div class="progress-bar bg-danger" style="width:100%"></div>
                        </div>
                    </div>

                    <!-- Akademik -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold text-uppercase small">
                                Layanan Akademik
                            </span>
                            <span class="small text-muted">0 Tiket</span>
                        </div>
                        <div class="progress mt-2 progress-custom">
                            <div class="progress-bar bg-secondary" style="width:0%"></div>
                        </div>
                    </div>

                    <!-- Keuangan -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold text-uppercase small">
                                Layanan Keuangan
                            </span>
                            <span class="small text-muted">0 Tiket</span>
                        </div>
                        <div class="progress mt-2 progress-custom">
                            <div class="progress-bar bg-secondary" style="width:0%"></div>
                        </div>
                    </div>

                    <!-- Lainnya -->
                    <div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold text-uppercase small">
                                Lainnya
                            </span>
                            <span class="small text-muted">0 Tiket</span>
                        </div>
                        <div class="progress mt-2 progress-custom">
                            <div class="progress-bar bg-secondary" style="width:0%"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?= $this->endSection(); ?>