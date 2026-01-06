<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= $page_title ?> - Warung Limus</title>
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #FE5D26;
            --cream: #FAEDCA;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        .navbar-brand {
            color: var(--primary) !important;
            font-weight: 700;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: #e04e1d;
            border-color: #e04e1d;
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: #fff;
        }

        .menu-card {
            transition: transform 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .menu-img {
            height: 180px;
            object-fit: cover;
        }

        .category-filter .nav-link {
            color: #666;
            border-radius: 50px;
            padding: 8px 20px;
            margin: 0 5px;
        }

        .category-filter .nav-link.active {
            background: var(--primary);
            color: #fff;
        }

        .badge-bestseller {
            background: linear-gradient(135deg, #f39c12, #e74c3c);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url() ?>">Warung Limus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= site_url('menu') ?>">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('order') ?>">Pesan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('track') ?>">Lacak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="py-5 text-center" style="background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);">
        <div class="container">
            <h1 class="display-5 fw-bold">Menu Lengkap</h1>
            <p class="lead text-muted">Pilih hidangan favorit Anda</p>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="container mt-4">
        <ul class="nav justify-content-center category-filter flex-wrap">
            <li class="nav-item mb-2">
                <a class="nav-link <?= !$selected_category ? 'active' : '' ?>" href="<?= site_url('menu') ?>">Semua</a>
            </li>
            <?php foreach ($categories as $cat): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $selected_category == $cat->id_kategori ? 'active' : '' ?>"
                        href="<?= site_url('menu?kategori=' . $cat->id_kategori) ?>">
                        <?= $cat->nama_kategori ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Menu Grid -->
    <div class="container py-5">
        <div class="row g-4">
            <?php if (empty($menu_items)): ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Tidak ada menu dalam kategori ini</p>
                </div>
            <?php else: ?>
                <?php foreach ($menu_items as $menu): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card menu-card h-100 shadow-sm border-0">
                            <?php
                            $img = $menu->gambar && file_exists(FCPATH . 'uploads/menu/' . $menu->gambar)
                                ? base_url('uploads/menu/' . $menu->gambar)
                                : base_url('assets/img/restaurant/main-1.webp');
                            ?>
                            <img src="<?= $img ?>" class="card-img-top menu-img" alt="<?= $menu->nama_menu ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0"><?= $menu->nama_menu ?></h5>
                                    <?php if ($menu->is_bestseller): ?>
                                        <span class="badge badge-bestseller text-white">🔥 Best Seller</span>
                                    <?php endif; ?>
                                </div>
                                <p class="card-text text-muted small"><?= $menu->deskripsi ?: 'Menu lezat dari Warung Limus' ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php if ($menu->harga_promo && $menu->harga_promo < $menu->harga): ?>
                                            <del class="text-muted small">Rp<?= number_format($menu->harga, 0, ',', '.') ?></del>
                                            <span
                                                class="fw-bold text-danger fs-5">Rp<?= number_format($menu->harga_promo, 0, ',', '.') ?></span>
                                        <?php else: ?>
                                            <span
                                                class="fw-bold text-primary fs-5">Rp<?= number_format($menu->harga, 0, ',', '.') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="badge bg-light text-dark"><?= ucfirst($menu->jenis) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- CTA -->
    <div class="py-5 text-center" style="background: var(--cream);">
        <div class="container">
            <h3>Ingin Pesan Sekarang?</h3>
            <p class="text-muted">Pesan online untuk dine-in, takeaway, atau delivery</p>
            <a href="<?= site_url('order') ?>" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-cart-plus me-2"></i> Pesan Sekarang
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white text-center">
        <p class="mb-0">&copy; <?= date('Y') ?> Warung Ayam Goreng Limus Regency</p>
    </footer>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>