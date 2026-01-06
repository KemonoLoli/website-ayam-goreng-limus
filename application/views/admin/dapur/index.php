<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <h1 class="page-title">Dapur</h1>
    <div class="d-flex gap-2">
        <span class="badge bg-warning fs-6">Pending: <?= $pending_count ?></span>
        <span class="badge bg-primary fs-6">Diproses: <?= $process_count ?></span>
        <span class="badge bg-success fs-6">Siap: <?= $ready_count ?></span>
    </div>
</div>

<!-- Orders Grid -->
<div class="row g-4">
    <?php if (empty($orders)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="cil-restaurant text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Tidak ada pesanan untuk diproses</h4>
                    <p class="text-muted">Pesanan baru akan muncul di sini</p>
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
                            <small class="text-muted">Tipe:</small>
                            <span class="badge bg-secondary"><?= ucfirst($order->tipe_pemesanan) ?></span>
                            <?php if ($order->no_meja): ?>
                                <span class="badge bg-info">Meja <?= $order->no_meja ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Pelanggan:</small>
                            <strong><?= $order->nama_pelanggan ?: 'Walk-in' ?></strong>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Waktu Order:</small>
                            <?= format_datetime($order->tgl_transaksi) ?>
                        </div>
                        <hr>
                        <button class="btn btn-sm btn-outline-primary w-100" onclick="viewDetail(<?= $order->id_transaksi ?>)">
                            Lihat Detail Pesanan
                        </button>
                    </div>
                    <div class="card-footer">
                        <?php if ($order->status == 'pending'): ?>
                            <a href="<?= admin_url('dapur/process/' . $order->id_transaksi) ?>" class="btn btn-primary w-100">
                                Mulai Proses
                            </a>
                        <?php elseif ($order->status == 'diproses'): ?>
                            <a href="<?= admin_url('dapur/ready/' . $order->id_transaksi) ?>" class="btn btn-success w-100">
                                Pesanan Siap
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function viewDetail(id) {
        fetch('<?= admin_url('dapur/detail/') ?>' + id)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    let items = data.order.items.map(i => `<li>${i.qty}x ${i.nama_menu}</li>`).join('');
                    alert('Detail Pesanan:\n' + items.replace(/<[^>]*>/g, '\n'));
                }
            });
    }
</script>