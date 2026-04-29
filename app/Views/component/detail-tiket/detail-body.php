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
        <!-- status 1 -->
        <?= $this->include('component/detail-tiket/ticket_created', ['step' => $step++]); ?>
        <!-- status 2 -->
        <?php if (session('role_name') === 'BAA'):  ?>
        <?= $this->include('component/detail-tiket/approval_eskalasi', [
            'kaur' => $kaur,
            'detail' => $detail,
            'kaurByTiketOpen' => $kaurByTiketOpen,
            'step' => $step++
        ]); ?>
        <?php endif; ?>
        <!-- <p>-------------------------------komponen bu fira (approval_kabag.php)--------------------------</p> -->
        <?php if (session('role_name') === 'SUPERADMIN'): ?>
            <?= $this->include('component/detail-tiket/approval_kabag', [
                'kaur' => $kaur,
                'detail' => $detail,
                'kaurByTiketOpen' => $kaurByTiketOpen,
                'allTaskStaffOnKaur' => $allTaskStaffOnKaur,
                'step' => $step
            ]); ?>
            <?php $step += 3; ?>
        <?php endif; ?>
        <!-- <p>-------------------------------end komponen bu fira-----------</p> -->
        <!-- status 3 -->
        <!-- <p>-------------------------------komponen pak bagas/bu farida (approval_kaur.php)--------------------------</p> -->
        <?php if (session('role_name') === 'KEPALA URUSAN ADMINISTRASI AKADEMIK'): ?>
            <?= $this->include('component/detail-tiket/approval_kaur', [
                'staff' => $staff,
                'detail' => $detail,
                'taskStaffOnKaur' => $taskStaffOnKaur,
                'kaurByTiketOpen' => $kaurByTiketOpen,
                'step' => $step
            ]); ?>
            <?php $step += 3; ?>
        <?php endif; ?>
        <!-- <p>-------------------------------end komponen pak bagas/bu farida-----------</p> -->
        <!-- status 4 / staff-->
        <!-- <p>-------------------------------komponen staff (submission_staff.php)--------------------------</p> -->
        <?php if (session('role_name') === 'PEGAWAI' || session('role_name') === 'ADMIN AKADEMIK'): ?>
            <?= $this->include('component/detail-tiket/submission_staff', [
                'taskStaff' => $taskStaff,
                'step' => $step
            ]); ?>
            <?php $step += 2; ?>
        <?php endif; ?>
        <!-- <p>-------------------------------end komponen staff-----------</p> -->

        <?php if (session('role_name') === "MAHASISWA"): ?>
            <?= $this->include('component/detail-tiket/submission_mahasiswa', [
                'step' => $step++,
                'allTaskStaffOnKaur' => $allTaskStaffOnKaur ?? []
            ]); ?>
        <?php endif; ?>
    </div>
</div>

