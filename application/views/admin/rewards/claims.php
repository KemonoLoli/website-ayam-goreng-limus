<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= admin_url('rewards') ?>">Rewards</a></li>
                <li class="breadcrumb-item active">Riwayat Klaim</li>
            </ol>
        </nav>
        <h1 class="page-title">
            <?= $page_title ?>
        </h1>
    </div>
    <a href="<?= admin_url('rewards') ?>" class="btn btn-outline-secondary">
        <i class="cil-arrow-left me-1"></i>Kembali
    </a>
</div>

<!-- Claims Table -->
<div class="card">
    <div class="card-body p-0">
        <?php if (empty($claims)): ?>
            <div class="text-center py-5">
                <i class="cil-history display-4 text-muted"></i>
                <p class="text-muted mt-2">Belum ada klaim reward</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Klaim</th>
                            <th>Reward</th>
                            <th>Member</th>
                            <th>Tanggal Klaim</th>
                            <th>Expired</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($claims as $c): ?>
                            <tr>
                                <td><code><?= $c->kode_klaim ?></code></td>
                                <td><strong>
                                        <?= $c->nama_reward ?>
                                    </strong></td>
                                <td>
                                    <?= $c->nama_member ?>
                                    <br><small class="text-muted">
                                        <?= $c->no_hp ?>
                                    </small>
                                </td>
                                <td>
                                    <?= date('d M Y, H:i', strtotime($c->created_at)) ?>
                                </td>
                                <td>
                                    <?php if ($c->expired_at): ?>
                                        <?= date('d M Y', strtotime($c->expired_at)) ?>
                                        <?php if (strtotime($c->expired_at) < time() && $c->status == 'active'): ?>
                                            <br><span class="badge bg-danger">Expired</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $status_badge = [
                                        'active' => 'primary',
                                        'used' => 'success',
                                        'expired' => 'danger'
                                    ];
                                    ?>
                                    <span class="badge bg-<?= $status_badge[$c->status] ?? 'secondary' ?>">
                                        <?= ucfirst($c->status) ?>
                                    </span>
                                    <?php if ($c->status == 'used' && $c->used_at): ?>
                                        <br><small class="text-muted">Digunakan:
                                            <?= date('d/m/y H:i', strtotime($c->used_at)) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($c->status == 'active'): ?>
                                        <a href="<?= admin_url('rewards/use_claim/' . $c->id_claim) ?>"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Tandai voucher ini sudah digunakan?')">
                                            <i class="cil-check me-1"></i>Gunakan
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>