<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid"><h1 class="m-0">Unique Visitors</h1></div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </a>
            <div class="card">
                <div class="card-header bg-danger text-white"><h3 class="card-title">Visitor Analytics</h3></div>
                <div class="card-body">
                    <p>Visitor traffic data goes here.</p>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>