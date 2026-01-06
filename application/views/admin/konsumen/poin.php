<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= admin_url('konsumen') ?>">Pelanggan</a></li>
                <li class="breadcrumb-item active">Kelola Poin</li>
            </ol>
        </nav>
        <h1 class="page-title">
            <?= $page_title ?>
        </h1>
    </div>
    <a href="<?= admin_url('konsumen/edit/' . $customer->id_konsumen) ?>" class="btn btn-outline-secondary">
        <i class="cil-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Member Info Card -->
        <div class="card mb-3">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 80px; height: 80px; font-size: 2rem;">
                    <?= substr($customer->nama, 0, 1) ?>
                </div>
                <h5 class="mb-1">
                    <?= $customer->nama ?>
                </h5>
                <span class="badge bg-<?= $customer->tipe == 'vip' ? 'warning text-dark' : 'primary' ?>">
                    <?= ucfirst($customer->tipe) ?>
                </span>
                <hr>
                <div class="display-5 fw-bold text-primary">
                    <?= number_format($customer->poin) ?>
                </div>
                <p class="text-muted mb-0">Poin Saat Ini</p>
            </div>
        </div>

        <!-- Add/Remove Poin Form -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="cil-plus me-1"></i>Tambah/Kurangi Poin</h6>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Poin <span class="text-danger">*</span></label>
                        <input type="number" name="poin" class="form-control" required
                            placeholder="contoh: 50 atau -20">
                        <small class="text-muted">Gunakan nilai negatif untuk mengurangi poin</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control"
                            placeholder="Alasan penambahan/pengurangan">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="cil-check me-1"></i>Update Poin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Poin History -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="cil-history me-1"></i>Riwayat Poin</h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($poin_history)): ?>
                    <div class="text-center py-5">
                        <i class="cil-inbox display-4 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada riwayat poin</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Poin</th>
                                    <th>Tipe</th>
                                    <th>Keterangan</th>
                                    <th>Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($poin_history as $h): ?>
                                    <tr>
                                        <td>
                                            <?= date('d M Y', strtotime($h->created_at)) ?>
                                            <br><small class="text-muted">
                                                <?= date('H:i', strtotime($h->created_at)) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="<?= $h->poin > 0 ? 'text-success' : 'text-danger' ?> fw-bold">
                                                <?= $h->poin > 0 ? '+' : '' ?>
                                                <?= number_format($h->poin) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $tipe_badge = [
                                                'earn' => ['bg' => 'success', 'label' => 'Transaksi'],
                                                'redeem' => ['bg' => 'warning', 'label' => 'Tukar Reward'],
                                                'adjust' => ['bg' => 'secondary', 'label' => 'Penyesuaian'],
                                                'bonus' => ['bg' => 'info', 'label' => 'Bonus'],
                                                'expired' => ['bg' => 'danger', 'label' => 'Expired']
                                            ];
                                            $t = $tipe_badge[$h->tipe] ?? ['bg' => 'secondary', 'label' => ucfirst($h->tipe)];
                                            ?>
                                            <span class="badge bg-<?= $t['bg'] ?>">
                                                <?= $t['label'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= $h->keterangan ?: '-' ?>
                                        </td>
                                        <td>
                                            <?= $h->created_by_name ?: 'System' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>