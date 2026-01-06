<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('kategori/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-body-secondary">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($categories as $cat): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= $cat->nama_kategori ?></td>
                                <td><?= $cat->deskripsi ?: '-' ?></td>
                                <td><?= $cat->urutan ?></td>
                                <td>
                                    <?php if ($cat->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= admin_url('kategori/edit/' . $cat->id_kategori) ?>"
                                            class="btn btn-outline-primary"><i class="cil-pencil"></i></a>
                                        <a href="<?= admin_url('kategori/delete/' . $cat->id_kategori) ?>"
                                            class="btn btn-outline-danger" onclick="return confirm('Hapus kategori ini?')"><i
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
</div>