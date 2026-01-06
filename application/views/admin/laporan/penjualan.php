<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <div>
        <a href="<?= admin_url('laporan/export/penjualan?from=' . $date_from . '&to=' . $date_to) ?>" class="btn btn-success">
            <i class="cil-cloud-download me-1"></i> Export CSV
        </a>
        <a href="<?= admin_url('laporan') ?>" class="btn btn-outline-secondary">
            <i class="cil-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Dari</label>
                <input type="date" name="from" class="form-control form-control-sm" value="<?= $date_from ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai</label>
                <input type="date" name="to" class="form-control form-control-sm" value="<?= $date_to ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="cil-search"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= $summary->total_transaksi ?: 0 ?></div>
                <div>Total Transaksi</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= format_rupiah($summary->total_penjualan ?: 0) ?></div>
                <div>Total Penjualan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="fs-4 fw-bold"><?= format_rupiah($summary->rata_rata_transaksi ?: 0) ?></div>
                <div>Rata-rata per Transaksi</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Daily Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header">Grafik Penjualan Harian</div>
            <div class="card-body">
                <canvas id="salesChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Top Products -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">Top 10 Produk Terlaris</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Menu</th><th class="text-end">Qty</th><th class="text-end">Sales</th></tr>
                    </thead>
                    <tbody>
                        <?php if (empty($top_products)): ?>
                            <tr><td colspan="3" class="text-center py-3 text-body-secondary">Tidak ada data</td></tr>
                        <?php else: ?>
                            <?php foreach ($top_products as $p): ?>
                                <tr>
                                    <td><?= $p->nama_menu ?></td>
                                    <td class="text-end"><?= $p->total_qty ?></td>
                                    <td class="text-end"><?= format_rupiah($p->total_sales) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Daily Table -->
<div class="card">
    <div class="card-header">Data Harian</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th class="text-end">Transaksi</th>
                        <th class="text-end">Subtotal</th>
                        <th class="text-end">Diskon</th>
                        <th class="text-end">Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daily)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-body-secondary">Tidak ada data</td></tr>
                    <?php else: ?>
                        <?php foreach ($daily as $d): ?>
                            <tr>
                                <td><?= format_date($d->tanggal) ?></td>
                                <td class="text-end"><?= $d->total_transaksi ?></td>
                                <td class="text-end"><?= format_rupiah($d->total_subtotal) ?></td>
                                <td class="text-end text-danger"><?= format_rupiah($d->total_diskon) ?></td>
                                <td class="text-end fw-bold"><?= format_rupiah($d->total_penjualan) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_map(function($d) { return date('d/m', strtotime($d->tanggal)); }, $daily)) ?>,
        datasets: [{
            label: 'Penjualan',
            data: <?= json_encode(array_map(function($d) { return $d->total_penjualan; }, $daily)) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => 'Rp ' + value.toLocaleString('id-ID')
                }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
