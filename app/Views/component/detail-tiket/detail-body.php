<div class="card border-0">
    <div class="card-body p-5 d-flex flex-column gap-4 text-uppercase">
        <div class="d-flex align-items-center gap-3">
            <iconify-icon icon="material-symbols:timeline" class="text-danger fs-2"></iconify-icon>
            <h5 class="fw-bold">Timeline & alur kerja</h5>
        </div>
        <!-- status 1 -->
        <?= $this->include('component/detail-tiket/ticket_created'); ?>
        <!-- status 2 -->
        <!-- <p>-------------------------------komponen bu fira (approval_kabag.php)--------------------------</p> -->
        <?php if (session('role_name') === 'SUPERADMIN'):  ?>
            <?= $this->include('component/detail-tiket/approval_kabag', [
                'kaur' => $kaur,
                'detail' => $detail,
            'kaurByTiketOpen' => $kaurByTiketOpen
            ]); ?>
        <?php endif; ?>
        <!-- <p>-------------------------------end komponen bu fira-----------</p> -->
        <!-- status 3 -->
        <!-- <p>-------------------------------komponen pak bagas/bu farida (approval_kaur.php)--------------------------</p> -->
        <?php if (session('role_name') === 'KEPALA URUSAN ADMINISTRASI AKADEMIK'):  ?>
            <?= $this->include('component/detail-tiket/approval_kaur', [
                'staff' => $staff,
                'taskStaffOnKaur' => $taskStaffOnKaur
            ]); ?>
        <?php endif; ?>
        <!-- <p>-------------------------------end komponen pak bagas/bu farida-----------</p> -->
        <!-- status 4 / staff-->
        <!-- <p>-------------------------------komponen staff (submission_staff.php)--------------------------</p> -->
        <?php if (session('role_name') === 'PEGAWAI' || session('role_name') === 'ADMIN AKADEMIK'):  ?>
            <?= $this->include('component/detail-tiket/submission_staff', [
                'taskStaff' => $taskStaff
            ]); ?>
        <?php endif; ?>
        <!-- <p>-------------------------------end komponen staff-----------</p> -->
    </div>
</div>