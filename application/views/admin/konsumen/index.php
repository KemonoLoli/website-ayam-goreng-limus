<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Pelanggan</h1>
    <a href="<?= admin_url('konsumen/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Tambah Pelanggan
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-3">
                <select name="tipe" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option value="walk-in" <?= isset($filters['tipe']) && $filters['tipe'] == 'walk-in' ? 'selected' : '' ?>>Walk-in</option>
                    <option value="member" <?= isset($filters['tipe']) && $filters['tipe'] == 'member' ? 'selected' : '' ?>>Member</option>
                    <option value="vip" <?= isset($filters['tipe']) && $filters['tipe'] == 'vip' ? 'selected' : '' ?>>VIP
                    </option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/no hp..."
                    value="<?= isset($filters['search']) ? $filters['search'] : '' ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Customers Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Tipe</th>
                        <th>Poin</th>
                        <th>Total Transaksi</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($customers)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data pelanggan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($customers as $c): ?>
                            <tr>
                                <td><strong><?= $c->nama ?></strong></td>
                                <td><?= $c->no_hp ?: '-' ?></td>
                                <td><?= $c->email ?: '-' ?></td>
                                <td>
                                    <?php
                                    $badge = 'secondary';
                                    if ($c->tipe == 'member')
                                        $badge = 'primary';
                                    if ($c->tipe == 'vip')
                                        $badge = 'warning';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>"><?= ucfirst($c->tipe) ?></span>
                                </td>
                                <td><?= number_format($c->poin) ?></td>
                                <td><?= number_format($c->total_transaksi) ?></td>
                                <td>
                                    <a href="<?= admin_url('konsumen/edit/' . $c->id_konsumen) ?>"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="<?= admin_url('konsumen/delete/' . $c->id_konsumen) ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>