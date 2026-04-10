<div class="d-flex gap-3 w-100">
    <iconify-icon icon="ic:round-check" class="text-white btn btn-danger h-25"></iconify-icon>
    <div class="flex-grow-1">
        <p class="m-0 fw-bold mb-2 custom-small-font">approval kepala urusan (bu fira)</p>
        <div class="p-4 bg-light rounded-3 w-100 d-flex gap-3 flex-column shadow-md border">
            <p class="m-0 fw-medium custom-text">Pilih delegasi kepala bagian</p>
            <div class="d-flex gap-2 flex-wrap">
                <?php if (!empty($kaur)): ?>
                    <?php foreach ($kaur as $kr): ?>
                        <label class="flex-fill p-4 bg-white d-flex justify-content-between align-items-center rounded-3 shadow-sm" style="cursor: pointer;">
                            <span class="text-uppercase fw-bold"><?= esc($kr['nama_kaur']); ?></span>
                            <input type="checkbox" name="kaur_id[]" value="<?= esc($kr['nip_kaur']); ?>"
                                data-name="<?= esc($kr['nama_kaur']); ?>"
                                class="form-check-input kabag-checkbox mb-0"
                                style="width: 1.25rem; height: 1.25rem;">
                        </label>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0 w-100">Data delegasi kepala urusan tidak tersedia.</p>
                <?php endif; ?>
            </div>
            <div class="d-flex gap-2 flex-wrap mt-4">
                <button type="button" class="btn btn-approve btn-success flex-fill p-4 text-uppercase fw-bold rounded-4">setujui
                    &
                    tugaskan</button>
                <button type="button"
                    class="btn btn-escalated btn-primary flex-fill p-4 text-uppercase fw-bold rounded-4">eskalasi</button>
                <button
                    class="btn btn-reject btn-danger flex-fill p-4 text-uppercase fw-bold rounded-4">tolak</button>
            </div>
        </div>
    </div>
</div>
<div class="d-flex align-items-center gap-3">
    <iconify-icon icon="ic:round-check" class="text-white btn btn-success "></iconify-icon>
    <p class="m-0 fw-bold custom-small-font">approval kepala urusan (bu fira)</p>
</div>
<div class="d-flex align-items-center gap-3">
    <iconify-icon icon="hugeicons:task-done-01" class="text-white btn btn-success "></iconify-icon>
    <p class="m-0 fw-bold custom-small-font">penugasan :
        <span id="penugasan-list" class="text-secondary fw-normal fst-italic">Belum ada pilihan</span>
    </p>
</div>

<div class="d-flex align-items-center gap-3">
    <iconify-icon icon="ph:flow-arrow" class="text-white btn btn-danger "></iconify-icon>
    <div class="flex-grow-1 gap-2 d-flex flex-column">
        <p class="m-0 fw-bold custom-small-font">konfirmasi penyelesaian</p>
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-tutup-tiket btn-success flex-fill text-uppercase fw-bold rounded-3 custom-small-font py-3 px-4">tutup
                tiket (selesai)</button>
            <button class="btn btn-danger flex-fill text-uppercase fw-bold rounded-3 custom-small-font py-3 px-4">tolak
                hasil akhir</button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.kabag-checkbox');
        const penugasanList = document.getElementById('penugasan-list');

        function updatePenugasan() {
            const selected = [];
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selected.push(cb.getAttribute('data-name').toUpperCase());
                }
            });

            if (selected.length > 0) {
                penugasanList.textContent = selected.join(', ');
                penugasanList.classList.remove('text-secondary', 'fw-normal');
            } else {
                penugasanList.textContent = 'Belum ada pilihan';
                penugasanList.classList.add('text-secondary', 'fw-normal');
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updatePenugasan);
        });
    });
</script>