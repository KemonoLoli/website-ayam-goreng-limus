<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Pembelian Stok</h1>
    <a href="<?= admin_url('pembelian/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Buat Pembelian
    </a>
</div>

<!-- Purchases Table -->
<div class="card">
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
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($purchases)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pembelian</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($purchases as $p): ?>
                            <tr>
                                <td><strong><?= $p->kode_pembelian ?></strong></td>
                                <td><?= format_date($p->tgl_pembelian) ?></td>
                                <td><?= $p->supplier_nama ?: '-' ?></td>
                                <td><?= format_rupiah($p->total) ?></td>
                                <td><?= status_badge($p->status, 'purchase') ?></td>
                                <td>
                                    <?php if ($p->status == 'draft'): ?>
                                        <a href="<?= admin_url('pembelian/confirm/' . $p->id_pembelian) ?>"
                                            class="btn btn-sm btn-primary"
                                            onclick="return confirm('Konfirmasi pembelian ini?')">Konfirmasi</a>
                                    <?php elseif ($p->status == 'dipesan'): ?>
                                        <a href="<?= admin_url('pembelian/receive/' . $p->id_pembelian) ?>"
                                            class="btn btn-sm btn-success"
                                            onclick="return confirm('Terima pembelian ini? Stok akan diupdate.')">Terima</a>
                                    <?php else: ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>