<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>
        <?= $page_title ?> - Warung Limus Member
    </title>
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #FE5D26;
            --cream: #FAEDCA;
            --dark: #243036;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-brand {
            color: var(--primary) !important;
            font-weight: 700;
        }

        .sidebar {
            background: var(--dark);
            min-height: calc(100vh - 56px);
            padding: 1.5rem 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left-color: var(--primary);
        }

        .sidebar .nav-link i {
            width: 24px;
        }

        .content-wrapper {
            flex: 1;
            padding: 1.5rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: #e04e1d;
            border-color: #e04e1d;
        }

        .badge-poin {
            background: linear-gradient(135deg, #f5af19, #f12711);
        }

        .stat-card {
            border-left: 4px solid var(--primary);
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        @media (max-width: 991px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url() ?>">
                <i class="bi bi-shop me-2"></i>Warung Limus
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#memberNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="memberNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url() ?>"><i class="bi bi-house"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('order') ?>"><i class="bi bi-cart-plus"></i> Pesan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                            data-bs-toggle="dropdown">
                            <span class="member-avatar">
                                <?= substr($current_member->nama_lengkap, 0, 1) ?>
                            </span>
                            <span class="d-none d-md-inline">
                                <?= $current_member->nama_lengkap ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('member/profile') ?>"><i
                                        class="bi bi-person me-2"></i>Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="<?= site_url('member/logout') ?>"><i
                                        class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 p-0 d-none d-lg-block">
                <div class="sidebar">
                    <nav class="nav flex-column">
                        <a class="nav-link <?= $this->uri->segment(2) == 'dashboard' || !$this->uri->segment(2) ? 'active' : '' ?>"
                            href="<?= site_url('member/dashboard') ?>">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                        <a class="nav-link <?= $this->uri->segment(2) == 'orders' ? 'active' : '' ?>"
                            href="<?= site_url('member/orders') ?>">
                            <i class="bi bi-receipt me-2"></i> Riwayat Pesanan
                        </a>
                        <a class="nav-link <?= $this->uri->segment(2) == 'rewards' ? 'active' : '' ?>"
                            href="<?= site_url('member/rewards') ?>">
                            <i class="bi bi-gift me-2"></i> Poin & Rewards
                        </a>
                        <a class="nav-link <?= $this->uri->segment(2) == 'profile' ? 'active' : '' ?>"
                            href="<?= site_url('member/profile') ?>">
                            <i class="bi bi-person me-2"></i> Profil Saya
                        </a>
                        <hr class="mx-3 my-3 border-secondary">
                        <a class="nav-link" href="<?= site_url('order') ?>">
                            <i class="bi bi-cart-plus me-2"></i> Pesan Sekarang
                        </a>
                        <a class="nav-link text-danger" href="<?= site_url('member/logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10">
                <div class="content-wrapper">
                    <!-- Flash Messages -->
                    <?php if (!empty($flash_success)): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $flash_success ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($flash_error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $flash_error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($flash_info)): ?>
                        <div class="alert alert-info alert-dismissible fade show">
                            <?= $flash_info ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Page Content -->
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Nav -->
    <nav class="navbar navbar-light bg-white border-top fixed-bottom d-lg-none">
        <div class="container-fluid justify-content-around">
            <a class="nav-link text-center p-2 <?= $this->uri->segment(2) == 'dashboard' || !$this->uri->segment(2) ? 'text-primary' : '' ?>"
                href="<?= site_url('member/dashboard') ?>">
                <i class="bi bi-speedometer2 d-block"></i>
                <small>Dashboard</small>
            </a>
            <a class="nav-link text-center p-2 <?= $this->uri->segment(2) == 'orders' ? 'text-primary' : '' ?>"
                href="<?= site_url('member/orders') ?>">
                <i class="bi bi-receipt d-block"></i>
                <small>Pesanan</small>
            </a>
            <a class="nav-link text-center p-2 <?= $this->uri->segment(2) == 'rewards' ? 'text-primary' : '' ?>"
                href="<?= site_url('member/rewards') ?>">
                <i class="bi bi-gift d-block"></i>
                <small>Poin</small>
            </a>
            <a class="nav-link text-center p-2 <?= $this->uri->segment(2) == 'profile' ? 'text-primary' : '' ?>"
                href="<?= site_url('member/profile') ?>">
                <i class="bi bi-person d-block"></i>
                <small>Profil</small>
            </a>
        </div>
    </nav>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>