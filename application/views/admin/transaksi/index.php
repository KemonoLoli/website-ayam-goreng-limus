<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('pos') ?>" class="btn btn-primary">
        <i class="cil-cart me-1"></i> Buka Kasir
    </a>
</div>

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <?php foreach (['pending', 'dikonfirmasi', 'diproses', 'siap', 'dikirim', 'selesai', 'dibatalkan'] as $s): ?>
                        <option value="<?= $s ?>" <?= $filters['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tipe</label>
                <select name="tipe" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="dinein" <?= $filters['tipe'] === 'dinein' ? 'selected' : '' ?>>Dine In</option>
                    <option value="takeaway" <?= $filters['tipe'] === 'takeaway' ? 'selected' : '' ?>>Take Away</option>
                    <option value="delivery" <?= $filters['tipe'] === 'delivery' ? 'selected' : '' ?>>Delivery</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Dari</label>
                <input type="date" name="from" class="form-control form-control-sm" value="<?= $filters['date_from'] ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Sampai</label>
                <input type="date" name="to" class="form-control form-control-sm" value="<?= $filters['date_to'] ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kode..." value="<?= $filters['search'] ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="cil-search"></i></button>
                <a href="<?= admin_url('transaksi') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Kasir</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transaksi)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-body-secondary">Tidak ada transaksi</td></tr>
                    <?php else: ?>
                        <?php foreach ($transaksi as $t): ?>
                            <tr>
                                <td>
                                    <a href="<?= admin_url('transaksi/detail/' . $t->id_transaksi) ?>" class="fw-semibold text-decoration-none">
                                        <?= $t->kode_transaksi ?>
                                    </a>
                                </td>
                                <td><?= format_datetime($t->tgl_transaksi) ?></td>
                                <td><span class="badge bg-secondary"><?= ucfirst($t->tipe_pemesanan) ?></span></td>
                                <td><?= $t->nama_pelanggan ?: (isset($t->konsumen_nama) ? $t->konsumen_nama : '-') ?></td>
                                <td class="fw-semibold"><?= format_rupiah($t->total) ?></td>
                                <td><?= status_badge($t->status, 'transaction') ?></td>
                                <td><?= $t->kasir_nama ?: '-' ?></td>
                                <td>
                                    <a href="<?= admin_url('transaksi/detail/' . $t->id_transaksi) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="cil-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <small class="text-body-secondary">Total: <?= count($transaksi) ?> transaksi</small>
    </div>
</div>
