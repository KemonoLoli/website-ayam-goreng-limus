<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('supplier/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Tambah Supplier
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Supplier</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($suppliers)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-body-secondary">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($suppliers as $s): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= $s->nama_supplier ?></td>
                                <td><?= $s->kontak ?: '-' ?></td>
                                <td><?= $s->email ?: '-' ?></td>
                                <td><?= truncate($s->alamat, 50) ?: '-' ?></td>
                                <td>
                                    <?php if ($s->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= admin_url('supplier/edit/' . $s->id_supplier) ?>"
                                            class="btn btn-outline-primary"><i class="cil-pencil"></i></a>
                                        <a href="<?= admin_url('supplier/delete/' . $s->id_supplier) ?>"
                                            class="btn btn-outline-danger" onclick="return confirm('Hapus supplier ini?')"><i
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