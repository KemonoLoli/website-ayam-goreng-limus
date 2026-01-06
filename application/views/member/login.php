<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login Member - Warung Limus</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 420px;
            width: 100%;
            padding: 2rem;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .brand-logo i {
            font-size: 2.5rem;
            color: white;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            padding: 0.75rem 1.5rem;
        }

        .btn-primary:hover {
            background: #e04e1d;
            border-color: #e04e1d;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(254, 93, 38, 0.25);
        }

        .member-benefits {
            background: var(--cream);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1.5rem;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .benefit-item:last-child {
            margin-bottom: 0;
        }

        .benefit-item i {
            color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <i class="bi bi-person-badge"></i>
            </div>

            <h4 class="text-center mb-1">Login Member</h4>
            <p class="text-center text-muted mb-4">Masuk ke akun member Anda</p>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Email atau No HP</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan email atau no HP"
                            value="<?= set_value('username') ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan password"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>
            </form>

            <div class="member-benefits">
                <h6 class="mb-2"><i class="bi bi-star-fill text-warning me-1"></i> Keuntungan Member</h6>
                <div class="benefit-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <small>Diskon 5% setiap transaksi</small>
                </div>
                <div class="benefit-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <small>Kumpulkan poin untuk ditukar rewards</small>
                </div>
                <div class="benefit-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <small>Lihat riwayat pesanan kapan saja</small>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted">Belum punya akun member?</small><br>
                <small>Hubungi kasir saat Anda berkunjung untuk mendaftar.</small>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <a href="<?= site_url() ?>" class="btn btn-outline-secondary flex-fill">
                    <i class="bi bi-house me-1"></i>Beranda
                </a>
                <a href="<?= site_url('order') ?>" class="btn btn-outline-primary flex-fill">
                    <i class="bi bi-cart-plus me-1"></i>Pesan
                </a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>