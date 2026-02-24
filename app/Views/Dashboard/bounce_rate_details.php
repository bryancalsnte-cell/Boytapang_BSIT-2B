<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Bounce Rate Details</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </a>

            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">Bounce Rate Analytics</h3>
                </div>
                <div class="card-body">
                    <p>Detailed analytics for your bounce rate will be displayed here.</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Page Name</th>
                                <th>Total Visitors</th>
                                <th>Bounce Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/home</td>
                                <td>1,200</td>
                                <td>53%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>