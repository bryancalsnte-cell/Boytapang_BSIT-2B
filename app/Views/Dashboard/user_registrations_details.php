<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">User Account Activities</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </a>

            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title text-dark">Activity History</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Admin/User</th>
                                <th>Action Performed</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($userLogs)): ?>
                                <?php foreach ($userLogs as $log): ?>
                                    <tr>
                                        <td><?= $log['DATELOG'] ?> <?= $log['TIMELOG'] ?></td>
                                        <td><?= esc($log['USER_NAME']) ?></td>
                                        <td><?= esc($log['ACTION']) ?></td>
                                        <td><?= $log['user_ip_address'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No account activities recorded yet.</td>
                                </tr>
                            <?php endif; ?>
                            <td>
    <?php if (strpos($log['ACTION'], 'New User') !== false): ?>
        <span class="badge badge-success"><?= esc($log['ACTION']) ?></span>
    <?php else: ?>
        <span class="badge badge-info"><?= esc($log['ACTION']) ?></span>
    <?php endif; ?>
</td>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>