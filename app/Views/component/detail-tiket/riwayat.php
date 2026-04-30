

<div class="card border-0 shadow-sm rounded-4 h-100">
    <div class="card-body p-4 d-flex flex-column">
        <div class="d-flex align-items-center gap-2 mb-4">
            <iconify-icon icon="ph:list-bullets-bold" class="text-danger fs-5"></iconify-icon>
            <span class="fw-bold text-uppercase custom-small-font" style="letter-spacing: 1px;">Log Aktifitas</span>
        </div>

        <?php if (!empty($riwayat)): ?>
            <div class="timeline-compact">
                <?php foreach ($riwayat as $r): ?>
                    <div class="timeline-item-compact">
                        <div class="timeline-marker"></div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-danger fw-bold text-uppercase log-meta" style="font-size: 0.6rem;"><?= esc($r['created_by']) ?></span>
                            <span class="text-muted log-meta" style="font-size: 0.6rem;" title="<?= format_datetime_indo($r['created_at']) ?>"><?= time_ago($r['created_at']) ?></span>
                        </div>
                        <span class="fw-bold text-uppercase log-title" style="font-size: 0.7rem;"><?= esc($r['activity_title']) ?></span>
                        <div class="log-msg" style="font-size: 0.7rem;">
                            <?= esc($r['message']) ?>
                            <?php 
                                $isMahasiswa = session('role_name') === 'MAHASISWA';
                                $isCreator = session('user_identifier') === ($detail['nip_creator'] ?? '');
                                $isInternal = in_array(session('role_name'), ['SUPERADMIN', 'BAA', 'KEPALA URUSAN ADMINISTRASI AKADEMIK', 'PEGAWAI', 'ADMIN AKADEMIK']);
                                
                                // Sembunyikan jika MAHASISWA, atau jika dia Pemohon (kecuali dia Admin)
                                $showAttachment = !empty($r['attachment']) && (!$isMahasiswa && !($isCreator && !$isInternal));
                            ?>
                            <?php if ($showAttachment): ?>
                                <div class="mt-2">
                                    <a href="<?= base_url('tiket/file/admin/' . $r['attachment']) ?>" target="_blank" class="text-danger text-decoration-none d-flex align-items-center gap-1 fw-bold" style="font-size: 0.65rem;">
                                        <iconify-icon icon="ph:paperclip-bold"></iconify-icon>
                                        <?= esc($r['original_attachment_name'] ?? 'Lihat Lampiran') ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center py-5">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <iconify-icon icon="ph:clock-counter-clockwise" class="text-muted fs-2"></iconify-icon>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <h6 class="fw-bold text-uppercase custom-secondarycolor mb-1" style="font-size: 0.75rem;">Belum Ada Riwayat</h6>
                    <p class="text-muted mx-auto mb-0" style="font-size: 0.7rem; max-width: 200px;">Seluruh log aktivitas transaksi akan muncul di sini secara otomatis.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>