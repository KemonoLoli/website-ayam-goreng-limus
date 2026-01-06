<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Laporan Pembelian</h1>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="<?= $date_from ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="<?= $date_to ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= number_format($summary->total_pembelian) ?></div>
                <div>Total Pembelian</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= format_rupiah($summary->total_nilai ?: 0) ?></div>
                <div>Total Nilai Pembelian</div>
            </div>
        </div>
    </div>
</div>

<!-- Purchases Table -->
<div class="card">
    <div class="card-header">Daftar Pembelian</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($purchases)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($purchases as $p): ?>
                            <tr>
                                <td><strong><?= $p->kode_pembelian ?></strong></td>
                                <td><?= format_date($p->tgl_pembelian) ?></td>
                                <td><?= $p->supplier_nama ?: '-' ?></td>
                                <td><?= format_rupiah($p->total) ?></td>
                                <td><?= status_badge($p->status, 'purchase') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>