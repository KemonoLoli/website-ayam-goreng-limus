<!-- Dashboard Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Halo,
            <?= $current_member->nama_lengkap ?>!
        </h4>
        <p class="text-muted mb-0">Selamat datang di dashboard member Anda</p>
    </div>
    <a href="<?= site_url('order') ?>" class="btn btn-primary">
        <i class="bi bi-cart-plus me-1"></i>Pesan Sekarang
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="bi bi-gift text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="mb-0">
                            <?= number_format($stats['poin']) ?>
                        </h3>
                        <small class="text-muted">Poin</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-receipt text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="mb-0">
                            <?= number_format($stats['total_orders']) ?>
                        </h3>
                        <small class="text-muted">Total Pesanan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="bi bi-wallet2 text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0">Rp
                            <?= number_format($stats['total_spent'], 0, ',', '.') ?>
                        </h5>
                        <small class="text-muted">Total Transaksi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="bi bi-calendar-check text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0">
                            <?= date('d M Y', strtotime($stats['member_since'])) ?>
                        </h6>
                        <small class="text-muted">Member Sejak</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Member Benefits Banner -->
<div class="card bg-gradient mb-4" style="background: linear-gradient(135deg, #FE5D26, #f5af19);">
    <div class="card-body text-white">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="mb-2"><i class="bi bi-star-fill me-2"></i>Keuntungan Member</h5>
                <div class="d-flex flex-wrap gap-4">
                    <span><i class="bi bi-check-circle me-1"></i>Diskon 5% otomatis</span>
                    <span><i class="bi bi-check-circle me-1"></i>Kumpulkan poin</span>
                    <span><i class="bi bi-check-circle me-1"></i>Tukar rewards</span>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="<?= site_url('member/rewards') ?>" class="btn btn-light">
                    <i class="bi bi-gift me-1"></i>Lihat Rewards
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Pesanan Terakhir</h6>
        <a href="<?= site_url('member/orders') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($recent_orders)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-4 text-muted"></i>
                <p class="text-muted mt-2">Belum ada pesanan</p>
                <a href="<?= site_url('order') ?>" class="btn btn-primary">Pesan Sekarang</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order): ?>
                            <tr>
                                <td><strong>
                                        <?= $order->kode_transaksi ?>
                                    </strong></td>
                                <td>
                                    <?= date('d M Y, H:i', strtotime($order->tgl_transaksi)) ?>
                                </td>
                                <td>
                                    <?php
                                    $tipe_icon = [
                                        'dinein' => 'bi-shop',
                                        'takeaway' => 'bi-bag',
                                        'delivery' => 'bi-bicycle'
                                    ];
                                    $tipe_label = [
                                        'dinein' => 'Dine-in',
                                        'takeaway' => 'Takeaway',
                                        'delivery' => 'Delivery'
                                    ];
                                    ?>
                                    <i class="bi <?= $tipe_icon[$order->tipe_pemesanan] ?? 'bi-bag' ?> me-1"></i>
                                    <?= $tipe_label[$order->tipe_pemesanan] ?? $order->tipe_pemesanan ?>
                                </td>
                                <td><strong>Rp
                                        <?= number_format($order->total, 0, ',', '.') ?>
                                    </strong></td>
                                <td>
                                    <?php
                                    $status_badge = [
                                        'pending' => 'warning',
                                        'diproses' => 'info',
                                        'dikirim' => 'primary',
                                        'selesai' => 'success',
                                        'batal' => 'danger'
                                    ];
                                    ?>
                                    <span class="badge bg-<?= $status_badge[$order->status] ?? 'secondary' ?>">
                                        <?= ucfirst($order->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= site_url('member/order/' . $order->id_transaksi) ?>"
                                            class="btn btn-outline-secondary" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('member/reorder/' . $order->id_transaksi) ?>"
                                            class="btn btn-outline-primary" title="Pesan Ulang">
                                            <i class="bi bi-arrow-repeat"></i>
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