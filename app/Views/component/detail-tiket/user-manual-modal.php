<?php
$role = trim(session('role_name'));
$manualContent = [
    'MAHASISWA' => '
        <div class="manual-section">
            <span class="manual-subheading">1. Pengajuan & Pemantauan</span>
            <p class="manual-text">Isi formulir dengan benar, lalu pantau status melalui timeline. Hijau = Selesai, Kuning = Proses, Merah = Kendala.</p>
        </div>
        <div class="manual-section">
            <span class="manual-subheading">2. Konfirmasi</span>
            <p class="manual-text">Wajib klik konfirmasi setelah tugas selesai agar tiket dapat ditutup secara resmi.</p>
        </div>',
    'KEPALA URUSAN ADMINISTRASI AKADEMIK' => '
        <div class="manual-section">
            <span class="manual-subheading">1. Delegasi Tugas</span>
            <p class="manual-text">Pilih staf yang kompeten dan berikan instruksi jelas pada kolom catatan penugasan.</p>
        </div>
        <div class="manual-section">
            <span class="manual-subheading">2. Verifikasi</span>
            <p class="manual-text">Periksa hasil kerja staf. Gunakan tombol "Revisi" jika belum sesuai, atau "Verifikasi" jika sudah benar.</p>
        </div>',
    'SUPERADMIN' => '
        <div class="manual-section">
            <span class="manual-subheading">1. Distribusi</span>
            <p class="manual-text">Tinjau tiket baru dan arahkan ke Kepala Urusan (KAUR) yang tepat sesuai kategori layanan.</p>
        </div>
        <div class="manual-section">
            <span class="manual-subheading">2. Penutupan</span>
            <p class="manual-text">Tiket dapat ditutup (Closed) setelah proses konfirmasi penyelesaian divalidasi oleh mahasiswa.</p>
        </div>',
    'BAA' => '
        <div class="manual-section">
            <span class="manual-subheading">1. Eskalasi</span>
            <p class="manual-text">Setujui atau tolak permintaan eskalasi yang diajukan oleh unit kerja di bawah koordinasi Anda.</p>
        </div>
        <div class="manual-section">
            <span class="manual-subheading">2. Monitoring</span>
            <p class="manual-text">Pantau agar tidak ada tiket yang tertahan lama di tahap eskalasi untuk menjaga kualitas layanan.</p>
        </div>',
    'PEGAWAI' => '
        <div class="manual-section">
            <span class="manual-subheading">1. Pengerjaan</span>
            <p class="manual-text">Baca instruksi KAUR dengan teliti dan kerjakan tugas sesuai dengan poin yang diminta.</p>
        </div>
        <div class="manual-section">
            <span class="manual-subheading">2. Laporan</span>
            <p class="manual-text">Wajib unggah file bukti dan klik "Selesaikan Tugas" agar pekerjaan Anda dapat diverifikasi oleh KAUR.</p>
        </div>',
    'ADMIN AKADEMIK' => '
        <div class="manual-section">
            <span class="manual-subheading">1. Validasi Data</span>
            <p class="manual-text">Pastikan integritas data akademik mahasiswa sudah valid sebelum tiket diproses lebih lanjut.</p>
        </div>
        <div class="manual-section">
            <span class="manual-subheading">2. Support</span>
            <p class="manual-text">Bantu KAUR dalam penyiapan berkas administrasi dan koordinasi data yang diperlukan.</p>
        </div>',
];

$currentManual = $manualContent[$role] ?? '<p class="text-danger no-transform">Panduan untuk role <b>' . esc($role) . '</b> belum tersedia. Silakan hubungi administrator.</p>';
?>

<div class="modal fade user-manual-modal" id="userManualModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <iconify-icon icon="mdi:book-open-variant" class="align-middle me-2"></iconify-icon>
                    User Manual - <?= esc($role) ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="manual-container">
                    <h6 class="manual-heading">Panduan Kerja:</h6>
                        <?= $currentManual ?>

                        <div class="manual-section border-top pt-3 mt-3">
                            <span class="manual-subheading text-uppercase small fw-bold">Keterangan Warna Alur Kerja:</span>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 12px; height: 12px; border-radius: 50%;" class="bg-success"></div>
                                    <span class="manual-text m-0">Hijau = Selesai</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 12px; height: 12px; border-radius: 50%;" class="bg-danger"></div>
                                    <span class="manual-text m-0">Merah = Sedang dikerjakan</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 12px; height: 12px; border-radius: 50%;" class="bg-secondary"></div>
                                    <span class="manual-text m-0">Abu-abu = Menunggu tahap sebelumnya</span>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup Panduan</button>
            </div>
        </div>
    </div>
</div>
