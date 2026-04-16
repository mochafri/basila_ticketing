<style>
    .timeline-compact {
        position: relative;
        padding-left: 25px;
        margin-left: 10px;
    }

    .timeline-compact::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 1px;
        background: #dee2e6;
    }

    .timeline-item-compact {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 4px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: white;
        border: 2px solid #dc3545;
        z-index: 1;
    }

    .timeline-item-compact:last-child {
        margin-bottom: 0;
    }

    .log-meta {
        font-size: 0.65rem;
        letter-spacing: 0.5px;
    }

    .log-title {
        font-size: 0.75rem;
        margin-bottom: 4px;
        display: block;
    }

    .log-msg {
        font-size: 0.75rem;
        color: #6c757d;
        line-height: 1.4;
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 8px;
        margin-top: 5px;
    }
</style>

<div class="card border-0 shadow-sm rounded-4 h-100">
    <div class="card-body p-4">
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
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                    <iconify-icon icon="ph:clock-counter-clockwise" class="text-muted fs-2"></iconify-icon>
                </div>
                <h6 class="fw-bold text-uppercase custom-secondarycolor mb-1" style="font-size: 0.75rem;">Belum Ada Riwayat</h6>
                <p class="text-muted mx-auto mb-0" style="font-size: 0.7rem; max-width: 200px;">Seluruh log aktivitas transaksi akan muncul di sini secara otomatis.</p>
            </div>
        <?php endif; ?>
    </div>
</div>