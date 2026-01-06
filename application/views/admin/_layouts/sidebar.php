<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" height="32" class="me-2"
                style="border-radius: 50%;">
            <span class="sidebar-brand-text">Warung Limus</span>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
    </div>

    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link <?= active_menu('dashboard') ?>" href="<?= admin_url('dashboard') ?>">
                <i class="nav-icon cil-speedometer"></i> Dashboard
            </a>
        </li>

        <li class="nav-title">OPERASIONAL</li>

        <!-- POS / Kasir -->
        <?php if (is_role(['master', 'owner', 'admin', 'kasir', 'waiter'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('pos') ?>" href="<?= admin_url('pos') ?>">
                    <i class="nav-icon cil-cart"></i> Kasir (POS)
                </a>
            </li>
        <?php endif; ?>

        <!-- Transaksi -->
        <?php if (is_role(['master', 'owner', 'admin', 'kasir'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('transaksi') ?>" href="<?= admin_url('transaksi') ?>">
                    <i class="nav-icon cil-list"></i> Riwayat Transaksi
                </a>
            </li>
        <?php endif; ?>

        <!-- Dapur (Kitchen) -->
        <?php if (is_role(['master', 'owner', 'admin', 'koki'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('dapur') ?>" href="<?= admin_url('dapur') ?>">
                    <i class="nav-icon cil-restaurant"></i> Dapur
                </a>
            </li>
        <?php endif; ?>

        <!-- Delivery -->
        <?php if (is_role(['master', 'owner', 'admin', 'driver'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('delivery') ?>" href="<?= admin_url('delivery') ?>">
                    <i class="nav-icon cil-truck"></i> Delivery
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-title">MASTER DATA</li>

        <!-- Menu Management -->
        <?php if (is_role(['master', 'owner', 'admin'])): ?>
            <li class="nav-group <?= show_menu(['menu', 'kategori']) ?>">
                <a class="nav-link nav-group-toggle" href="#">
                    <i class="nav-icon cil-fastfood"></i> Menu
                </a>
                <ul class="nav-group-items compact">
                    <li class="nav-item">
                        <a class="nav-link <?= active_menu('kategori') ?>" href="<?= admin_url('kategori') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Kategori Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= active_menu('menu') ?>" href="<?= admin_url('menu') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Daftar Menu
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <!-- Customer -->
        <?php if (is_role(['master', 'owner', 'admin', 'kasir'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('konsumen') ?>" href="<?= admin_url('konsumen') ?>">
                    <i class="nav-icon cil-people"></i> Pelanggan
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-title">STOK & PEMBELIAN</li>

        <!-- Stock & Inventory -->
        <?php if (is_role(['master', 'owner', 'admin'])): ?>
            <li class="nav-group <?= show_menu(['bahan', 'inventaris']) ?>">
                <a class="nav-link nav-group-toggle" href="#">
                    <i class="nav-icon cil-layers"></i> Stok & Inventaris
                </a>
                <ul class="nav-group-items compact">
                    <li class="nav-item">
                        <a class="nav-link <?= active_menu('bahan') ?>" href="<?= admin_url('bahan') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Bahan / Stok
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= active_menu('inventaris') ?>" href="<?= admin_url('inventaris') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Inventaris
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Supplier & Purchase -->
            <li class="nav-group <?= show_menu(['supplier', 'pembelian']) ?>">
                <a class="nav-link nav-group-toggle" href="#">
                    <i class="nav-icon cil-factory"></i> Pembelian
                </a>
                <ul class="nav-group-items compact">
                    <li class="nav-item">
                        <a class="nav-link <?= active_menu('supplier') ?>" href="<?= admin_url('supplier') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Supplier
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= active_menu('pembelian') ?>" href="<?= admin_url('pembelian') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Pembelian Stok
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="nav-title">SDM</li>

        <!-- Attendance -->
        <li class="nav-item">
            <a class="nav-link <?= active_menu('absensi') ?>" href="<?= admin_url('absensi') ?>">
                <i class="nav-icon cil-calendar-check"></i> Absensi
            </a>
        </li>

        <!-- Payroll (Admin only) -->
        <?php if (is_role(['master', 'owner', 'admin'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('penggajian') ?>" href="<?= admin_url('penggajian') ?>">
                    <i class="nav-icon cil-wallet"></i> Penggajian
                </a>
            </li>

            <!-- Employee Management -->
            <li class="nav-item">
                <a class="nav-link <?= active_menu('karyawan') ?>" href="<?= admin_url('karyawan') ?>">
                    <i class="nav-icon cil-user"></i> Karyawan
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-title">LAPORAN</li>

        <!-- Reports -->
        <?php if (is_role(['master', 'owner', 'admin'])): ?>
            <li class="nav-group <?= show_menu(['laporan']) ?>">
                <a class="nav-link nav-group-toggle" href="#">
                    <i class="nav-icon cil-chart"></i> Laporan
                </a>
                <ul class="nav-group-items compact">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= admin_url('laporan/penjualan') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= admin_url('laporan/pembelian') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Pembelian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= admin_url('laporan/stok') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Stok
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= admin_url('laporan/absensi') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Absensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= admin_url('laporan/laba_rugi') ?>">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span> Laba/Rugi
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="nav-title">PENGATURAN</li>

        <!-- User Management (Admin+) -->
        <?php if (is_role(['master', 'owner', 'admin'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('user') ?>" href="<?= admin_url('user') ?>">
                    <i class="nav-icon cil-shield-alt"></i> Manajemen User
                </a>
            </li>
        <?php endif; ?>

        <!-- Settings -->
        <?php if (is_role(['master', 'owner'])): ?>
            <li class="nav-item">
                <a class="nav-link <?= active_menu('setting') ?>" href="<?= admin_url('setting') ?>">
                    <i class="nav-icon cil-settings"></i> Pengaturan
                </a>
            </li>
        <?php endif; ?>

    </ul>

    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button"
            onclick="document.getElementById('sidebar').classList.toggle('hide')">
        </button>
    </div>
</div>