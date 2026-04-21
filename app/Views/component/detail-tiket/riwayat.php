

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
                            <span class="text-danger fw-bold text-uppercase log-meta"><?= esc($r['created_by']) ?></span>
                            <span class="text-muted log-meta"><?= date('d M, H:i', strtotime($r['created_at'])) ?></span>
                        </div>
                        <span class="fw-bold text-uppercase log-title"><?= esc($r['activity_title']) ?></span>
                        <div class="log-msg">
                            <?= esc($r['message']) ?>
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