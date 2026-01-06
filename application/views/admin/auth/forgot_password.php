<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - Warung Limus Pojok</title>

    <!-- CoreUI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.1.2/dist/css/coreui.min.css" rel="stylesheet">
    <!-- CoreUI Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/icons@3.0.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --brand-orange: #FE5D26;
            --brand-orange-light: #F2C078;
            --brand-cream: #FAEDCA;
            --brand-green-light: #C1DBB3;
            --brand-green: #7EBC89;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(1200px 500px at 80% -20%, var(--brand-orange-light), transparent 60%),
                linear-gradient(180deg, var(--brand-cream), #fff 55%);
        }

        .forgot-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        .forgot-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .forgot-header {
            background: linear-gradient(135deg, var(--brand-orange), #e54d1a);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .forgot-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .forgot-header p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .forgot-body {
            padding: 2rem;
        }

        .btn-submit {
            background: var(--brand-orange);
            border-color: var(--brand-orange);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-submit:hover {
            background: #e54d1a;
            border-color: #e54d1a;
        }

        .form-control:focus {
            border-color: var(--brand-orange);
            box-shadow: 0 0 0 0.25rem rgba(254, 93, 38, 0.15);
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
        }

        .back-link {
            color: var(--brand-orange);
        }

        .back-link:hover {
            color: #e54d1a;
        }

        .input-group-text {
            background: #f8f9fa;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--brand-orange);
        }

        .reset-link-box {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            word-break: break-all;
            font-family: monospace;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <div class="forgot-container">
        <div class="card forgot-card">
            <div class="forgot-header">
                <i class="cil-lock-unlocked" style="font-size: 3rem; margin-bottom: 0.5rem;"></i>
                <h1>Lupa Password</h1>
                <p>Masukkan email untuk reset password</p>
            </div>

            <div class="forgot-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="cil-check-circle me-2"></i>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="cil-warning me-2"></i>
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="cil-warning me-2"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($reset_link)): ?>
                    <div class="alert alert-info">
                        <i class="cil-info me-2"></i>
                        <strong>Link Reset Password (Development Mode):</strong>
                    </div>
                    <div class="reset-link-box mb-3">
                        <a href="<?= $reset_link ?>">
                            <?= $reset_link ?>
                        </a>
                    </div>
                    <p class="text-muted small">Klik link di atas untuk mereset password Anda.</p>
                <?php else: ?>
                    <form action="<?= site_url('admin/auth/forgot_password') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="cil-envelope-closed"></i>
                                </span>
                                <input type="email" class="form-control" name="email" placeholder="Masukkan email Anda"
                                    value="<?= set_value('email') ?>" required autofocus>
                            </div>
                            <small class="text-muted">Masukkan email yang terdaftar di akun Anda.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-submit w-100 mb-3">
                            <i class="cil-send me-2"></i> Kirim Link Reset
                        </button>
                    </form>
                <?php endif; ?>

                <div class="text-center">
                    <a href="<?= site_url('admin/login') ?>" class="back-link">
                        <i class="cil-arrow-left me-1"></i> Kembali ke Login
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-3 text-muted small">
            ©
            <?= date('Y') ?> Warung Limus Pojok. All rights reserved.
        </div>
    </div>

    <!-- CoreUI JS -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.1.2/dist/js/coreui.bundle.min.js"></script>
</body>

</html>