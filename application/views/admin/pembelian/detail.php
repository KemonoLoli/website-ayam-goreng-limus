<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $pembelian->kode_pembelian ?></h1>
    <a href="<?= admin_url('pembelian') ?>" class="btn btn-outline-secondary"><i class="cil-arrow-left me-1"></i>
        Kembali</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Detail Item</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Bahan</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembelian->items as $item): ?>
                            <tr>
                                <td><?= $item->nama_bahan ?></td>
                                <td class="text-end"><?= $item->qty ?>     <?= $item->satuan ?></td>
                                <td class="text-end"><?= format_rupiah($item->harga_satuan) ?></td>
                                <td class="text-end"><?= format_rupiah($item->subtotal) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fw-bold fs-5">
                            <td colspan="3" class="text-end">TOTAL</td>
                            <td class="text-end text-primary"><?= format_rupiah($pembelian->total) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">Informasi PO</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php
                            $colors = ['dipesan' => 'warning', 'diterima' => 'success', 'dibatalkan' => 'secondary'];
                            ?>
                            <span
                                class="badge bg-<?= $colors[$pembelian->status] ?? 'secondary' ?> fs-6"><?= ucfirst($pembelian->status) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td><?= format_datetime($pembelian->tgl_pembelian) ?></td>
                    </tr>
                    <?php if ($pembelian->tgl_diterima): ?>
                        <tr>
                            <th>Diterima</th>
                            <td><?= format_datetime($pembelian->tgl_diterima) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Catatan</th>
                        <td><?= $pembelian->catatan ?: '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <?php if ($pembelian->status === 'dipesan'): ?>
            <div class="card">
                <div class="card-header">Aksi</div>
                <div class="card-body">
                    <a href="<?= admin_url('pembelian/receive/' . $pembelian->id_pembelian) ?>"
                        class="btn btn-success w-100 mb-2" onclick="return confirm('Terima barang dan update stok?')">
                        <i class="cil-check me-1"></i> Terima Barang
                    </a>
                    <a href="<?= admin_url('pembelian/cancel/' . $pembelian->id_pembelian) ?>"
                        class="btn btn-outline-danger w-100" onclick="return confirm('Batalkan PO ini?')">
                        <i class="cil-x me-1"></i> Batalkan
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>