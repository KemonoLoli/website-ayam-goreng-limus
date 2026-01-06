<!DOCTYPE html>
<html lang="id">

<head>
    <base href="<?= base_url() ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Warung Limus Pojok - Sistem Manajemen Restoran">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Warung Limus Pojok</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/favicon.png') ?>">

    <!-- CoreUI CSS (Local) -->
    <link href="<?= base_url('assets/coreui/css/coreui.min.css') ?>" rel="stylesheet">

    <!-- CoreUI Icons (Local) -->
    <link href="<?= base_url('assets/coreui/css/icons.min.css') ?>" rel="stylesheet">

    <!-- Custom Admin CSS -->
    <style>
        :root {
            --cui-primary: #FE5D26;
            --cui-primary-rgb: 254, 93, 38;
            --brand-color: #FE5D26;
            --brand-light: #F2C078;
            --brand-cream: #FAEDCA;
            --brand-green-light: #C1DBB3;
            --brand-green: #7EBC89;
            --cui-sidebar-width: 256px;
        }

        /* Fix sidebar layout - proper CoreUI structure */
        body {
            min-height: 100vh;
            min-height: 100dvh;
        }

        .sidebar {
            --cui-sidebar-bg: #1e293b;
            --cui-sidebar-nav-link-active-bg: var(--brand-color);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            width: var(--cui-sidebar-width);
            height: 100vh;
            height: 100dvh;
        }

        .sidebar.hide {
            margin-left: calc(-1 * var(--cui-sidebar-width));
        }

        .wrapper {
            margin-left: var(--cui-sidebar-width);
            transition: margin 0.3s;
        }

        .sidebar.hide~.wrapper {
            margin-left: 0;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: calc(-1 * var(--cui-sidebar-width));
            }

            .sidebar.show {
                margin-left: 0;
            }

            .wrapper {
                margin-left: 0;
            }
        }

        .sidebar-brand {
            background: linear-gradient(135deg, var(--brand-color), #e54d1a);
            padding: 1rem;
        }

        .sidebar-brand-text {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn-primary {
            --cui-btn-bg: var(--brand-color);
            --cui-btn-border-color: var(--brand-color);
            --cui-btn-hover-bg: #e54d1a;
            --cui-btn-hover-border-color: #e54d1a;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .stat-card {
            border-radius: 0.75rem;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .table th {
            font-weight: 600;
            color: #475569;
            border-top: none;
        }

        .badge {
            font-weight: 500;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
        }

        .avatar-md {
            width: 40px;
            height: 40px;
        }

        .avatar-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--brand-color);
            color: white;
            font-weight: 600;
            border-radius: 50%;
        }

        /* Sidebar active state */
        .sidebar-nav .nav-link.active {
            background: var(--brand-color) !important;
        }

        /* Better form styling */
        .form-label {
            font-weight: 500;
            color: #374151;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 0.25rem rgba(254, 93, 38, 0.15);
        }

        /* Alert styling */
        .alert {
            border: none;
            border-radius: 0.5rem;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        /* Toast positioning */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1100;
        }
    </style>

    <?php if (isset($extra_css))
        echo $extra_css; ?>
</head>

<body>
    <!-- Sidebar -->
    <?php $this->load->view('admin/_layouts/sidebar'); ?>

    <!-- Main wrapper -->
    <div class="wrapper d-flex flex-column min-vh-100">
        <!-- Header -->
        <?php $this->load->view('admin/_layouts/header'); ?>

        <!-- Main content -->
        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                <!-- Flash Messages -->
                <?= flash_messages() ?>

                <!-- Page Content -->
                <?= isset($content) ? $content : '' ?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer px-4">
            <div>
                <span class="text-body-secondary">© <?= date('Y') ?> Warung Limus Pojok</span>
            </div>
            <div class="ms-auto">
                <span class="text-body-secondary">Versi 1.0.0</span>
            </div>
        </footer>
    </div>

    <!-- CoreUI JS (Local) -->
    <script src="<?= base_url('assets/coreui/js/coreui.bundle.min.js') ?>"></script>

    <!-- Chart.js (Local) -->
    <script src="<?= base_url('assets/coreui/js/chart.min.js') ?>"></script>

    <script>
        // Initialize tooltips
        document.querySelectorAll('[data-coreui-toggle="tooltip"]').forEach(el => {
            new coreui.Tooltip(el);
        });

        // Initialize popovers
        document.querySelectorAll('[data-coreui-toggle="popover"]').forEach(el => {
            new coreui.Popover(el);
        });

        // AJAX setup with CSRF token
        const CSRF_TOKEN = '<?= $this->security->get_csrf_hash() ?>';
        const CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';
        const BASE_URL = '<?= base_url() ?>';

        // Format number as Rupiah
        function formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Confirm delete
        function confirmDelete(url, message = 'Apakah Anda yakin ingin menghapus data ini?') {
            if (confirm(message)) {
                window.location.href = url;
            }
            return false;
        }

        // Theme Switcher
        (function () {
            const getStoredTheme = () => localStorage.getItem('theme');
            const setStoredTheme = theme => localStorage.setItem('theme', theme);

            const getSystemTheme = () => {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const setTheme = theme => {
                if (theme === 'auto') {
                    // Auto = follow system preference
                    document.documentElement.setAttribute('data-coreui-theme', getSystemTheme());
                } else {
                    document.documentElement.setAttribute('data-coreui-theme', theme);
                }
            };

            const showActiveTheme = (theme) => {
                const themeSwitcher = document.querySelector('.theme-icon-active');
                if (!themeSwitcher) return;

                const themeSwitcherItems = document.querySelectorAll('[data-coreui-theme-value]');
                themeSwitcherItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.getAttribute('data-coreui-theme-value') === theme) {
                        item.classList.add('active');
                    }
                });

                // Update icon
                const iconMap = {
                    'light': 'cil-sun',
                    'dark': 'cil-moon',
                    'auto': 'cil-contrast'
                };
                themeSwitcher.className = 'icon icon-lg ' + (iconMap[theme] || 'cil-contrast') + ' theme-icon-active';
            };

            // Get stored theme or default to 'auto'
            const getActiveTheme = () => getStoredTheme() || 'auto';

            // Set initial theme on page load
            setTheme(getActiveTheme());

            // Listen for system preference changes (for auto mode)
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const storedTheme = getStoredTheme();
                // Only update if auto mode or no preference set
                if (!storedTheme || storedTheme === 'auto') {
                    setTheme('auto');
                }
            });

            // On DOM ready, set up click handlers
            window.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getActiveTheme());

                document.querySelectorAll('[data-coreui-theme-value]').forEach(toggle => {
                    toggle.addEventListener('click', () => {
                        const theme = toggle.getAttribute('data-coreui-theme-value');
                        setStoredTheme(theme);
                        setTheme(theme);
                        showActiveTheme(theme);
                    });
                });
            });

            // Debug: Log system theme
            console.log('System theme:', getSystemTheme());
            console.log('Stored theme:', getStoredTheme());
        })();
    </script>

    <?php if (isset($extra_js))
        echo $extra_js; ?>
</body>

</html>