<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('menu/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Tambah Menu
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat->id_kategori ?>" <?= $filters['id_kategori'] == $cat->id_kategori ? 'selected' : '' ?>>
                            <?= $cat->nama_kategori ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jenis</label>
                <select name="jenis" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="makanan" <?= $filters['jenis'] === 'makanan' ? 'selected' : '' ?>>Makanan</option>
                    <option value="minuman" <?= $filters['jenis'] === 'minuman' ? 'selected' : '' ?>>Minuman</option>
                    <option value="paket" <?= $filters['jenis'] === 'paket' ? 'selected' : '' ?>>Paket</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama menu..."
                    value="<?= $filters['search'] ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="cil-search"></i></button>
                <a href="<?= admin_url('menu') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
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
                        <th width="50">#</th>
                        <th width="60">Foto</th>
                        <th>Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($menus)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-body-secondary">Tidak ada data menu</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($menus as $menu): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <img src="<?= $menu->gambar ? base_url('uploads/menu/' . $menu->gambar) : base_url('assets/img/no-image.png') ?>"
                                        alt="" class="rounded" width="40" height="40" style="object-fit:cover;"
                                        onerror="this.src='<?= base_url('assets/img/no-image.png') ?>'">
                                </td>
                                <td>
                                    <div class="fw-semibold"><?= $menu->nama_menu ?></div>
                                    <small class="text-body-secondary"><?= $menu->kode_menu ?></small>
                                    <?php if ($menu->is_bestseller): ?>
                                        <span class="badge bg-warning text-dark ms-1">Bestseller</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $menu->nama_kategori ?: '-' ?></td>
                                <td>
                                    <?php if ($menu->harga_promo): ?>
                                        <del class="text-body-secondary small"><?= format_rupiah($menu->harga) ?></del><br>
                                        <span class="text-success fw-semibold"><?= format_rupiah($menu->harga_promo) ?></span>
                                    <?php else: ?>
                                        <?= format_rupiah($menu->harga) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($menu->is_aktif): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= admin_url('menu/edit/' . $menu->id_menu) ?>"
                                            class="btn btn-outline-primary"><i class="cil-pencil"></i></a>
                                        <a href="<?= admin_url('menu/toggle/' . $menu->id_menu) ?>"
                                            class="btn btn-outline-secondary" title="Toggle Status">
                                            <i class="cil-<?= $menu->is_aktif ? 'ban' : 'check' ?>"></i>
                                        </a>
                                        <a href="<?= admin_url('menu/delete/' . $menu->id_menu) ?>"
                                            class="btn btn-outline-danger" onclick="return confirm('Hapus menu ini?')"><i
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
        <small class="text-body-secondary">Total: <?= count($menus) ?> menu</small>
    </div>
</div>