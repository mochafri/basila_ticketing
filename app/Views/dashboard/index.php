<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4 px-4 dashboard-wrapper">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold title-dashboard">Dashboard Utama</h2>
            <span class="text-muted subtitle-dashboard">
                Monitoring performa layanan dan progres tugas tim Anda.
            </span>
        </div>

        <div class="d-flex align-items-center gap-3 w-50">
            <?php
                $currentMonth = intval(date('n'));
                $currentYear = intval(date('Y'));

                if ($currentMonth >= 2 && $currentMonth <= 7) {
                    $y = $currentYear;
                    $semester = 'Genap';
                } else {
                    $y = ($currentMonth == 1) ? $currentYear - 1 : $currentYear;
                    $semester = 'Ganjil';
                }

                $currentPeriodeKey = "$y - $semester";

                if ($semester == 'Genap') {
                    $y++; 
                } else {
                    $y++; 
                }

                $periode = [];
                for ($i = 0; $i < 5; $i++) {
                    if ($semester == 'Genap') {
                        $key = "$y - Genap";
                        $val = "Semester Genap " . ($y - 1) . "/" . $y;
                        $periode[$key] = $val;
                        $semester = 'Ganjil';
                        $y--;
                    } else {
                        $key = "$y - Ganjil";
                        $val = "Semester Ganjil " . $y . "/" . ($y + 1);
                        $periode[$key] = $val;
                        $semester = 'Genap';
                    }
                }

                $opt = ['' => 'Pilih Periode'] + $periode;
            ?>
            
            <select class="form-select semester-select">
                <?php foreach ($opt as $k => $v): ?>
                    <option value="<?= $k ?>" <?= $k == $currentPeriodeKey ? 'selected' : '' ?>><?= $v ?></option>
                <?php endforeach; ?>
            </select>

            <button class="btn btn-danger btn-set-periode w-50">
                <iconify-icon icon="arcticons:ready-for"></iconify-icon>
                Set Periode
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
                    <small>Total Tiket</small>
                </div>
                <h1><?= $totalTiket ?? 0 ?></h1>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-warning-custom stat-card-progress px-3">
                <div class="progress-left">
                    <div class="icon-box bg-light-warning">
                        <iconify-icon icon="mdi:clock-outline"></iconify-icon>
                    </div>
                    <small>Dalam Proses</small>
                </div>
                <div class="progress-center">
                    <div class="progress-row">
                        <span>Open</span>
                        <strong><?= $onOpen ?? 0 ?></strong>
                    </div>
                    <div class="progress-row">
                        <span>Waiting</span>
                        <strong><?= $onWaiting ?? 0 ?></strong>
                    </div>
                    <div class="progress-row">
                        <span>Progress</span>
                        <strong><?= $onProgress ?? 0 ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-success-custom">
                <div>
                    <div class="icon-box bg-light-success">
                        <iconify-icon icon="mdi:check-circle-outline"></iconify-icon>
                    </div>
                    <small>Tiket Selesai</small>
                </div>
                <h1><?= $closedTiket ?? 0 ?></h1>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg-blue-custom">
                <div>
                    <div class="icon-box bg-light-dark">
                        <iconify-icon icon="mdi:close-circle-outline"></iconify-icon>
                    </div>
                    <small>Tiket Ditolak</small>
                </div>
                <h1><?= $rejectTiket ?? 0 ?></h1>
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
                        <h5 class="fw-bold mb-1">Status Alur Kerja</h5>
                        <small class="text-muted">
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
                    Lihat Daftar Tugas
                </button>
            </div>
        </div>

        <!-- Rangkuman Per Kategori-->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-1">Rangkuman Per Kategori</h5>
                <small class="text-muted">
                    Distribusi Layanan Akademik
                </small>

                <?php
                $gradients = ['bg-gradient-danger', 'bg-gradient-primary', 'bg-gradient-success', 'bg-gradient-warning', 'bg-gradient-info', 'bg-gradient-purple'];
                $i = 0;
                foreach ($totalTIketPerKategori as $kat):
                    $percent = min(($kat['total'] / 100) * 100, 100);
                    $gradientClass = $gradients[$i % count($gradients)];
                ?>
                    <div class="mt-4">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold small">
                                    <?= $kat['kategori'] ?>
                                </span>
                                <span class="small text-muted"><?= $kat['total'] ?> Tiket</span>
                            </div>
                            <div class="progress mt-2 progress-custom">
                                <div class="progress-bar <?= $gradientClass ?>" style="width:<?= $percent ?>%"></div>
                            </div>
                        </div>
                    </div>
                <?php
                    $i++;
                endforeach;
                ?>
                <!-- Lainnya -->
                <?php if (empty($totalTIketPerKategori)): ?>
                    <div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold small">
                                Lainnya
                            </span>
                            <span class="small text-muted">0 Tiket</span>
                        </div>
                        <div class="progress mt-2 progress-custom">
                            <div class="progress-bar bg-secondary" style="width:0%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?= $this->endSection(); ?>