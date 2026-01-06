<?php
$bulan_nama = [
    '',
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slip Gaji - <?= $gaji->nama ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: normal;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
        }

        .info-col {
            flex: 1;
        }

        .info-col table {
            width: 100%;
        }

        .info-col th {
            text-align: left;
            width: 100px;
            padding: 3px 0;
        }

        .info-col td {
            padding: 3px 0;
        }

        .section {
            margin: 15px 0;
        }

        .section h3 {
            font-size: 12px;
            background: #f0f0f0;
            padding: 5px 10px;
            margin-bottom: 5px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table td {
            padding: 5px 10px;
            border-bottom: 1px solid #eee;
        }

        .detail-table td:last-child {
            text-align: right;
        }

        .total-row {
            background: #f0f0f0;
            font-weight: bold;
        }

        .net-row {
            background: #4CAF50;
            color: white;
            font-size: 14px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature div {
            width: 200px;
            text-align: center;
        }

        .signature .line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🍗 WARUNG AYAM GORENG LIMUS REGENCY</h1>
        <h2>SLIP GAJI KARYAWAN</h2>
    </div>

    <div class="info-row">
        <div class="info-col">
            <table>
                <tr>
                    <th>Nama</th>
                    <td>: <?= $gaji->nama ?></td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>: <?= $gaji->nip ?></td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>: <?= $gaji->jabatan ?></td>
                </tr>
            </table>
        </div>
        <div class="info-col">
            <table>
                <tr>
                    <th>Periode</th>
                    <td>: <?= $bulan_nama[(int) $gaji->bulan] ?> <?= $gaji->tahun ?></td>
                </tr>
                <tr>
                    <th>Hari Kerja</th>
                    <td>: <?= $gaji->total_hari_kerja ?> hari</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>: <?= ucfirst($gaji->status) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        <h3>PENDAPATAN</h3>
        <table class="detail-table">
            <tr>
                <td>Gaji Pokok</td>
                <td>Rp <?= number_format($gaji->gaji_pokok, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Tunjangan Kehadiran</td>
                <td>Rp <?= number_format($gaji->tunjangan_hadir, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Tunjangan Transport</td>
                <td>Rp <?= number_format($gaji->tunjangan_transport, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Tunjangan Makan</td>
                <td>Rp <?= number_format($gaji->tunjangan_makan, 0, ',', '.') ?></td>
            </tr>
            <?php if ($gaji->tunjangan_lainnya > 0): ?>
                <tr>
                    <td>Tunjangan Lainnya</td>
                    <td>Rp <?= number_format($gaji->tunjangan_lainnya, 0, ',', '.') ?></td>
                </tr>
            <?php endif; ?>
            <tr class="total-row">
                <td>Total Pendapatan</td>
                <td>Rp <?= number_format($gaji->gaji_pokok + $gaji->total_tunjangan, 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>POTONGAN</h3>
        <table class="detail-table">
            <tr>
                <td>Potongan Absen</td>
                <td>Rp <?= number_format($gaji->potongan_absen, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Potongan Keterlambatan</td>
                <td>Rp <?= number_format($gaji->potongan_terlambat, 0, ',', '.') ?></td>
            </tr>
            <?php if ($gaji->potongan_lainnya > 0): ?>
                <tr>
                    <td>Potongan Lainnya</td>
                    <td>Rp <?= number_format($gaji->potongan_lainnya, 0, ',', '.') ?></td>
                </tr>
            <?php endif; ?>
            <tr class="total-row">
                <td>Total Potongan</td>
                <td>Rp <?= number_format($gaji->total_potongan, 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table class="detail-table">
            <tr class="net-row">
                <td>GAJI BERSIH (TAKE HOME PAY)</td>
                <td>Rp <?= number_format($gaji->gaji_bersih, 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>

    <div class="signature">
        <div>
            <p>Diterima oleh,</p>
            <div class="line"><?= $gaji->nama ?></div>
        </div>
        <div>
            <p>Disetujui oleh,</p>
            <div class="line">HRD</div>
        </div>
    </div>

    <div class="footer">
        <p>Slip gaji ini diterbitkan secara elektronik dan sah tanpa tanda tangan.</p>
        <p>Dicetak: <?= date('d/m/Y H:i') ?></p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">🖨️ Cetak</button>
        <button onclick="window.close()">✖ Tutup</button>
    </div>
</body>

</html>