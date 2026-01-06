<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('bahan/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Tambah Bahan
    </a>
</div>

<?php if ($low_stock_count > 0): ?>
    <div class="alert alert-warning">
        <i class="cil-warning me-2"></i>
        <strong>Perhatian!</strong> Ada <?= $low_stock_count ?> bahan dengan stok menipis.
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat->kategori_bahan ?>" <?= $filters['kategori'] === $cat->kategori_bahan ? 'selected' : '' ?>>
                            <?= $cat->kategori_bahan ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama bahan..."
                    value="<?= $filters['search'] ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="cil-search"></i></button>
                <a href="<?= admin_url('bahan') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th>Harga/Satuan</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bahan)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-body-secondary">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bahan as $b): ?>
                            <?php $is_low = $b->stok <= $b->stok_minimum; ?>
                            <tr class="<?= $is_low ? 'table-warning' : '' ?>">
                                <td><small class="text-body-secondary"><?= $b->kode_bahan ?></small></td>
                                <td class="fw-semibold"><?= $b->nama_bahan ?></td>
                                <td><?= $b->kategori_bahan ?: '-' ?></td>
                                <td class="text-center">
                                    <span class="badge bg-<?= $is_low ? 'danger' : 'success' ?> fs-6">
                                        <?= $b->stok ?>         <?= $b->satuan ?>
                                    </span>
                                    <small class="d-block text-body-secondary">Min: <?= $b->stok_minimum ?></small>
                                </td>
                                <td><?= format_rupiah($b->harga_per_satuan) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Quick adjust -->
                                        <button type="button" class="btn btn-outline-success" data-coreui-toggle="modal"
                                            data-coreui-target="#adjustModal"
                                            onclick="openAdjust(<?= $b->id_bahan ?>, '<?= $b->nama_bahan ?>', '<?= $b->satuan ?>')">
                                            <i class="cil-plus"></i>
                                        </button>
                                        <a href="<?= admin_url('bahan/edit/' . $b->id_bahan) ?>"
                                            class="btn btn-outline-primary"><i class="cil-pencil"></i></a>
                                        <a href="<?= admin_url('bahan/delete/' . $b->id_bahan) ?>"
                                            class="btn btn-outline-danger" onclick="return confirm('Hapus bahan ini?')"><i
                                                class="cil-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <small class="text-body-secondary">Total: <?= count($bahan) ?> bahan</small>
    </div>
</div>

<!-- Stock Adjust Modal -->
<div class="modal fade" id="adjustModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adjust Stok</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
            </div>
            <form method="post" id="adjustForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="mb-3"><strong id="adjustName"></strong></p>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-select">
                            <option value="add">Tambah Stok</option>
                            <option value="reduce">Kurangi Stok</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="qty" min="0" step="0.01" required>
                            <span class="input-group-text" id="adjustUnit"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAdjust(id, name, unit) {
        document.getElementById('adjustName').textContent = name;
        document.getElementById('adjustUnit').textContent = unit;
        document.getElementById('adjustForm').action = '<?= admin_url('bahan/adjust/') ?>' + id;
    }
</script>