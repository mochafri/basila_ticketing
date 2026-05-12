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
        <!-- Status Alur Diganti Jadi Chart -->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Distribusi Jenis Layanan</h5>
                        <small class="text-muted">
                            Statistik pengajuan berdasarkan jenis layanan
                        </small>
                    </div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-12 <?= (session('role_name') !== 'MAHASISWA') ? 'col-md-4' : 'col-md-12' ?>">
                        <select id="filterKategori" class="form-select form-select-sm w-100">
                            <option value="">Semua Kategori</option>
                            <?php foreach($kategoris ?? [] as $kat): ?>
                                <option value="<?= $kat['id'] ?>"><?= esc($kat['kategori_layanan']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if (session('role_name') !== 'MAHASISWA'): ?>
                    <div class="col-12 col-md-4">
                        <select id="filterFakultas" class="form-select form-select-sm w-100">
                            <option value="">Semua Fakultas</option>
                            <?php foreach($fakultas ?? [] as $f): ?>
                                <option value="<?= esc($f) ?>"><?= esc($f) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <select id="filterProdi" class="form-select form-select-sm w-100">
                            <option value="">Semua Prodi</option>
                            <?php foreach($prodis ?? [] as $p): ?>
                                <option value="<?= esc($p) ?>"><?= esc($p) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="chart-wrapper" style="position: relative; height: 300px; width: 100%; transition: max-width 0.4s ease;">
                    <canvas id="layananChart"></canvas>
                </div>
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

    <!-- Script for Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('layananChart').getContext('2d');
            let layananChart;

            function loadChartData() {
                const kategori = document.getElementById('filterKategori') ? document.getElementById('filterKategori').value : '';
                const fakultas = document.getElementById('filterFakultas') ? document.getElementById('filterFakultas').value : '';
                const prodi = document.getElementById('filterProdi') ? document.getElementById('filterProdi').value : '';

                const url = new URL('<?= base_url('dashboard/chart-data') ?>');
                if (kategori) url.searchParams.append('kategori', kategori);
                if (fakultas) url.searchParams.append('fakultas', fakultas);
                if (prodi) url.searchParams.append('prodi', prodi);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const chartWrapper = document.querySelector('.chart-wrapper');
                        chartWrapper.style.maxWidth = '100%'; // Always full width

                        if (layananChart) {
                            layananChart.destroy();
                        }

                        // Original data
                        let labels = [...data.labels]; // Clone to avoid mutation issues
                        let realData = [...data.data];
                        let details = data.details ? [...data.details] : [];

                        // Conditional Clump vs Distributed
                        const dataCount = labels.length;
                        let barThickness = 40; // Standardize to 40px

                        if (dataCount > 0 && dataCount <= 4) {
                            // Case: Mepet ke kiri (Grouped)
                            const minSlots = 7; 
                            const diff = minSlots - dataCount;
                            for (let i = 0; i < diff; i++) {
                                labels.push(""); 
                                realData.push(null);
                                if (details) details.push(null);
                            }
                        }
                        
                        // Process data for visual tiny bars (only for non-null values)
                        const processedData = realData.map(v => v === 0 ? 0.05 : v);

                        // Create gradient for bars
                        let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(220, 53, 69, 0.85)'); // Red danger color
                        gradient.addColorStop(1, 'rgba(220, 53, 69, 0.15)');

                        layananChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Pengajuan',
                                    data: processedData,
                                    backgroundColor: gradient,
                                    borderColor: 'rgba(220, 53, 69, 1)',
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    barThickness: barThickness, 
                                    details: details,
                                    realValues: realData 
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                animation: {
                                    duration: 1200,
                                    easing: 'easeOutQuart'
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        titleColor: '#f8fafc',
                                        bodyColor: '#cbd5e1',
                                        padding: 12,
                                        cornerRadius: 8,
                                        titleFont: { size: 14, weight: 'bold' },
                                        bodyFont: { size: 12 },
                                        displayColors: false,
                                        callbacks: {
                                            title: function(tooltipItems) {
                                                return tooltipItems[0].label;
                                            },
                                            label: function(context) {
                                                const realValue = context.dataset.realValues[context.dataIndex];
                                                const details = context.dataset.details ? context.dataset.details[context.dataIndex] : null;
                                                
                                                let label = [realValue + ' Tiket Pengajuan'];
                                                
                                                if (details && details.length > 0) {
                                                    label.push(''); 
                                                    label.push('Detail Layanan:');
                                                    details.forEach(d => {
                                                        label.push('• ' + d);
                                                    });
                                                }
                                                
                                                return label;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        border: { display: false },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)',
                                            borderDash: [5, 5]
                                        },
                                        ticks: {
                                            stepSize: 1,
                                            color: '#64748b',
                                            padding: 10,
                                            callback: function(value) {
                                                if (Math.floor(value) === value) {
                                                    return value;
                                                }
                                            }
                                        }
                                    },
                                    x: {
                                        border: { display: false },
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: '#64748b',
                                            padding: 10,
                                            maxRotation: 45,
                                            minRotation: 45,
                                            autoSkip: false,
                                            callback: function(value) {
                                                let label = this.getLabelForValue(value);
                                                if (label.length > 15) {
                                                    return label.substring(0, 15) + '...';
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching chart data:', error));
            }

            // Load initial data
            loadChartData();

            // Add event listeners to filters
            if (document.getElementById('filterKategori')) {
                document.getElementById('filterKategori').addEventListener('change', loadChartData);
            }
            if (document.getElementById('filterFakultas')) {
                document.getElementById('filterFakultas').addEventListener('change', loadChartData);
            }
            if (document.getElementById('filterProdi')) {
                document.getElementById('filterProdi').addEventListener('change', loadChartData);
            }
        });
    </script>

    <?= $this->endSection(); ?>