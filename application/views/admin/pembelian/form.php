<!-- Page Header -->
<div class="page-header mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
</div>

<form method="post" action="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Detail Pembelian</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Supplier</label>
                                <select name="id_supplier" class="form-select">
                                    <option value="">-- Pilih Supplier --</option>
                                    <?php foreach ($suppliers as $s): ?>
                                        <option value="<?= $s->id_supplier ?>"><?= $s->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pembelian</label>
                                <input type="date" name="tgl_pembelian" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Item Pembelian</span>
                    <button type="button" class="btn btn-sm btn-success" onclick="addItem()">+ Tambah Item</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="items-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Bahan</th>
                                    <th width="100">Qty</th>
                                    <th width="150">Harga</th>
                                    <th width="150">Subtotal</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody id="items-body">
                                <tr class="item-row">
                                    <td>
                                        <select name="items[0][id_bahan]" class="form-select"
                                            onchange="updateSubtotal(this)">
                                            <option value="">-- Pilih Bahan --</option>
                                            <?php foreach ($bahan as $b): ?>
                                                <option value="<?= $b->id_bahan ?>"><?= $b->nama_bahan ?>
                                                    (<?= $b->satuan ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][qty]" class="form-control" min="1" value="1"
                                            onchange="updateSubtotal(this)">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][harga]" class="form-control" min="0"
                                            value="0" onchange="updateSubtotal(this)">
                                    </td>
                                    <td class="subtotal">Rp 0</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="removeItem(this)">×</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td id="grand-total"><strong>Rp 0</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">Simpan Pembelian</button>
                    <a href="<?= admin_url('pembelian') ?>" class="btn btn-secondary w-100">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let itemIndex = 1;

    function addItem() {
        const tbody = document.getElementById('items-body');
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
        <td>
            <select name="items[${itemIndex}][id_bahan]" class="form-select" onchange="updateSubtotal(this)">
                <option value="">-- Pilih Bahan --</option>
                <?php foreach ($bahan as $b): ?>
                    <option value="<?= $b->id_bahan ?>"><?= $b->nama_bahan ?> (<?= $b->satuan ?>)</option>
                <?php endforeach; ?>
            </select>
        </td>
        <td><input type="number" name="items[${itemIndex}][qty]" class="form-control" min="1" value="1" onchange="updateSubtotal(this)"></td>
        <td><input type="number" name="items[${itemIndex}][harga]" class="form-control" min="0" value="0" onchange="updateSubtotal(this)"></td>
        <td class="subtotal">Rp 0</td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(this)">×</button></td>
    `;
        tbody.appendChild(tr);
        itemIndex++;
    }

    function removeItem(btn) {
        const tbody = document.getElementById('items-body');
        if (tbody.children.length > 1) {
            btn.closest('tr').remove();
            calculateTotal();
        }
    }

    function updateSubtotal(el) {
        const row = el.closest('tr');
        const qty = parseInt(row.querySelector('input[name*="[qty]"]').value) || 0;
        const harga = parseInt(row.querySelector('input[name*="[harga]"]').value) || 0;
        const subtotal = qty * harga;
        row.querySelector('.subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseInt(row.querySelector('input[name*="[qty]"]').value) || 0;
            const harga = parseInt(row.querySelector('input[name*="[harga]"]').value) || 0;
            total += qty * harga;
        });
        document.getElementById('grand-total').innerHTML = '<strong>Rp ' + total.toLocaleString('id-ID') + '</strong>';
    }
</script>