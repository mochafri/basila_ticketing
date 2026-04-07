<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Auth'; ?></title>

    <link href="<?= base_url('assets/bootstrap/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <?= csrf_meta() ?>
</head>

<body class="bg-light">

<?= $this->renderSection('content'); ?>

<script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>

<script>
function initializePasswordToggle(toggleSelector) {
    document.querySelectorAll(toggleSelector).forEach(el => {
        el.addEventListener("click", function() {
            let input = document.querySelector(this.dataset.toggle);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        });
    });
}
initializePasswordToggle(".toggle-password");
</script>

</body>
</html>