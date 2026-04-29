<?php 
    $roleName  = $roleName ?? session('role_name');
    $loginUser = $loginUser ?? strtolower(session('login_username') ?? '');
    $userId    = $userId ?? session('user_identifier');
    $isAdmin   = $isAdmin ?? ($roleName === 'SUPERADMIN' || $loginUser === 'admin' || $userId === '000000');
    $isReadOnly = $isReadOnly ?? ($loginUser === 'admin' && $roleName !== 'SUPERADMIN');
?>
<div class="card border-0">
    <div class="card-body p-5 d-flex flex-column gap-4 text-uppercase">
        <div class="d-flex align-items-center gap-3">
            <iconify-icon icon="material-symbols:timeline" class="text-danger fs-2"></iconify-icon>
            <h5 class="fw-bold m-0">Timeline & alur kerja</h5>
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#userManualModal" class="d-flex align-items-center text-decoration-none">
                <iconify-icon icon="mdi:information" class="text-primary fs-4"></iconify-icon>
            </a>
        </div>
        <?php $step = 1; ?>
        <!-- 1. Pembuatan Tiket (Selalu Muncul) -->
        <?= $this->include('component/detail-tiket/ticket_created', ['step' => $step++]); ?>

        <!-- 2. Eskalasi (Jika ada eskalasi atau user adalah admin) -->
        <?php if ($isAdmin || $detail['is_escalated'] || $detail['tiket_status'] === 'Escalated Process'): ?>
            <?= $this->include('component/detail-tiket/approval_eskalasi', [
                'step' => $step++,
                'hideContext' => $isAdmin
            ]); ?>
        <?php endif; ?>

        <!-- 3. Approval Kabag / BAA (Jika user admin/BAA atau sudah melewati tahap ini) -->
        <?php if ($isAdmin || $roleName === 'BAA'): ?>
            <?= $this->include('component/detail-tiket/approval_kabag', [
                'step' => $step,
                'hideContext' => $isAdmin
            ]); ?>
            <?php $step += 3; ?>
        <?php endif; ?>

        <!-- 4. Approval & Penugasan Kaur (Jika user admin/Kaur atau sudah di-assign) -->
        <?php if ($isAdmin || $roleName === 'KEPALA URUSAN ADMINISTRASI AKADEMIK' || !empty($kaurByTiketOpen)): ?>
            <?= $this->include('component/detail-tiket/approval_kaur', [
                'step' => $step,
                'hideContext' => $isAdmin
            ]); ?>
            <?php $step += 3; ?>
        <?php endif; ?>

        <!-- 5. Pengerjaan Staff (Jika user admin/Staff atau sudah ada task) -->
        <?php if ($isAdmin || in_array($roleName, ['PEGAWAI', 'ADMIN AKADEMIK']) || !empty($taskStaff) || !empty($allTaskStaffOnKaur)): ?>
            <?= $this->include('component/detail-tiket/submission_staff', [
                'step' => $step,
                'hideContext' => $isAdmin
            ]); ?>
            <?php $step += 2; ?>
        <?php endif; ?>

        <!-- 6. Tampilan untuk Mahasiswa (Hanya ringkasan status) -->
        <?php if ($roleName === "MAHASISWA"): ?>
            <?= $this->include('component/detail-tiket/submission_mahasiswa', [
                'step' => $step++,
                'allTaskStaffOnKaur' => $allTaskStaffOnKaur ?? []
            ]); ?>
        <?php endif; ?>
    </div>
</div>


