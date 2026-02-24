<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>New Orders Detailed List</h1>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                             <a href="<?= base_url('dashboard') ?>" class="btn btn-primary mb-3">
                                <i class="fas fa-arrow-left"></i> Return to Dashboard
                            </a>
                                    
                  </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>