<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Warung Limus Pojok</title>

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

        .reset-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        .reset-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .reset-header {
            background: linear-gradient(135deg, var(--brand-orange), #e54d1a);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .reset-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .reset-header p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .reset-body {
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
    </style>
</head>

<body>
    <div class="reset-container">
        <div class="card reset-card">
            <div class="reset-header">
                <i class="cil-lock-locked" style="font-size: 3rem; margin-bottom: 0.5rem;"></i>
                <h1>Reset Password</h1>
                <p>Masukkan password baru Anda</p>
            </div>

            <div class="reset-body">
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

                <form action="<?= site_url('admin/auth/do_reset_password') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= $token ?>">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="cil-lock-locked"></i>
                            </span>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Masukkan password baru" required minlength="6">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword('password', 'eye1')" title="Tampilkan password">
                                <i class="cil-low-vision" id="eye1"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="cil-lock-locked"></i>
                            </span>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm"
                                placeholder="Ulangi password baru" required minlength="6">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword('password_confirm', 'eye2')" title="Tampilkan password">
                                <i class="cil-low-vision" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit w-100 mb-3">
                        <i class="cil-save me-2"></i> Simpan Password Baru
                    </button>
                </form>

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
    <script>
        function togglePassword(inputId, iconId) {
            const pwd = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('cil-low-vision');
                icon.classList.add('cil-check-circle');
            } else {
                pwd.type = 'password';
                icon.classList.remove('cil-check-circle');
                icon.classList.add('cil-low-vision');
            }
        }
    </script>
</body>

</html>