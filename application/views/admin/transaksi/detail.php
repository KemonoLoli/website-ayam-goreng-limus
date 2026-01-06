<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $transaksi->kode_transaksi ?></h1>
    <div>
        <a href="<?= admin_url('pos/print_receipt/' . $transaksi->id_transaksi) ?>" class="btn btn-outline-primary" target="_blank">
            <i class="cil-print me-1"></i> Cetak
        </a>
        <a href="<?= admin_url('transaksi') ?>" class="btn btn-outline-secondary">
            <i class="cil-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">Detail Pesanan</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Menu</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi->items as $item): ?>
                            <tr>
                                <td>
                                    <?= $item->nama_menu ?>
                                    <?php if ($item->catatan): ?>
                                        <br><small class="text-body-secondary"><?= $item->catatan ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end"><?= format_rupiah($item->harga_satuan) ?></td>
                                <td class="text-center"><?= $item->qty ?></td>
                                <td class="text-end"><?= format_rupiah($item->total_harga) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end">Subtotal</td>
                            <td class="text-end"><?= format_rupiah($transaksi->subtotal) ?></td>
                        </tr>
                        <?php if ($transaksi->diskon_nominal > 0): ?>
                        <tr>
                            <td colspan="3" class="text-end">Diskon (<?= $transaksi->diskon_persen ?>%)</td>
                            <td class="text-end text-danger">-<?= format_rupiah($transaksi->diskon_nominal) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (isset($transaksi->pajak) && $transaksi->pajak > 0): ?>
                        <tr>
                            <td colspan="3" class="text-end">Pajak</td>
                            <td class="text-end"><?= format_rupiah($transaksi->pajak) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($transaksi->ongkir > 0): ?>
                        <tr>
                            <td colspan="3" class="text-end">Ongkir</td>
                            <td class="text-end"><?= format_rupiah($transaksi->ongkir) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="fw-bold fs-5">
                            <td colspan="3" class="text-end">TOTAL</td>
                            <td class="text-end text-primary"><?= format_rupiah($transaksi->total) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Bayar</td>
                            <td class="text-end"><?= format_rupiah($transaksi->bayar) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Kembalian</td>
                            <td class="text-end"><?= format_rupiah($transaksi->kembalian) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">Info Transaksi</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Status</th><td><?= status_badge($transaksi->status, 'transaction') ?></td></tr>
                    <tr><th>Tipe</th><td><?= ucfirst($transaksi->tipe_pemesanan) ?></td></tr>
                    <tr><th>Pembayaran</th><td><?= strtoupper($transaksi->metode_pembayaran) ?></td></tr>
                    <tr><th>Waktu</th><td><?= format_datetime($transaksi->tgl_transaksi) ?></td></tr>
                    <?php if ($transaksi->no_meja): ?>
                        <tr><th>No. Meja</th><td><?= $transaksi->no_meja ?></td></tr>
                    <?php endif; ?>
                    <?php if ($transaksi->nama_pelanggan): ?>
                        <tr><th>Pelanggan</th><td><?= $transaksi->nama_pelanggan ?></td></tr>
                    <?php endif; ?>
                    <?php if ($transaksi->no_hp_pelanggan): ?>
                        <tr><th>HP</th><td><?= $transaksi->no_hp_pelanggan ?></td></tr>
                    <?php endif; ?>
                    <?php if ($transaksi->alamat_pengiriman): ?>
                        <tr><th>Alamat</th><td><?= $transaksi->alamat_pengiriman ?></td></tr>
                    <?php endif; ?>
                    <?php if ($transaksi->catatan): ?>
                        <tr><th>Catatan</th><td><?= $transaksi->catatan ?></td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        
        <?php if ($transaksi->status !== 'selesai' && $transaksi->status !== 'dibatalkan'): ?>
        <div class="card">
            <div class="card-header">Update Status</div>
            <div class="card-body">
                <form method="post" action="<?= admin_url('transaksi/update_status/' . $transaksi->id_transaksi) ?>">
                    <?= csrf_field() ?>
                    <select name="status" class="form-select mb-3">
                        <?php 
                        $statuses = ['pending', 'dikonfirmasi', 'diproses', 'siap', 'dikirim', 'selesai', 'dibatalkan'];
                        foreach ($statuses as $s): ?>
                            <option value="<?= $s ?>" <?= $transaksi->status === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
