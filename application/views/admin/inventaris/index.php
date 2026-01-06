<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Stock & Inventaris</h1>
    <a href="<?= admin_url('inventaris/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Catat Pergerakan
    </a>
</div>

<!-- Current Stock Levels -->
<div class="card mb-4">
    <div class="card-header">
        <i class="cil-storage me-2"></i>Level Stok Saat Ini
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Min.</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($stocks)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data bahan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($stocks as $item): ?>
                            <?php
                            $stok_persen = $item->stok_minimum > 0 ? ($item->stok / $item->stok_minimum * 100) : 100;
                            if ($item->stok <= $item->stok_minimum) {
                                $status_class = 'danger';
                                $status_text = 'Kritis';
                            } elseif ($stok_persen < 150) {
                                $status_class = 'warning';
                                $status_text = 'Hampir Habis';
                            } else {
                                $status_class = 'success';
                                $status_text = 'Aman';
                            }
                            ?>
                            <tr>
                                <td><code><?= $item->kode_bahan ?></code></td>
                                <td><strong><?= $item->nama_bahan ?></strong></td>
                                <td><?= $item->kategori_bahan ?: '-' ?></td>
                                <td class="fw-bold"><?= number_format($item->stok, 0, ',', '.') ?></td>
                                <td><?= $item->satuan ?></td>
                                <td><?= number_format($item->stok_minimum, 0, ',', '.') ?></td>
                                <td><span class="badge bg-<?= $status_class ?>"><?= $status_text ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Stock Movements History -->
<div class="card">
    <div class="card-header">
        <i class="cil-swap-horizontal me-2"></i>Riwayat Pergerakan Stok
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Bahan</th>
                        <th>Jenis</th>
                        <th>Qty</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($movements)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada pergerakan stok</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($movements as $mov): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($mov->tgl_pergerakan)) ?></td>
                                <td><strong><?= $mov->nama_bahan ?></strong></td>
                                <td>
                                    <?php if ($mov->jenis_pergerakan == 'masuk'): ?>
                                        <span class="badge bg-success"><i class="cil-arrow-bottom me-1"></i>Masuk</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="cil-arrow-top me-1"></i>Keluar</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($mov->qty, 0, ',', '.') ?>         <?= $mov->satuan ?></td>
                                <td><?= number_format($mov->stok_sebelum, 0, ',', '.') ?></td>
                                <td><?= number_format($mov->stok_sesudah, 0, ',', '.') ?></td>
                                <td><small><?= $mov->keterangan ?: '-' ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>