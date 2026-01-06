<!-- Orders Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Riwayat Pesanan</h4>
        <p class="text-muted mb-0">Lihat semua pesanan Anda</p>
    </div>
    <a href="<?= site_url('order') ?>" class="btn btn-primary">
        <i class="bi bi-cart-plus me-1"></i>Pesan Baru
    </a>
</div>

<!-- Orders List -->
<div class="card">
    <div class="card-body p-0">
        <?php if (empty($orders)): ?>
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
                            <th>Kode Pesanan</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th width="150"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?= $order->kode_transaksi ?>
                                    </strong>
                                </td>
                                <td>
                                    <?= date('d M Y', strtotime($order->tgl_transaksi)) ?>
                                    <br><small class="text-muted">
                                        <?= date('H:i', strtotime($order->tgl_transaksi)) ?>
                                    </small>
                                </td>
                                <td>
                                    <?php
                                    $tipe_badge = [
                                        'dinein' => ['icon' => 'bi-shop', 'label' => 'Dine-in', 'class' => 'info'],
                                        'takeaway' => ['icon' => 'bi-bag', 'label' => 'Takeaway', 'class' => 'secondary'],
                                        'delivery' => ['icon' => 'bi-bicycle', 'label' => 'Delivery', 'class' => 'primary']
                                    ];
                                    $t = $tipe_badge[$order->tipe_pemesanan] ?? $tipe_badge['takeaway'];
                                    ?>
                                    <span class="badge bg-<?= $t['class'] ?>">
                                        <i class="bi <?= $t['icon'] ?> me-1"></i>
                                        <?= $t['label'] ?>
                                    </span>
                                </td>
                                <td>
                                    <strong>Rp
                                        <?= number_format($order->total, 0, ',', '.') ?>
                                    </strong>
                                </td>
                                <td>
                                    <?php
                                    $status_badge = [
                                        'pending' => ['bg' => 'warning', 'icon' => 'bi-hourglass-split'],
                                        'diproses' => ['bg' => 'info', 'icon' => 'bi-gear'],
                                        'dikirim' => ['bg' => 'primary', 'icon' => 'bi-truck'],
                                        'selesai' => ['bg' => 'success', 'icon' => 'bi-check-circle'],
                                        'batal' => ['bg' => 'danger', 'icon' => 'bi-x-circle']
                                    ];
                                    $s = $status_badge[$order->status] ?? ['bg' => 'secondary', 'icon' => 'bi-circle'];
                                    ?>
                                    <span class="badge bg-<?= $s['bg'] ?>">
                                        <i class="bi <?= $s['icon'] ?> me-1"></i>
                                        <?= ucfirst($order->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= site_url('member/order/' . $order->id_transaksi) ?>"
                                            class="btn btn-outline-secondary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="<?= site_url('member/reorder/' . $order->id_transaksi) ?>"
                                            class="btn btn-outline-primary" title="Pesan Lagi">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="card-footer bg-white">
                    <nav>
                        <ul class="pagination pagination-sm justify-content-center mb-0">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= site_url('member/orders?page=' . $i) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>