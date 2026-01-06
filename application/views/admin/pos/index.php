<style>
    .pos-container {
        display: flex;
        gap: 1rem;
        height: calc(100vh - 200px);
        min-height: 600px;
    }

    .menu-section {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .cart-section {
        width: 380px;
        display: flex;
        flex-direction: column;
    }

    .category-nav {
        background: white;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .category-btn {
        border: none;
        background: #f1f5f9;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .category-btn:hover,
    .category-btn.active {
        background: var(--cui-primary);
        color: white;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 0.75rem;
        overflow-y: auto;
        flex: 1;
        padding: 0.5rem;
    }

    .menu-item {
        background: white;
        border-radius: 0.75rem;
        padding: 0.75rem;
        text-align: center;
        cursor: pointer;
        transition: box-shadow 0.2s ease;
        border: 2px solid transparent;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    .menu-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-color: var(--cui-primary);
    }

    .menu-item.selected {
        border-color: var(--cui-primary);
    }

    .menu-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        background: #f1f5f9;
    }

    .menu-item .name {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-item .price {
        color: var(--cui-primary);
        font-weight: 700;
        font-size: 0.9rem;
    }

    .cart-card {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .cart-card .card-header {
        background: var(--cui-card-bg, #fff);
        color: var(--cui-body-color, #212529) !important;
    }

    .cart-card .card-header span,
    .cart-card .card-header i {
        color: var(--cui-body-color, #212529) !important;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 0;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item .info {
        flex: 1;
    }

    .cart-item .name {
        font-weight: 600;
        font-size: 0.9rem;
    }

    .cart-item .price {
        color: var(--cui-primary);
        font-size: 0.85rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .qty-control button {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1px solid #dee2e6;
        background: white;
        cursor: pointer;
    }

    .qty-control button:hover {
        background: #f8f9fa;
    }

    .qty-control span {
        width: 30px;
        text-align: center;
        font-weight: 600;
    }

    .cart-summary {
        padding: 1rem;
        border-top: 2px solid #e9ecef;
        background: #f8fafc;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .summary-row.total {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--cui-primary);
        border-top: 1px solid #dee2e6;
        padding-top: 0.5rem;
        margin-top: 0.5rem;
    }

    .empty-cart {
        text-align: center;
        padding: 2rem;
        color: #94a3b8;
    }

    .empty-cart i {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 992px) {
        .pos-container {
            flex-direction: column;
            height: auto;
        }

        .cart-section {
            width: 100%;
        }
    }

    /* Dark mode support */
    [data-coreui-theme="dark"] .cart-summary {
        background: var(--cui-body-bg, #1e1e2d);
        border-top-color: var(--cui-border-color, #3c4b64);
    }

    [data-coreui-theme="dark"] .summary-row {
        color: var(--cui-body-color, #e9ecef);
    }

    [data-coreui-theme="dark"] .summary-row.total {
        border-top-color: var(--cui-border-color, #3c4b64);
    }

    [data-coreui-theme="dark"] .cart-item {
        border-bottom-color: var(--cui-border-color, #3c4b64);
        color: var(--cui-body-color, #e9ecef);
    }

    [data-coreui-theme="dark"] .cart-item .name,
    [data-coreui-theme="dark"] .cart-item .info {
        color: var(--cui-body-color, #e9ecef);
    }

    [data-coreui-theme="dark"] .empty-cart {
        color: var(--cui-secondary-color, #9da5b1);
    }

    [data-coreui-theme="dark"] .menu-item {
        background: var(--cui-card-bg, #2c2c3e);
        color: var(--cui-body-color, #e9ecef);
    }

    [data-coreui-theme="dark"] .menu-item .name {
        color: var(--cui-body-color, #e9ecef);
    }

    [data-coreui-theme="dark"] .category-nav {
        background: var(--cui-card-bg, #2c2c3e);
    }

    [data-coreui-theme="dark"] .category-btn {
        background: var(--cui-tertiary-bg, #3c4b64);
        color: var(--cui-body-color, #e9ecef);
    }

    [data-coreui-theme="dark"] .qty-control button {
        background: var(--cui-tertiary-bg, #3c4b64);
        border-color: var(--cui-border-color, #3c4b64);
        color: var(--cui-body-color, #e9ecef);
    }

    [data-coreui-theme="dark"] .cart-card .card-header {
        color: #ffffff !important;
    }

    [data-coreui-theme="dark"] .cart-card .card-header span {
        color: #ffffff !important;
    }

    [data-coreui-theme="dark"] .cart-card .card-header i {
        color: #ffffff !important;
    }
</style>

<div class="pos-container">
    <!-- Menu Section -->
    <div class="menu-section">
        <!-- Category Filter -->
        <div class="category-nav">
            <button class="category-btn active" data-kategori="all">Semua</button>
            <?php foreach ($categories as $cat): ?>
                <button class="category-btn" data-kategori="<?= $cat->id_kategori ?>">
                    <?= $cat->nama_kategori ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Menu Grid -->
        <div class="menu-grid" id="menuGrid">
            <?php foreach ($menus as $menu): ?>
                <div class="menu-item" data-id="<?= $menu->id_menu ?>" data-nama="<?= htmlspecialchars($menu->nama_menu) ?>"
                    data-harga="<?= $menu->harga_promo ?: $menu->harga ?>" data-kategori="<?= $menu->id_kategori ?>">
                    <img src="<?= $menu->gambar ? base_url('uploads/menu/' . $menu->gambar) : base_url('assets/img/no-image.png') ?>"
                        alt="<?= $menu->nama_menu ?>" onerror="this.src='<?= base_url('assets/img/no-image.png') ?>'">
                    <div class="name" title="<?= $menu->nama_menu ?>"><?= $menu->nama_menu ?></div>
                    <div class="price"><?= format_rupiah($menu->harga_promo ?: $menu->harga) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Cart Section -->
    <div class="cart-section">
        <div class="card cart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="cil-cart me-2"></i>Keranjang</span>
                <button type="button" class="btn btn-sm btn-outline-danger" id="clearCart" title="Kosongkan"
                    onclick="clearCartAction(); return false;"><i class="cil-trash"></i></button>
            </div>

            <!-- Order Type -->
            <div class="card-body py-2 border-bottom">
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="tipe_pemesanan" id="tipe_dinein" value="dinein" checked>
                    <label class="btn btn-outline-primary btn-sm" for="tipe_dinein">Dine In</label>

                    <input type="radio" class="btn-check" name="tipe_pemesanan" id="tipe_takeaway" value="takeaway">
                    <label class="btn btn-outline-primary btn-sm" for="tipe_takeaway">Take Away</label>

                    <input type="radio" class="btn-check" name="tipe_pemesanan" id="tipe_delivery" value="delivery">
                    <label class="btn btn-outline-primary btn-sm" for="tipe_delivery">Delivery</label>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="cart-items" id="cartItems">
                <div class="empty-cart">
                    <i class="cil-cart"></i>
                    <p>Keranjang kosong</p>
                    <small>Klik menu untuk menambahkan</small>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Diskon</span>
                    <span id="diskon">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>TOTAL</span>
                    <span id="total">Rp 0</span>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary w-100 btn-lg" id="btnCheckout" disabled>
                    <i class="cil-check me-2"></i>Bayar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pembayaran</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="checkoutForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="items" id="checkoutItems">
                    <input type="hidden" name="tipe_pemesanan" id="checkoutTipe">
                    <input type="hidden" name="diskon_persen" id="checkoutDiskon" value="0">
                    <input type="hidden" name="ongkir" id="checkoutOngkir" value="0">

                    <div class="mb-3">
                        <label class="form-label">Total Tagihan</label>
                        <div class="fs-3 fw-bold text-primary" id="modalTotal">Rp 0</div>
                    </div>

                    <!-- Dine-in fields -->
                    <div id="dineinFields">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_pelanggan_dinein" id="nama_dinein"
                                placeholder="Masukkan nama pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Meja</label>
                            <input type="text" class="form-control" name="no_meja" placeholder="Contoh: 5">
                        </div>
                    </div>

                    <!-- Takeaway fields -->
                    <div id="takeawayFields" style="display:none;">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_pelanggan_takeaway" id="nama_takeaway"
                                placeholder="Masukkan nama pelanggan">
                        </div>
                    </div>

                    <!-- Delivery fields -->
                    <div id="deliveryFields" style="display:none;">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_pelanggan" id="nama_delivery"
                                placeholder="Masukkan nama pelanggan">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control" name="no_hp_pelanggan">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control" name="alamat_pengiriman" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ongkir</label>
                            <input type="number" class="form-control" name="ongkir_input" value="0"
                                onchange="document.getElementById('checkoutOngkir').value=this.value; updateModalTotal();">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="metode_pembayaran" required>
                            <option value="cash">Tunai (Cash)</option>
                            <option value="qris">QRIS</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                    </div>

                    <div class="mb-3" id="cashFields">
                        <label class="form-label">Uang Diterima</label>
                        <input type="number" class="form-control form-control-lg" name="bayar" id="inputBayar"
                            placeholder="0" min="0">
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                onclick="setNominal(50000)">50K</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                onclick="setNominal(100000)">100K</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setUangPas()">Uang
                                Pas</button>
                        </div>
                    </div>

                    <div class="mb-3" id="changeDisplay" style="display:none;">
                        <label class="form-label">Kembalian</label>
                        <div class="fs-4 fw-bold text-success" id="kembalian">Rp 0</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="2"
                            placeholder="Catatan tambahan..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnProcess">
                    <i class="cil-check me-1"></i> Proses Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal with Transaction Summary -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="cil-check-circle me-2"></i>Transaksi Berhasil!</h5>
                <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Transaction Code -->
                <div class="text-center mb-3">
                    <span class="badge bg-dark fs-5 px-4 py-2" id="successKode">TRX-000000</span>
                </div>

                <!-- Transaction Summary -->
                <div class="card mb-3">
                    <div class="card-header py-2">
                        <strong>Ringkasan Pesanan</strong>
                    </div>
                    <ul class="list-group list-group-flush" id="summaryItems">
                        <!-- Items will be populated -->
                    </ul>
                </div>

                <!-- Payment Details -->
                <table class="table table-sm mb-0">
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-end" id="summarySubtotal">Rp 0</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td>Total</td>
                        <td class="text-end" id="summaryTotal">Rp 0</td>
                    </tr>
                    <tr>
                        <td>Bayar (<span id="summaryMetode">Cash</span>)</td>
                        <td class="text-end" id="summaryBayar">Rp 0</td>
                    </tr>
                    <tr class="table-success fw-bold">
                        <td>Kembalian</td>
                        <td class="text-end fs-5" id="successKembalian">Rp 0</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-primary" id="btnPrintReceipt">
                    <i class="cil-print me-1"></i> Cetak Struk
                </button>
                <button type="button" class="btn btn-primary" data-coreui-dismiss="modal" onclick="location.reload()">
                    <i class="cil-reload me-1"></i> Transaksi Baru
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Cart state
    let cart = [];
    let totalAmount = 0;

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
        initCategoryFilter();
        initMenuClick();
        initCartActions();
        initCheckout();
    });

    // Category filter
    function initCategoryFilter() {
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const kategori = this.dataset.kategori;
                document.querySelectorAll('.menu-item').forEach(item => {
                    if (kategori === 'all' || item.dataset.kategori === kategori) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // Menu click to add to cart
    function initMenuClick() {
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const harga = parseFloat(this.dataset.harga);

                addToCart(id, nama, harga);
            });
        });
    }

    // Add item to cart
    function addToCart(id, nama, harga) {
        const existing = cart.find(item => item.id_menu === id);
        if (existing) {
            existing.qty++;
        } else {
            cart.push({ id_menu: id, nama: nama, harga: harga, qty: 1 });
        }
        renderCart();
    }

    // Render cart
    function renderCart() {
        const container = document.getElementById('cartItems');

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="empty-cart">
                    <i class="cil-cart"></i>
                    <p>Keranjang kosong</p>
                    <small>Klik menu untuk menambahkan</small>
                </div>
            `;
            document.getElementById('btnCheckout').disabled = true;
            updateTotals();
            return;
        }

        let html = '';
        cart.forEach((item, index) => {
            html += `
                <div class="cart-item">
                    <div class="info">
                        <div class="name">${item.nama}</div>
                        <div class="price">${formatRupiah(item.harga)}</div>
                    </div>
                    <div class="qty-control">
                        <button onclick="changeQty(${index}, -1)">-</button>
                        <span>${item.qty}</span>
                        <button onclick="changeQty(${index}, 1)">+</button>
                    </div>
                    <button class="btn btn-sm text-danger ms-2" onclick="removeItem(${index})">
                        <i class="cil-x"></i>
                    </button>
                </div>
            `;
        });

        container.innerHTML = html;
        document.getElementById('btnCheckout').disabled = false;
        updateTotals();
    }

    // Change quantity
    function changeQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        renderCart();
    }

    // Remove item
    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    // Update totals
    function updateTotals() {
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.harga * item.qty;
        });

        totalAmount = subtotal;

        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('diskon').textContent = 'Rp 0';
        document.getElementById('total').textContent = formatRupiah(totalAmount);
    }

    // Clear cart action (called by onclick)
    function clearCartAction() {
        console.log('clearCartAction called, cart length:', cart.length);
        if (cart.length === 0) {
            console.log('Cart is empty');
            return;
        }
        // Clear the cart directly
        cart = [];
        renderCart();
        console.log('Cart cleared successfully');
    }

    // Cart actions
    function initCartActions() {
        // Order type change
        document.querySelectorAll('input[name="tipe_pemesanan"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const tipe = this.value;
                document.getElementById('dineinFields').style.display = tipe === 'dinein' ? '' : 'none';
                document.getElementById('takeawayFields').style.display = tipe === 'takeaway' ? '' : 'none';
                document.getElementById('deliveryFields').style.display = tipe === 'delivery' ? '' : 'none';
            });
        });
    }

    // Checkout
    function initCheckout() {
        document.getElementById('btnCheckout').addEventListener('click', openCheckoutModal);
        document.getElementById('btnProcess').addEventListener('click', processPayment);

        document.getElementById('inputBayar').addEventListener('input', updateChange);

        document.querySelector('select[name="metode_pembayaran"]').addEventListener('change', function () {
            const isCash = this.value === 'cash';
            document.getElementById('cashFields').style.display = isCash ? '' : 'none';
            document.getElementById('changeDisplay').style.display = isCash ? '' : 'none';
        });
    }

    function openCheckoutModal() {
        const tipe = document.querySelector('input[name="tipe_pemesanan"]:checked').value;
        document.getElementById('checkoutTipe').value = tipe;
        document.getElementById('modalTotal').textContent = formatRupiah(totalAmount);
        document.getElementById('checkoutItems').value = JSON.stringify(cart);

        document.getElementById('dineinFields').style.display = tipe === 'dinein' ? '' : 'none';
        document.getElementById('takeawayFields').style.display = tipe === 'takeaway' ? '' : 'none';
        document.getElementById('deliveryFields').style.display = tipe === 'delivery' ? '' : 'none';

        new coreui.Modal(document.getElementById('checkoutModal')).show();
    }

    function updateChange() {
        const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
        const kembalian = Math.max(0, bayar - totalAmount);
        document.getElementById('kembalian').textContent = formatRupiah(kembalian);
        document.getElementById('changeDisplay').style.display = bayar > 0 ? '' : 'none';
    }

    function setNominal(value) {
        document.getElementById('inputBayar').value = value;
        updateChange();
    }

    function setUangPas() {
        document.getElementById('inputBayar').value = totalAmount;
        updateChange();
    }

    function updateModalTotal() {
        const ongkir = parseFloat(document.querySelector('input[name="ongkir_input"]').value) || 0;
        document.getElementById('modalTotal').textContent = formatRupiah(totalAmount + ongkir);
    }

    function processPayment() {
        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);
        const tipe = formData.get('tipe_pemesanan');

        // Validate customer name based on order type
        let namaPelanggan = '';
        if (tipe === 'dinein') {
            namaPelanggan = formData.get('nama_pelanggan_dinein');
        } else if (tipe === 'takeaway') {
            namaPelanggan = formData.get('nama_pelanggan_takeaway');
        } else {
            namaPelanggan = formData.get('nama_pelanggan');
        }

        if (!namaPelanggan || namaPelanggan.trim() === '') {
            alert('Nama pelanggan harus diisi!');
            return;
        }

        // Validate payment
        const metode = formData.get('metode_pembayaran');
        if (metode === 'cash') {
            const bayar = parseFloat(formData.get('bayar')) || 0;
            if (bayar < totalAmount) {
                alert('Uang yang diterima kurang!');
                return;
            }
        } else {
            formData.set('bayar', totalAmount);
        }

        document.getElementById('btnProcess').disabled = true;
        document.getElementById('btnProcess').innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

        fetch('<?= admin_url('pos/process') ?>', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    coreui.Modal.getInstance(document.getElementById('checkoutModal')).hide();

                    // Populate transaction code
                    document.getElementById('successKode').textContent = data.data.kode_transaksi;

                    // Populate summary items from cart
                    const summaryItems = document.getElementById('summaryItems');
                    let itemsHtml = '';
                    cart.forEach(item => {
                        itemsHtml += `
                            <li class="list-group-item d-flex justify-content-between py-2">
                                <span>${item.nama} x ${item.qty}</span>
                                <span>${formatRupiah(item.harga * item.qty)}</span>
                            </li>
                        `;
                    });
                    summaryItems.innerHTML = itemsHtml;

                    // Populate payment details
                    document.getElementById('summarySubtotal').textContent = formatRupiah(totalAmount);
                    document.getElementById('summaryTotal').textContent = formatRupiah(data.data.total);

                    const metode = document.querySelector('select[name="metode_pembayaran"]').value;
                    document.getElementById('summaryMetode').textContent = metode.toUpperCase();

                    const bayar = parseFloat(document.getElementById('inputBayar').value) || data.data.total;
                    document.getElementById('summaryBayar').textContent = formatRupiah(bayar);
                    document.getElementById('successKembalian').textContent = formatRupiah(data.data.kembalian);

                    document.getElementById('btnPrintReceipt').onclick = function () {
                        window.open('<?= admin_url('pos/print_receipt/') ?>' + data.data.id_transaksi, '_blank');
                    };

                    new coreui.Modal(document.getElementById('successModal')).show();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                alert('Terjadi kesalahan!');
                console.error(err);
            })
            .finally(() => {
                document.getElementById('btnProcess').disabled = false;
                document.getElementById('btnProcess').innerHTML = '<i class="cil-check me-1"></i> Proses Pembayaran';
            });
    }
</script>