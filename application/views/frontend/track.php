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

        .status-badge {
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: #ffeaa7;
            color: #d35400;
        }

        .status-diproses {
            background: #81ecec;
            color: #00b894;
        }

        .status-dikirim {
            background: #74b9ff;
            color: #0984e3;
        }

        .status-selesai {
            background: #00b894;
            color: #fff;
        }

        .status-batal {
            background: #d63031;
            color: #fff;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ddd;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -24px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
        }

        .timeline-item.active::before {
            background: var(--primary);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url() ?>">Warung Limus</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('menu') ?>">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('order') ?>">Pesan</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= site_url('track') ?>">Lacak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="py-5 text-center" style="background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);">
        <div class="container">
            <h1 class="display-5 fw-bold"><i class="bi bi-search me-2"></i> Lacak Pesanan</h1>
            <p class="lead text-muted">Masukkan kode pesanan untuk melihat status</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Search Form -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <form method="get">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="text" name="code" class="form-control form-control-lg"
                                    placeholder="Masukkan kode pesanan (contoh: LMR-251210XXXX)"
                                    value="<?= htmlspecialchars($code ?? '') ?>" required>
                                <button type="submit" class="btn btn-primary px-4">Lacak</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i> <?= $error ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($order) && $order): ?>
                    <!-- Order Found -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0"><?= $order->kode_transaksi ?></h5>
                                    <small
                                        class="text-muted"><?= date('d M Y, H:i', strtotime($order->tgl_transaksi)) ?></small>
                                </div>
                                <span
                                    class="status-badge status-<?= $order->status ?>"><?= ucfirst($order->status) ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Order Status Timeline -->
                            <div class="timeline mb-4">
                                <?php
                                $statuses = ['pending' => 'Menunggu Konfirmasi', 'diproses' => 'Sedang Diproses', 'dikirim' => 'Dalam Pengiriman', 'selesai' => 'Selesai'];
                                $current_found = false;
                                foreach ($statuses as $key => $label):
                                    $is_active = !$current_found;
                                    if ($key === $order->status)
                                        $current_found = true;
                                    ?>
                                    <div class="timeline-item <?= $is_active ? 'active' : '' ?>">
                                        <strong><?= $label ?></strong>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Order Details -->
                            <h6 class="border-bottom pb-2 mb-3">Detail Pesanan</h6>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order->items as $item): ?>
                                        <tr>
                                            <td><?= $item->nama_menu ?></td>
                                            <td class="text-center"><?= $item->qty ?></td>
                                            <td class="text-end">Rp<?= number_format($item->total_harga, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold">
                                        <td colspan="2">Total</td>
                                        <td class="text-end text-primary">Rp<?= number_format($order->total, 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Customer Info -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h6>Info Pelanggan</h6>
                                    <p class="mb-1"><strong><?= $order->nama_pelanggan ?: 'Guest' ?></strong></p>
                                    <?php if ($order->no_hp_pelanggan): ?>
                                        <p class="mb-0 text-muted"><i class="bi bi-phone"></i> <?= $order->no_hp_pelanggan ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h6>Tipe Pesanan</h6>
                                    <p class="mb-0">
                                        <?php if ($order->tipe_pemesanan === 'dinein'): ?>
                                            <i class="bi bi-shop"></i> Dine-in
                                            <?= $order->no_meja ? '(Meja ' . $order->no_meja . ')' : '' ?>
                                        <?php elseif ($order->tipe_pemesanan === 'takeaway'): ?>
                                            <i class="bi bi-bag"></i> Take Away
                                        <?php else: ?>
                                            <i class="bi bi-bicycle"></i> Delivery
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif (!isset($code) || !$code): ?>
                    <!-- No search yet -->
                    <div class="text-center py-5">
                        <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                        <p class="text-muted mt-3">Masukkan kode pesanan Anda di atas</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white text-center">
        <p class="mb-0">&copy; <?= date('Y') ?> Warung Ayam Goreng Limus Regency</p>
    </footer>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>