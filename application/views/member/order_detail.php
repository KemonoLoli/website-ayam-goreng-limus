<!-- Order Detail Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="<?= site_url('member/orders') ?>">Riwayat Pesanan</a></li>
                <li class="breadcrumb-item active">
                    <?= $transaksi->kode_transaksi ?>
                </li>
            </ol>
        </nav>
        <h4 class="mb-0">Detail Pesanan</h4>
    </div>
    <a href="<?= site_url('member/reorder/' . $transaksi->id_transaksi) ?>" class="btn btn-primary">
        <i class="bi bi-arrow-repeat me-1"></i>Pesan Lagi
    </a>
</div>

<div class="row g-4">
    <!-- Order Info -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <?= $transaksi->kode_transaksi ?>
                </h6>
                <?php
                $status_badge = [
                    'pending' => 'warning',
                    'diproses' => 'info',
                    'dikirim' => 'primary',
                    'selesai' => 'success',
                    'batal' => 'danger'
                ];
                ?>
                <span class="badge bg-<?= $status_badge[$transaksi->status] ?? 'secondary' ?>">
                    <?= ucfirst($transaksi->status) ?>
                </span>
            </div>
            <div class="card-body">
                <!-- Order Items -->
                <h6 class="mb-3">Item Pesanan</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Menu</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi->details as $item): ?>
                                <tr>
                                    <td>
                                        <strong>
                                            <?= $item->nama_menu ?>
                                        </strong>
                                        <?php if (!empty($item->catatan)): ?>
                                            <br><small class="text-muted">
                                                <?= $item->catatan ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $item->qty ?>
                                    </td>
                                    <td class="text-end">Rp
                                        <?= number_format($item->harga_satuan, 0, ',', '.') ?>
                                    </td>
                                    <td class="text-end"><strong>Rp
                                            <?= number_format($item->total_harga, 0, ',', '.') ?>
                                        </strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <?php if (!empty($transaksi->catatan)): ?>
            <div class="card">
                <div class="card-body">
                    <h6><i class="bi bi-sticky me-2"></i>Catatan</h6>
                    <p class="mb-0">
                        <?= nl2br(htmlspecialchars($transaksi->catatan)) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Order Summary -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>Rp
                        <?= number_format($transaksi->subtotal, 0, ',', '.') ?>
                    </span>
                </div>
                <?php if ($transaksi->diskon_nominal > 0): ?>
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Diskon
                            <?= $transaksi->diskon_persen ?>%
                        </span>
                        <span>-Rp
                            <?= number_format($transaksi->diskon_nominal, 0, ',', '.') ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if ($transaksi->ongkir > 0): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <span>Rp
                            <?= number_format($transaksi->ongkir, 0, ',', '.') ?>
                        </span>
                    </div>
                <?php endif; ?>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong class="text-primary fs-5">Rp
                        <?= number_format($transaksi->total, 0, ',', '.') ?>
                    </strong>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td class="text-end">
                            <?= date('d M Y, H:i', strtotime($transaksi->tgl_transaksi)) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tipe</td>
                        <td class="text-end">
                            <?php
                            $tipe_label = [
                                'dinein' => 'Dine-in',
                                'takeaway' => 'Takeaway',
                                'delivery' => 'Delivery'
                            ];
                            echo $tipe_label[$transaksi->tipe_pemesanan] ?? $transaksi->tipe_pemesanan;
                            ?>
                        </td>
                    </tr>
                    <?php if ($transaksi->tipe_pemesanan === 'dinein' && $transaksi->no_meja): ?>
                        <tr>
                            <td class="text-muted">No. Meja</td>
                            <td class="text-end">
                                <?= $transaksi->no_meja ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="text-muted">Pembayaran</td>
                        <td class="text-end">
                            <?= ucfirst($transaksi->metode_pembayaran) ?>
                        </td>
                    </tr>
                </table>

                <?php if ($transaksi->tipe_pemesanan === 'delivery' && $transaksi->alamat_pengiriman): ?>
                    <hr>
                    <h6 class="small text-muted">Alamat Pengiriman</h6>
                    <p class="mb-0 small">
                        <?= nl2br(htmlspecialchars($transaksi->alamat_pengiriman)) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>