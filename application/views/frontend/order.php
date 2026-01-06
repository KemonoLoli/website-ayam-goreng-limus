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

        .menu-item {
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .menu-item:hover {
            border-color: var(--primary);
        }

        .menu-item.selected {
            border-color: var(--primary);
            background: rgba(254, 93, 38, 0.05);
        }

        .menu-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-sidebar {
            position: sticky;
            top: 80px;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            padding: 0;
            font-size: 14px;
        }

        .order-type-btn {
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .order-type-btn:hover,
        .order-type-btn.active {
            border-color: var(--primary);
            background: rgba(254, 93, 38, 0.05);
        }

        .order-type-btn i {
            font-size: 2rem;
            color: var(--primary);
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
                    <li class="nav-item"><a class="nav-link active" href="<?= site_url('order') ?>">Pesan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('track') ?>">Lacak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="py-4 text-center" style="background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);">
        <div class="container">
            <h1 class="h3 fw-bold"><i class="bi bi-cart-plus me-2"></i> Pesan Online</h1>
            <p class="text-muted mb-0">Pilih menu, isi data, dan tunggu pesanan Anda!</p>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="container mt-3">
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('order/submit') ?>" id="orderForm">
        <input type="hidden" name="items" id="itemsInput">
        <input type="hidden" name="metode_pembayaran" id="paymentMethod" value="cash">

        <div class="container py-4">
            <div class="row">
                <!-- Menu Selection -->
                <div class="col-lg-8 mb-4">

                    <!-- Order Type Selection -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h6 class="mb-3">Pilih Tipe Pemesanan</h6>
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="order-type-btn text-center active" data-type="dinein"
                                        onclick="selectOrderType('dinein')">
                                        <i class="bi bi-shop"></i>
                                        <div class="fw-semibold">Dine-in</div>
                                        <small class="text-muted">Makan di tempat</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="order-type-btn text-center" data-type="takeaway"
                                        onclick="selectOrderType('takeaway')">
                                        <i class="bi bi-bag"></i>
                                        <div class="fw-semibold">Take Away</div>
                                        <small class="text-muted">Bawa pulang</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="order-type-btn text-center" data-type="delivery"
                                        onclick="selectOrderType('delivery')">
                                        <i class="bi bi-bicycle"></i>
                                        <div class="fw-semibold">Delivery</div>
                                        <small class="text-muted">Antar ke rumah</small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="tipe" id="orderType" value="dinein">
                        </div>
                    </div>

                    <!-- Menu List by Category -->
                    <?php foreach ($categories as $cat): ?>
                        <?php if (!empty($cat->items)): ?>
                            <div class="card shadow-sm border-0 mb-3">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><?= $cat->nama_kategori ?></h6>
                                </div>
                                <div class="card-body p-0">
                                    <?php foreach ($cat->items as $menu): ?>
                                        <div class="menu-item d-flex align-items-center p-3" data-id="<?= $menu->id_menu ?>"
                                            data-name="<?= htmlspecialchars($menu->nama_menu) ?>"
                                            data-price="<?= $menu->harga_promo ?: $menu->harga ?>" onclick="toggleMenu(this)">
                                            <?php
                                            $img = $menu->gambar && file_exists(FCPATH . 'uploads/menu/' . $menu->gambar)
                                                ? base_url('uploads/menu/' . $menu->gambar)
                                                : base_url('assets/img/restaurant/main-1.webp');
                                            ?>
                                            <img src="<?= $img ?>" class="menu-img me-3" alt="<?= $menu->nama_menu ?>">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?= $menu->nama_menu ?></h6>
                                                <small class="text-muted"><?= $menu->deskripsi ?: '' ?></small>
                                            </div>
                                            <div class="text-end">
                                                <?php if ($menu->harga_promo && $menu->harga_promo < $menu->harga): ?>
                                                    <del
                                                        class="text-muted small d-block">Rp<?= number_format($menu->harga, 0, ',', '.') ?></del>
                                                    <span
                                                        class="fw-bold text-danger">Rp<?= number_format($menu->harga_promo, 0, ',', '.') ?></span>
                                                <?php else: ?>
                                                    <span
                                                        class="fw-bold text-primary">Rp<?= number_format($menu->harga, 0, ',', '.') ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Cart Sidebar -->
                <div class="col-lg-4">
                    <div class="cart-sidebar">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0"><i class="bi bi-cart3 me-2"></i> Keranjang</h6>
                            </div>
                            <div class="card-body" id="cartBody">
                                <p class="text-muted text-center py-4" id="emptyCart">Belum ada item dipilih</p>
                                <div id="cartItems"></div>
                                <hr class="d-none" id="cartDivider">
                                <div class="d-flex justify-content-between fw-bold d-none" id="cartTotal">
                                    <span>Total</span>
                                    <span class="text-primary" id="totalAmount">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Member Login/Info Section -->
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Akun Member</h6>
                                <?php if (isset($member) && $member): ?>
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Sudah Login</span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <?php if (isset($member) && $member): ?>
                                    <!-- Member is logged in -->
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            <?= substr($member->nama_lengkap, 0, 1) ?>
                                        </div>
                                        <div>
                                            <strong><?= $member->nama_lengkap ?></strong>
                                            <br><small class="text-muted"><i
                                                    class="bi bi-star-fill text-warning me-1"></i><?= number_format($konsumen->poin) ?>
                                                Poin</small>
                                        </div>
                                    </div>
                                    <div class="alert alert-success py-2 mb-3">
                                        <i class="bi bi-check-circle me-1"></i>
                                        <strong>Diskon Member <?= $member_discount ?>%</strong> akan diterapkan otomatis!
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="<?= site_url('member/dashboard') ?>"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                        </a>
                                        <a href="<?= site_url('member/logout') ?>" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <!-- Not logged in -->
                                    <p class="text-muted mb-3">Login sebagai member untuk mendapatkan diskon dan kumpulkan
                                        poin!</p>
                                    <a href="<?= site_url('member/login') ?>" class="btn btn-outline-primary w-100"
                                        onclick="localStorage.setItem('redirect_after_login', window.location.href);">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>Login Member
                                    </a>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">Atau lanjutkan pesan sebagai tamu</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0"><i class="bi bi-person me-2"></i>Info Pemesan</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" required
                                        value="<?= isset($konsumen) && $konsumen ? $konsumen->nama : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. HP / WhatsApp</label>
                                    <input type="tel" class="form-control" name="hp" placeholder="08xxx" required
                                        value="<?= isset($konsumen) && $konsumen ? $konsumen->no_hp : '' ?>">
                                </div>
                                <div class="mb-3" id="mejaField">
                                    <label class="form-label">Nomor Meja</label>
                                    <input type="text" class="form-control" name="meja" placeholder="1, 2, 3...">
                                </div>
                                <div class="mb-3 d-none" id="alamatField">
                                    <label class="form-label">Alamat Pengiriman</label>
                                    <textarea class="form-control" name="alamat"
                                        rows="2"><?= isset($konsumen) && $konsumen ? $konsumen->alamat : '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan (opsional)</label>
                                    <textarea class="form-control" name="catatan" rows="2"
                                        placeholder="Sambal terpisah, tidak pedas, dll"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="button" class="btn btn-primary btn-lg w-100 mt-3" id="submitBtn" disabled
                            onclick="showPaymentModal()">
                            <i class="bi bi-check-circle me-2"></i> Kirim Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Payment Method Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="paymentModalLabel">
                        <i class="bi bi-credit-card me-2"></i> Pilih Metode Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="payment-option text-center p-4 rounded-3 active" data-method="cash"
                                onclick="selectPayment('cash')">
                                <i class="bi bi-cash-stack" style="font-size: 2.5rem; color: var(--primary);"></i>
                                <div class="fw-semibold mt-2">Cash</div>
                                <small class="text-muted">Bayar di tempat</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="payment-option text-center p-4 rounded-3" data-method="qris"
                                onclick="selectPayment('qris')">
                                <i class="bi bi-qr-code" style="font-size: 2.5rem; color: var(--primary);"></i>
                                <div class="fw-semibold mt-2">QRIS</div>
                                <small class="text-muted">Scan QR Code</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="confirmOrder()">
                        <i class="bi bi-check-circle me-1"></i> Konfirmasi Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-option {
            border: 2px solid #ddd;
            cursor: pointer;
            transition: all 0.2s;
        }

        .payment-option:hover,
        .payment-option.active {
            border-color: var(--primary);
            background: rgba(254, 93, 38, 0.05);
        }
    </style>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white text-center mt-5">
        <p class="mb-0">&copy; <?= date('Y') ?> Warung Ayam Goreng Limus Regency</p>
    </footer>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        let cart = {};

        function formatRupiah(num) {
            return 'Rp' + num.toLocaleString('id-ID');
        }

        function selectOrderType(type) {
            document.querySelectorAll('.order-type-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.order-type-btn[data-type="${type}"]`).classList.add('active');
            document.getElementById('orderType').value = type;

            document.getElementById('mejaField').classList.toggle('d-none', type !== 'dinein');
            document.getElementById('alamatField').classList.toggle('d-none', type !== 'delivery');
        }

        function toggleMenu(el) {
            const id = el.dataset.id;
            const name = el.dataset.name;
            const price = parseInt(el.dataset.price);

            if (cart[id]) {
                delete cart[id];
                el.classList.remove('selected');
            } else {
                cart[id] = { id, name, price, qty: 1, note: '' };
                el.classList.add('selected');
            }
            updateCart();
        }

        function updateQty(id, delta) {
            if (cart[id]) {
                cart[id].qty = Math.max(1, cart[id].qty + delta);
                updateCart();
            }
        }

        function removeItem(id) {
            delete cart[id];
            document.querySelector(`.menu-item[data-id="${id}"]`)?.classList.remove('selected');
            updateCart();
        }

        function updateCart() {
            const items = Object.values(cart);
            const container = document.getElementById('cartItems');
            const empty = document.getElementById('emptyCart');
            const divider = document.getElementById('cartDivider');
            const totalDiv = document.getElementById('cartTotal');
            const totalAmount = document.getElementById('totalAmount');
            const submitBtn = document.getElementById('submitBtn');

            if (items.length === 0) {
                container.innerHTML = '';
                empty.classList.remove('d-none');
                divider.classList.add('d-none');
                totalDiv.classList.add('d-none');
                submitBtn.disabled = true;
                return;
            }

            empty.classList.add('d-none');
            divider.classList.remove('d-none');
            totalDiv.classList.remove('d-none');
            submitBtn.disabled = false;

            let html = '';
            let total = 0;

            items.forEach(item => {
                const subtotal = item.price * item.qty;
                total += subtotal;
                html += `
          <div class="cart-item">
            <div class="d-flex justify-content-between align-items-start">
              <div class="flex-grow-1">
                <div class="fw-semibold">${item.name}</div>
                <small class="text-muted">${formatRupiah(item.price)}</small>
              </div>
              <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeItem('${item.id}')">
                <i class="bi bi-x"></i>
              </button>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
              <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary qty-btn" onclick="updateQty('${item.id}', -1)">-</button>
                <span class="btn btn-outline-secondary qty-btn disabled">${item.qty}</span>
                <button type="button" class="btn btn-outline-secondary qty-btn" onclick="updateQty('${item.id}', 1)">+</button>
              </div>
              <span class="fw-bold">${formatRupiah(subtotal)}</span>
            </div>
          </div>
        `;
            });

            container.innerHTML = html;
            totalAmount.textContent = formatRupiah(total);
        }

        let paymentModal;

        document.addEventListener('DOMContentLoaded', function () {
            paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
        });

        function showPaymentModal() {
            const items = Object.values(cart);
            if (items.length === 0) {
                alert('Pilih minimal 1 menu!');
                return;
            }
            paymentModal.show();
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
            document.querySelector(`.payment-option[data-method="${method}"]`).classList.add('active');
            document.getElementById('paymentMethod').value = method;
        }

        function confirmOrder() {
            const items = Object.values(cart);
            document.getElementById('itemsInput').value = JSON.stringify(items);
            paymentModal.hide();
            document.getElementById('orderForm').submit();
        }
    </script>
</body>

</html>