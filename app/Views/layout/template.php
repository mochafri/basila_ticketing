<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="<?= base_url('assets/bootstrap/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="container-fluid d-flex p-0 m-0">
        <?= $this->include('layout/sidebar'); ?>
        <main class="w-100" style="background-color: var(--bgColor); overflow: hidden;">
            <?= $this->include('layout/navbar'); ?>

            <?= $this->renderSection('content'); ?>
        </main>
    </div>


    <script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>

</html>