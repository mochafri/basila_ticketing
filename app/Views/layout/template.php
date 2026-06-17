<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="<?= base_url('assets/bootstrap/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <?= csrf_meta() ?>
</head>

<body>
    <div class="container-fluid d-flex p-0 m-0">
        <?= $this->include('layout/sidebar'); ?>
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <main class="w-100" style="background-color: var(--bgColor); overflow: hidden; min-width: 0;">
            <?= $this->include('layout/navbar'); ?>
            <div class="main-content p-4" style="overflow-y: auto; height: calc(100vh - 70px);">
                <?= $this->renderSection('content'); ?>
            </div>
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('assets/js/sweetalertcustom.js'); ?>"></script>
    <script src="<?= base_url('assets/js/sidebar.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <!-- <script type="module" src="http://localhost:5173/public/assets/js/app.js"></script>
     -->
    <?= $this->renderSection('script') ?>
</body>
</html>