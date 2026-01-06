<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? $page_title : 'Login' ?></title>

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

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        .login-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--brand-orange), #e54d1a);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .login-header p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .login-body {
            padding: 2rem;
        }

        .brand-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .btn-login {
            background: var(--brand-orange);
            border-color: var(--brand-orange);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-login:hover {
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

        .input-group .form-control:focus {
            border-left: none;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--brand-orange);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="login-header">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" height="80" class="mb-3"
                    style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1)); border-radius: 50%;">
                <h1>Warung Limus Pojok</h1>
                <p>Sistem Manajemen Restoran</p>
            </div>

            <div class="login-body">
                <?php if (isset($error) && $error): ?>
                    <div class="alert alert-danger">
                        <i class="cil-warning me-2"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>

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

                <form action="<?= site_url('admin/login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username atau Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="cil-user"></i>
                            </span>
                            <input type="text" class="form-control" name="username" placeholder="Masukkan username"
                                value="<?= set_value('username') ?>" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="cil-lock-locked"></i>
                            </span>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Masukkan password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()"
                                id="toggleBtn" title="Tampilkan password">
                                <svg id="eyeHidden" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24">
                                    </path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                                <svg id="eyeVisible" style="display:none" xmlns="http://www.w3.org/2000/svg" width="18"
                                    height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="<?= site_url('admin/auth/forgot_password') ?>" class="text-decoration-none"
                            style="color: var(--brand-orange);">
                            Lupa Password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                        <i class="cil-lock-unlocked me-2"></i> Masuk
                    </button>
                </form>

                <div class="text-center">
                    <a href="<?= site_url() ?>" class="back-link">
                        <i class="cil-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-3 text-muted small">
            © <?= date('Y') ?> Warung Limus Pojok. All rights reserved.
        </div>
    </div>

    <!-- CoreUI JS -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.1.2/dist/js/coreui.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eyeHidden = document.getElementById('eyeHidden');
            const eyeVisible = document.getElementById('eyeVisible');
            const btn = document.getElementById('toggleBtn');

            if (pwd.type === 'password') {
                pwd.type = 'text';
                eyeHidden.style.display = 'none';
                eyeVisible.style.display = 'inline';
                btn.title = 'Sembunyikan password';
            } else {
                pwd.type = 'password';
                eyeHidden.style.display = 'inline';
                eyeVisible.style.display = 'none';
                btn.title = 'Tampilkan password';
            }
        }
    </script>
</body>

</html>