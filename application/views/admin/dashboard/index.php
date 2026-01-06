<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="text-body-secondary mb-0">Selamat datang, <?= $current_user->nama_lengkap ?>! Ini adalah ringkasan
            operasional hari ini.</p>
    </div>
    <div>
        <span class="text-body-secondary">
            <i class="cil-calendar me-1"></i>
            <?= format_date(date('Y-m-d'), 'l, d F Y') ?>
        </span>
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <!-- Today's Sales -->
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white text-opacity-75 small text-uppercase mb-1">Penjualan Hari Ini</div>
                        <div class="fs-4 fw-semibold"><?= format_rupiah($today_sales) ?></div>
                    </div>
                    <div class="stat-icon bg-white bg-opacity-25 text-white">
                        <i class="cil-dollar"></i>
                    </div>
                </div>
                <div class="mt-3 small">
                    <span class="text-white text-opacity-75">Bulan ini:</span>
                    <span class="fw-semibold"><?= format_rupiah($monthly_sales) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Orders -->
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white text-opacity-75 small text-uppercase mb-1">Pesanan Hari Ini</div>
                        <div class="fs-4 fw-semibold"><?= $today_orders ?> pesanan</div>
                    </div>
                    <div class="stat-icon bg-white bg-opacity-25 text-white">
                        <i class="cil-cart"></i>
                    </div>
                </div>
                <div class="mt-3 small">
                    <span class="text-white text-opacity-75">Bulan ini:</span>
                    <span class="fw-semibold"><?= $monthly_orders ?> pesanan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white text-opacity-75 small text-uppercase mb-1">Pesanan Pending</div>
                        <div class="fs-4 fw-semibold"><?= $pending_orders ?> pesanan</div>
                    </div>
                    <div class="stat-icon bg-white bg-opacity-25 text-white">
                        <i class="cil-clock"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="<?= admin_url('transaksi?status=pending') ?>" class="text-white small">
                        Lihat detail <i class="cil-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Present -->
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white text-opacity-75 small text-uppercase mb-1">Karyawan Hadir</div>
                        <div class="fs-4 fw-semibold"><?= $employees_present ?> orang</div>
                    </div>
                    <div class="stat-icon bg-white bg-opacity-25 text-white">
                        <i class="cil-people"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="<?= admin_url('absensi') ?>" class="text-white small">
                        Lihat absensi <i class="cil-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Tables Row -->
<div class="row g-4 mb-4">
    <!-- Sales Chart -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Penjualan</span>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary active" id="btnWeekly"
                        onclick="switchChartPeriod('weekly')">Minggu</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnMonthly"
                        onclick="switchChartPeriod('monthly')">Bulan</button>
                </div>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="cil-warning text-warning me-2"></i>Stok Menipis</span>
                <a href="<?= admin_url('bahan') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($low_stock_items)): ?>
                    <div class="text-center py-4 text-body-secondary">
                        <i class="cil-check-circle fs-1 text-success mb-2"></i>
                        <p class="mb-0">Semua stok aman!</p>
                    </div>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($low_stock_items as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold"><?= $item->nama_bahan ?></div>
                                    <small class="text-body-secondary">Min: <?= $item->stok_minimum ?>
                                        <?= $item->satuan ?></small>
                                </div>
                                <span class="badge bg-danger"><?= $item->stok ?>         <?= $item->satuan ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Top Menu -->
<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Pesanan Terbaru</span>
                <a href="<?= admin_url('transaksi') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Tipe</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_orders)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-body-secondary">
                                        Belum ada pesanan hari ini
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= admin_url('transaksi/detail/' . $order->id_transaksi) ?>"
                                                class="fw-semibold text-decoration-none">
                                                <?= $order->kode_transaksi ?>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= ucfirst($order->tipe_pemesanan) ?></span>
                                        </td>
                                        <td><?= format_rupiah($order->total) ?></td>
                                        <td><?= status_badge($order->status, 'transaction') ?></td>
                                        <td class="text-body-secondary small"><?= time_ago($order->created_at) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Menu -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="cil-star text-warning me-2"></i>Menu Terlaris Bulan Ini
            </div>
            <div class="card-body p-0">
                <?php if (empty($top_menu)): ?>
                    <div class="text-center py-4 text-body-secondary">
                        <p class="mb-0">Belum ada data penjualan</p>
                    </div>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php $rank = 1;
                        foreach ($top_menu as $menu): ?>
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-primary rounded-circle me-3"
                                    style="width: 28px; height: 28px; line-height: 18px;">
                                    <?= $rank++ ?>
                                </span>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold"><?= $menu->nama_menu ?></div>
                                    <small class="text-body-secondary"><?= format_rupiah($menu->harga) ?></small>
                                </div>
                                <span class="badge bg-success"><?= $menu->total_qty ?> terjual</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<?php if (is_role(['master', 'owner', 'admin', 'kasir'])): ?>
    <div class="card mt-4">
        <div class="card-header">Aksi Cepat</div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= admin_url('pos') ?>" class="btn btn-primary">
                    <i class="cil-cart me-2"></i>Buka Kasir
                </a>
                <?php if (is_role(['master', 'owner', 'admin'])): ?>
                    <a href="<?= admin_url('menu/create') ?>" class="btn btn-outline-primary">
                        <i class="cil-plus me-2"></i>Tambah Menu
                    </a>
                    <a href="<?= admin_url('bahan/create') ?>" class="btn btn-outline-primary">
                        <i class="cil-plus me-2"></i>Tambah Stok
                    </a>
                    <a href="<?= admin_url('laporan/penjualan') ?>" class="btn btn-outline-secondary">
                        <i class="cil-chart me-2"></i>Laporan Penjualan
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<!-- Chart Script - Inline to ensure functions are available for onclick -->
<script>
    // Chart data from PHP
    const weeklyData = <?= json_encode($weekly_sales) ?>;
    const monthlyData = <?= json_encode($monthly_sales_chart) ?>;

    let salesChart = null;

    function createChart(data) {
        try {
            const canvas = document.getElementById('salesChart');
            if (!canvas) {
                console.error('Canvas element salesChart not found!');
                return;
            }

            const ctx = canvas.getContext('2d');
            if (!ctx) {
                console.error('Could not get 2d context from canvas!');
                return;
            }

            // Destroy existing chart if any
            if (salesChart) {
                salesChart.destroy();
            }

            if (!data || data.length === 0) {
                console.log('No data to display in chart');
                return;
            }

            salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => d.date),
                    datasets: [{
                        label: 'Penjualan',
                        data: data.map(d => parseInt(d.total) || 0),
                        backgroundColor: 'rgba(254, 93, 38, 0.8)',
                        borderColor: 'rgba(254, 93, 38, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return formatRupiah(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error creating chart:', error);
        }
    }

    function switchChartPeriod(period) {
        const btnWeekly = document.getElementById('btnWeekly');
        const btnMonthly = document.getElementById('btnMonthly');

        if (period === 'weekly') {
            btnWeekly.classList.add('active');
            btnMonthly.classList.remove('active');
            createChart(weeklyData);
        } else {
            btnWeekly.classList.remove('active');
            btnMonthly.classList.add('active');
            createChart(monthlyData);
        }
    }

    // Initialize chart on page load
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Chart !== 'undefined') {
            createChart(weeklyData);
        } else {
            console.error('Chart.js is not loaded!');
        }
    });
</script>