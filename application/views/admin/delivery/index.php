<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <h1 class="page-title">Delivery</h1>
    <div class="d-flex gap-2">
        <span class="badge bg-warning fs-6">Siap Kirim: <?= $ready_count ?></span>
        <span class="badge bg-info fs-6">Sedang Dikirim: <?= $sending_count ?></span>
    </div>
</div>

<!-- Orders Grid -->
<div class="row g-4">
    <?php if (empty($orders)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="cil-truck text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Tidak ada pesanan delivery</h4>
                    <p class="text-muted">Pesanan delivery akan muncul di sini</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong><?= $order->kode_transaksi ?></strong>
                        <?= status_badge($order->status, 'transaction') ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Pelanggan:</small>
                            <strong><?= $order->nama_pelanggan ?></strong>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">No HP:</small>
                            <?= $order->no_hp_pelanggan ?: '-' ?>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Alamat:</small>
                            <p class="mb-0"><?= $order->alamat_pengiriman ?: '-' ?></p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Total:</small>
                            <strong class="text-primary"><?= format_rupiah($order->total) ?></strong>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($order->status == 'siap'): ?>
                            <a href="<?= admin_url('delivery/start/' . $order->id_transaksi) ?>" class="btn btn-primary w-100">
                                Mulai Antar
                            </a>
                        <?php elseif ($order->status == 'dikirim'): ?>
                            <a href="<?= admin_url('delivery/complete/' . $order->id_transaksi) ?>" class="btn btn-success w-100">
                                Selesai Antar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>