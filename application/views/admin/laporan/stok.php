<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('laporan') ?>" class="btn btn-outline-secondary">
        <i class="cil-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Low Stock Alert -->
<?php if (!empty($low_stock)): ?>
    <div class="alert alert-danger mb-4">
        <h5 class="alert-heading"><i class="cil-warning me-2"></i> Stok Menipis!</h5>
        <p class="mb-2">Bahan-bahan berikut perlu segera di-restock:</p>
        <div class="row">
            <?php foreach ($low_stock as $b): ?>
                <div class="col-md-4 col-lg-3">
                    <strong><?= $b->nama_bahan ?></strong>:
                    <span class="text-danger"><?= $b->stok ?></span> / <?= $b->stok_minimum ?>         <?= $b->satuan ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= count($bahan) ?></div>
                <div>Total Jenis Bahan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= count($low_stock) ?></div>
                <div>Stok Menipis</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= count($bahan) - count($low_stock) ?></div>
                <div>Stok Aman</div>
            </div>
        </div>
    </div>
</div>

<!-- Stock List -->
<div class="card">
    <div class="card-header">Daftar Stok Bahan</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th class="text-end">Stok</th>
                        <th class="text-end">Min</th>
                        <th>Status</th>
                        <th class="text-end">Nilai Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_nilai = 0;
                    foreach ($bahan as $b):
                        $is_low = $b->stok <= $b->stok_minimum;
                        $nilai = $b->stok * $b->harga_per_satuan;
                        $total_nilai += $nilai;
                        ?>
                        <tr class="<?= $is_low ? 'table-warning' : '' ?>">
                            <td><small class="text-body-secondary"><?= $b->kode_bahan ?></small></td>
                            <td class="fw-semibold"><?= $b->nama_bahan ?></td>
                            <td><?= $b->kategori_bahan ?: '-' ?></td>
                            <td class="text-end">
                                <span class="badge bg-<?= $is_low ? 'danger' : 'success' ?>"><?= $b->stok ?></span>
                                <?= $b->satuan ?>
                            </td>
                            <td class="text-end"><?= $b->stok_minimum ?></td>
                            <td>
                                <?php if ($is_low): ?>
                                    <span class="badge bg-danger">Menipis</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Aman</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end"><?= format_rupiah($nilai) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr class="fw-bold">
                        <td colspan="6" class="text-end">Total Nilai Stok</td>
                        <td class="text-end text-primary"><?= format_rupiah($total_nilai) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>