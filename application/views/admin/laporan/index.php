<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="<?= admin_url('laporan/penjualan') ?>" class="text-decoration-none">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <i class="cil-chart-line text-primary mb-3" style="font-size: 3rem;"></i>
                    <h5 class="card-title">Laporan Penjualan</h5>
                    <p class="text-body-secondary small">Penjualan harian, bulanan, produk terlaris</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <a href="<?= admin_url('laporan/stok') ?>" class="text-decoration-none">
            <div class="card h-100 border-success">
                <div class="card-body text-center">
                    <i class="cil-layers text-success mb-3" style="font-size: 3rem;"></i>
                    <h5 class="card-title">Laporan Stok</h5>
                    <p class="text-body-secondary small">Stok bahan, stok menipis, pergerakan</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <a href="<?= admin_url('laporan/absensi') ?>" class="text-decoration-none">
            <div class="card h-100 border-warning">
                <div class="card-body text-center">
                    <i class="cil-calendar text-warning mb-3" style="font-size: 3rem;"></i>
                    <h5 class="card-title">Laporan Absensi</h5>
                    <p class="text-body-secondary small">Kehadiran, keterlambatan, izin</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <a href="<?= admin_url('laporan/penggajian') ?>" class="text-decoration-none">
            <div class="card h-100 border-info">
                <div class="card-body text-center">
                    <i class="cil-wallet text-info mb-3" style="font-size: 3rem;"></i>
                    <h5 class="card-title">Laporan Penggajian</h5>
                    <p class="text-body-secondary small">Gaji bulanan, total pengeluaran</p>
                </div>
            </div>
        </a>
    </div>
</div>