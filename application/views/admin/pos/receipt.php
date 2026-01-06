<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk - <?= $transaksi->kode_transaksi ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .header {
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            margin-bottom: 2px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        .info {
            margin: 8px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }

        .items {
            margin: 10px 0;
        }

        .item {
            margin: 5px 0;
        }

        .item-name {}

        .item-detail {
            display: flex;
            justify-content: space-between;
            padding-left: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .total-row.grand {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
        }

        @media print {
            body {
                width: 80mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header center">
        <h1>🍗 WARUNG LIMUS POJOK</h1>
        <p><?= isset($settings['alamat']) ? $settings['alamat'] : 'Limus Regency, Cileungsi' ?></p>
        <p>Telp: <?= isset($settings['telepon']) ? $settings['telepon'] : '0812-3456-7890' ?></p>
    </div>

    <div class="divider"></div>

    <div class="info">
        <div class="info-row">
            <span>No:</span>
            <span class="bold"><?= $transaksi->kode_transaksi ?></span>
        </div>
        <div class="info-row">
            <span>Tanggal:</span>
            <span><?= date('d/m/Y H:i', strtotime($transaksi->tgl_transaksi)) ?></span>
        </div>
        <div class="info-row">
            <span>Tipe:</span>
            <span><?= ucfirst($transaksi->tipe_pemesanan) ?></span>
        </div>
        <?php if ($transaksi->no_meja): ?>
            <div class="info-row">
                <span>Meja:</span>
                <span><?= $transaksi->no_meja ?></span>
            </div>
        <?php endif; ?>
        <?php if ($transaksi->nama_pelanggan): ?>
            <div class="info-row">
                <span>Pelanggan:</span>
                <span><?= $transaksi->nama_pelanggan ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="divider"></div>

    <div class="items">
        <?php foreach ($transaksi->items as $item): ?>
            <div class="item">
                <div class="item-name"><?= $item->nama_menu ?></div>
                <div class="item-detail">
                    <span><?= $item->qty ?> x <?= number_format($item->harga_satuan, 0, ',', '.') ?></span>
                    <span><?= number_format($item->total_harga, 0, ',', '.') ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="divider"></div>

    <div class="totals">
        <div class="total-row">
            <span>Subtotal</span>
            <span><?= number_format($transaksi->subtotal, 0, ',', '.') ?></span>
        </div>
        <?php if ($transaksi->diskon_nominal > 0): ?>
            <div class="total-row">
                <span>Diskon (<?= $transaksi->diskon_persen ?>%)</span>
                <span>-<?= number_format($transaksi->diskon_nominal, 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>
        <?php if ($transaksi->pajak_nominal > 0): ?>
            <div class="total-row">
                <span>Pajak</span>
                <span><?= number_format($transaksi->pajak_nominal, 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>
        <?php if ($transaksi->ongkir > 0): ?>
            <div class="total-row">
                <span>Ongkir</span>
                <span><?= number_format($transaksi->ongkir, 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>

        <div class="divider"></div>

        <div class="total-row grand">
            <span>TOTAL</span>
            <span>Rp <?= number_format($transaksi->total, 0, ',', '.') ?></span>
        </div>
        <div class="total-row">
            <span>Bayar (<?= strtoupper($transaksi->metode_pembayaran) ?>)</span>
            <span>Rp <?= number_format($transaksi->bayar, 0, ',', '.') ?></span>
        </div>
        <?php if ($transaksi->kembalian > 0): ?>
            <div class="total-row bold">
                <span>Kembalian</span>
                <span>Rp <?= number_format($transaksi->kembalian, 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="divider"></div>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>Selamat menikmati 🙏</p>
        <br>
        <div class="no-print action-buttons"
            style="margin-top: 15px; display: flex; gap: 10px; justify-content: center;">
            <button onclick="window.print()" class="btn-action btn-print">
                🖨️ Cetak Struk
            </button>
            <button onclick="exportPDF()" class="btn-action btn-pdf">
                📄 Export PDF
            </button>
            <button onclick="window.close()" class="btn-action btn-close-receipt">
                ✖ Tutup
            </button>
        </div>
    </div>

    <style>
        .action-buttons {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-top: 10px;
        }

        .btn-action {
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-print {
            background: #0d6efd;
            color: white;
        }

        .btn-pdf {
            background: #dc3545;
            color: white;
        }

        .btn-close-receipt {
            background: #6c757d;
            color: white;
        }

        @media print {
            .action-buttons {
                display: none !important;
            }
        }
    </style>

    <!-- html2pdf.js for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function exportPDF() {
            // Hide action buttons before export
            const buttons = document.querySelector('.action-buttons');
            if (buttons) buttons.style.display = 'none';

            const element = document.body;
            const opt = {
                margin: 0.5,
                filename: 'Struk_<?= $transaksi->kode_transaksi ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'mm', format: [80, 200], orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                // Show buttons again after export
                if (buttons) buttons.style.display = 'flex';
            });
        }
    </script>
</body>

</html>