<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Laporan Laba/Rugi</h1>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<!-- Profit/Loss Statement -->
<div class="card">
    <div class="card-header">
        <strong>Laporan Laba/Rugi - <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?></strong>
    </div>
    <div class="card-body">
        <table class="table table-borderless">
            <tbody>
                <!-- Income -->
                <tr class="table-success">
                    <td><strong>PENDAPATAN</strong></td>
                    <td class="text-end"></td>
                </tr>
                <tr>
                    <td class="ps-4">Penjualan Menu</td>
                    <td class="text-end"><?= format_rupiah($income) ?></td>
                </tr>
                <tr class="border-bottom">
                    <td><strong>Total Pendapatan</strong></td>
                    <td class="text-end"><strong><?= format_rupiah($income) ?></strong></td>
                </tr>

                <!-- Expenses -->
                <tr class="table-danger mt-3">
                    <td><strong>PENGELUARAN</strong></td>
                    <td class="text-end"></td>
                </tr>
                <tr>
                    <td class="ps-4">Pembelian Bahan</td>
                    <td class="text-end"><?= format_rupiah($purchases) ?></td>
                </tr>
                <tr>
                    <td class="ps-4">Gaji Karyawan</td>
                    <td class="text-end"><?= format_rupiah($payroll) ?></td>
                </tr>
                <tr class="border-bottom">
                    <td><strong>Total Pengeluaran</strong></td>
                    <td class="text-end"><strong><?= format_rupiah($total_expense) ?></strong></td>
                </tr>

                <!-- Profit/Loss -->
                <tr class="<?= $profit >= 0 ? 'table-success' : 'table-danger' ?> fs-5">
                    <td><strong><?= $profit >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?></strong></td>
                    <td class="text-end">
                        <strong><?= format_rupiah(abs($profit)) ?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mt-2">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold"><?= format_rupiah($income) ?></div>
                <div>Total Pendapatan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold"><?= format_rupiah($total_expense) ?></div>
                <div>Total Pengeluaran</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card <?= $profit >= 0 ? 'bg-primary' : 'bg-warning' ?> text-white">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold"><?= format_rupiah(abs($profit)) ?></div>
                <div><?= $profit >= 0 ? 'Laba Bersih' : 'Rugi Bersih' ?></div>
            </div>
        </div>
    </div>
</div>