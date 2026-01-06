<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('menu') ?>" class="btn btn-outline-secondary">
        <i class="cil-arrow-left me-1"></i> Kembali ke Menu
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <i class="cil-check me-2"></i> Proses Selesai
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="border rounded p-3">
                    <h3 class="text-success mb-0"><?= $updated ?></h3>
                    <small class="text-muted">Gambar Diupdate</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3">
                    <h3 class="text-primary mb-0"><?= $total ?></h3>
                    <small class="text-muted">Total Menu</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3">
                    <h3 class="text-info mb-0"><?= $total - $updated ?></h3>
                    <small class="text-muted">Tidak Diubah</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Detail Hasil</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Menu</th>
                        <th>Gambar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($results as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['menu'] ?></td>
                            <td>
                                <?php if ($r['image']): ?>
                                    <img src="<?= base_url('uploads/menu/' . $r['image']) ?>" alt="<?= $r['menu'] ?>"
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    <small class="ms-2 text-muted"><?= $r['image'] ?></small>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($r['status'] === 'updated'): ?>
                                    <span class="badge bg-success">Updated</span>
                                <?php elseif ($r['status'] === 'skipped'): ?>
                                    <span class="badge bg-secondary">Skipped</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">No Match</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>