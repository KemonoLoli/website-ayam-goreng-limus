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
            background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
            min-height: 100vh;
        }

        .success-icon {
            font-size: 5rem;
            color: #27ae60;
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .order-code {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 2px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: #e04e1d;
            border-color: #e04e1d;
        }

        .info-box {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="info-box text-center">
                    <div class="success-icon mb-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h1 class="h3 fw-bold mb-3">Pesanan Berhasil Dikirim!</h1>
                    <p class="text-muted">Terima kasih telah memesan di Warung Limus</p>

                    <div class="my-4 py-4 bg-light rounded">
                        <p class="mb-2 text-muted">Kode Pesanan Anda</p>
                        <div class="order-code"><?= $order_code ?></div>
                        <p class="mt-3 mb-0">
                            <span class="fw-semibold">Total:</span>
                            <span class="text-primary fw-bold">Rp<?= number_format($order_total, 0, ',', '.') ?></span>
                        </p>
                    </div>

                    <div class="alert alert-info text-start mb-4">
                        <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i> Langkah Selanjutnya</h6>
                        <ol class="mb-0 ps-3">
                            <li>Simpan kode pesanan di atas</li>
                            <li>Tunggu konfirmasi dari tim kami</li>
                            <li>Siapkan pembayaran sesuai total</li>
                            <li>Lacak status pesanan kapan saja</li>
                        </ol>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="<?= site_url('track?code=' . $order_code) ?>" class="btn btn-primary btn-lg">
                            <i class="bi bi-search me-2"></i> Lacak Pesanan
                        </a>
                        <a href="<?= site_url() ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-2"></i> Kembali ke Beranda
                        </a>
                    </div>

                    <hr class="my-4">

                    <p class="text-muted small mb-0">
                        <i class="bi bi-clock me-1"></i> Pesanan biasanya diproses dalam 10-15 menit
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>