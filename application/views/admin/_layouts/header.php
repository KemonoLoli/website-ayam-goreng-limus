<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px;">
            <i class="icon icon-lg cil-menu"></i>
        </button>

        <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item">
                <a class="nav-link" href="<?= admin_url('dashboard') ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= admin_url('pos') ?>">POS</a>
            </li>
        </ul>

        <ul class="header-nav ms-auto">
            <!-- Notifications -->
            <?php
            // Get dynamic notifications
            $CI =& get_instance();
            $notifications = [];

            // 1. Low stock items (stok <= stok_minimum)
            $CI->db->select('nama_bahan, stok, satuan, stok_minimum');
            $CI->db->where('stok <= stok_minimum');
            $CI->db->order_by('stok', 'ASC');
            $CI->db->limit(3);
            $low_stock = $CI->db->get('bahan')->result();
            foreach ($low_stock as $item) {
                $notifications[] = [
                    'icon' => 'cil-warning',
                    'color' => 'warning',
                    'message' => 'Stok ' . $item->nama_bahan . ' menipis (' . $item->stok . ' ' . $item->satuan . ')',
                    'link' => admin_url('bahan'),
                    'time' => 'Stok minimum: ' . $item->stok_minimum
                ];
            }

            // 2. Pending orders (waiting to be processed)
            $CI->db->select('kode_transaksi, id_transaksi, created_at, tipe_pemesanan');
            $CI->db->where_in('status', ['pending', 'dikonfirmasi']);
            $CI->db->order_by('created_at', 'DESC');
            $CI->db->limit(3);
            $pending_orders = $CI->db->get('transaksi')->result();
            foreach ($pending_orders as $order) {
                $notifications[] = [
                    'icon' => 'cil-cart',
                    'color' => 'info',
                    'message' => 'Pesanan ' . $order->kode_transaksi . ' (' . ucfirst($order->tipe_pemesanan) . ')',
                    'link' => admin_url('transaksi/detail/' . $order->id_transaksi),
                    'time' => time_ago($order->created_at)
                ];
            }

            $notification_count = count($notifications);
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button">
                    <i class="icon icon-lg cil-bell"></i>
                    <?php if ($notification_count > 0): ?>
                        <span class="badge badge-sm bg-danger ms-1 position-absolute"
                            style="top: 5px; right: 5px;"><?= $notification_count ?></span>
                    <?php endif; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0" style="min-width: 320px;">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top">
                        Notifikasi <?= $notification_count > 0 ? "($notification_count)" : '' ?>
                    </div>
                    <?php if (empty($notifications)): ?>
                        <div class="dropdown-item text-center text-body-secondary py-3">
                            <i class="cil-check-circle text-success me-1"></i> Tidak ada notifikasi
                        </div>
                    <?php else: ?>
                        <?php foreach ($notifications as $notif): ?>
                            <a class="dropdown-item" href="<?= $notif['link'] ?>">
                                <i class="<?= $notif['icon'] ?> text-<?= $notif['color'] ?> me-2"></i>
                                <?= $notif['message'] ?>
                                <small class="text-body-secondary d-block"><?= $notif['time'] ?></small>
                            </a>
                        <?php endforeach; ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="<?= admin_url('transaksi?status=pending') ?>">
                            Lihat Pesanan Pending
                        </a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>

        <ul class="header-nav">
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>

            <!-- Theme Toggle -->
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button"
                    data-coreui-toggle="dropdown">
                    <i class="icon icon-lg cil-contrast theme-icon-active"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 8rem;">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="light">
                            <i class="icon icon-lg me-3 cil-sun"></i> Light
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="dark">
                            <i class="icon icon-lg me-3 cil-moon"></i> Dark
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center active" type="button"
                            data-coreui-theme-value="auto">
                            <i class="icon icon-lg me-3 cil-contrast"></i> Auto
                        </button>
                    </li>
                </ul>
            </li>

            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>

            <!-- User Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link py-0 pe-0 d-flex align-items-center" data-coreui-toggle="dropdown" href="#"
                    role="button">
                    <div class="avatar avatar-md me-2">
                        <div class="avatar-placeholder avatar-md">
                            <?= isset($current_user) ? get_initials($current_user->nama_lengkap) : 'U' ?>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-semibold small">
                            <?= isset($current_user) ? $current_user->nama_lengkap : 'User' ?>
                        </div>
                        <div class="text-body-secondary small">
                            <?= isset($current_user) ? role_label($current_user->role) : '' ?>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                        Akun
                    </div>
                    <a class="dropdown-item" href="<?= admin_url('profile') ?>">
                        <i class="cil-user me-2"></i> Profil Saya
                    </a>
                    <a class="dropdown-item" href="<?= admin_url('profile/password') ?>">
                        <i class="cil-lock-locked me-2"></i> Ganti Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= admin_url('logout') ?>">
                        <i class="cil-account-logout me-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <!-- Breadcrumb -->
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                <li class="breadcrumb-item">
                    <a href="<?= site_url() ?>" target="_blank" title="Ke Landing Page"><i class="cil-home"></i></a>
                </li>
                <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
                    <?php foreach ($breadcrumbs as $label => $url): ?>
                        <?php if ($url): ?>
                            <li class="breadcrumb-item"><a href="<?= $url ?>"><?= $label ?></a></li>
                        <?php else: ?>
                            <li class="breadcrumb-item active"><?= $label ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="breadcrumb-item active"><?= isset($page_title) ? $page_title : 'Dashboard' ?></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</header>