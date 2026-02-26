<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
    <div class="container mt-4 ms-2">
        <h1 class="mt-2">Welcome to the Dashboard</h1>
        <p>This is the main dashboard page.</p>
        <button class="btn btn-primary">Test Bootstrap</button>
    </div>
<?= $this->endSection(); ?>