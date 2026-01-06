<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">
        <?= $page_title ?>
    </h1>
    <a href="<?= admin_url('rewards/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i>Tambah Reward
    </a>
</div>

<!-- Stats Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-start border-start-4 border-start-primary">
            <div class="card-body py-3">
                <div class="text-muted small text-uppercase fw-semibold">Total Rewards</div>
                <div class="fs-4 fw-semibold">
                    <?= count($rewards) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-start border-start-4 border-start-success">
            <div class="card-body py-3">
                <div class="text-muted small text-uppercase fw-semibold">Aktif</div>
                <div class="fs-4 fw-semibold">
                    <?= count(array_filter($rewards, function ($r) {
                        return $r->is_active; })) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-start border-start-4 border-start-info">
            <div class="card-body py-3">
                <div class="text-muted small text-uppercase fw-semibold">Total Klaim</div>
                <div class="fs-4 fw-semibold">
                    <?= array_sum(array_column($rewards, 'total_claims')) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rewards List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Daftar Rewards</h6>
        <a href="<?= admin_url('rewards/claims') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="cil-history me-1"></i>Riwayat Klaim
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($rewards)): ?>
            <div class="text-center py-5">
                <i class="cil-gift display-4 text-muted"></i>
                <p class="text-muted mt-2">Belum ada reward</p>
                <a href="<?= admin_url('rewards/create') ?>" class="btn btn-primary">Tambah Reward Pertama</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Reward</th>
                            <th>Poin</th>
                            <th>Tipe</th>
                            <th>Stok</th>
                            <th>Klaim</th>
                            <th>Status</th>
                            <th width="150"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rewards as $r): ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?= $r->nama_reward ?>
                                    </strong>
                                    <?php if ($r->deskripsi): ?>
                                        <br><small class="text-muted">
                                            <?= $r->deskripsi ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-warning text-dark">
                                        <?= number_format($r->poin_dibutuhkan) ?>
                                    </span></td>
                                <td>
                                    <?php
                                    $tipe_badge = [
                                        'discount_percent' => ['label' => 'Diskon %', 'class' => 'info'],
                                        'discount_nominal' => ['label' => 'Diskon Rp', 'class' => 'info'],
                                        'free_item' => ['label' => 'Gratis Menu', 'class' => 'success'],
                                        'voucher' => ['label' => 'Voucher', 'class' => 'primary']
                                    ];
                                    $t = $tipe_badge[$r->tipe_reward] ?? ['label' => $r->tipe_reward, 'class' => 'secondary'];
                                    ?>
                                    <span class="badge bg-<?= $t['class'] ?>">
                                        <?= $t['label'] ?>
                                    </span>
                                    <?php if ($r->nilai_reward > 0): ?>
                                        <small class="text-muted d-block">
                                            <?= $r->tipe_reward == 'discount_percent' ? $r->nilai_reward . '%' : 'Rp' . number_format($r->nilai_reward, 0, ',', '.') ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($r->stok === null): ?>
                                        <span class="text-muted">∞</span>
                                    <?php else: ?>
                                        <span class="<?= $r->stok == 0 ? 'text-danger' : '' ?>">
                                            <?= $r->stok ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $r->total_claims ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $r->is_active ? 'success' : 'secondary' ?>">
                                        <?= $r->is_active ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= admin_url('rewards/edit/' . $r->id_reward) ?>"
                                            class="btn btn-outline-primary" title="Edit">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <a href="<?= admin_url('rewards/toggle/' . $r->id_reward) ?>"
                                            class="btn btn-outline-<?= $r->is_active ? 'warning' : 'success' ?>" title="Toggle">
                                            <i class="cil-<?= $r->is_active ? 'ban' : 'check' ?>"></i>
                                        </a>
                                        <a href="<?= admin_url('rewards/claims/' . $r->id_reward) ?>"
                                            class="btn btn-outline-info" title="Lihat Klaim">
                                            <i class="cil-history"></i>
                                        </a>
                                        <a href="<?= admin_url('rewards/delete/' . $r->id_reward) ?>"
                                            class="btn btn-outline-danger" title="Hapus"
                                            onclick="return confirm('Hapus reward ini?')">
                                            <i class="cil-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>