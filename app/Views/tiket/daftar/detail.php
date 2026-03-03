<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <p>card 1</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <p>card 2</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>