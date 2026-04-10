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
        <main class="w-100" style="background-color: var(--bgColor); overflow: hidden;">
            <?= $this->include('layout/navbar'); ?>
            <div class="main-content p-4" style="overflow-y: auto; height: calc(100vh - 70px);">
                <?= $this->renderSection('content'); ?>
            </div>
        </main>
    </div>


    <script src="<?= base_url('assets/js/sidebar.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/inputKategori.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/inputLayanan.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/tambahTiket.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/approveKaur.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/approveKabag.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/js/staff.js') ?>"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
<?= $this->renderSection('script') ?>
</html>