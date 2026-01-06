<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('karyawan/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Tambah Karyawan
    </a>
</div>

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="aktif" <?= $filters['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $filters['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    <option value="cuti" <?= $filters['status'] === 'cuti' ? 'selected' : '' ?>>Cuti</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jabatan</label>
                <select name="jabatan" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <?php foreach (['Kasir', 'Koki', 'Waiter', 'Driver', 'Admin'] as $jbt): ?>
                        <option value="<?= $jbt ?>" <?= $filters['jabatan'] === $jbt ? 'selected' : '' ?>><?= $jbt ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama, NIP..."
                    value="<?= $filters['search'] ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="cil-search"></i></button>
                <a href="<?= admin_url('karyawan') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
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
                        <th>Karyawan</th>
                        <th>Jabatan</th>
                        <th>Kontak</th>
                        <th>Gaji Pokok</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($karyawan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-body-secondary">Tidak ada data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($karyawan as $k): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="fw-semibold"><?= $k->nama ?></div>
                                    <small class="text-body-secondary"><?= $k->nip ?></small>
                                </td>
                                <td><?= $k->jabatan ?></td>
                                <td>
                                    <div><?= $k->no_hp ?: '-' ?></div>
                                    <small class="text-body-secondary"><?= $k->email ?: '' ?></small>
                                </td>
                                <td><?= format_rupiah($k->gaji_pokok) ?></td>
                                <td><?= status_badge($k->status, 'employee') ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= admin_url('karyawan/edit/' . $k->id_karyawan) ?>"
                                            class="btn btn-outline-primary"><i class="cil-pencil"></i></a>
                                        <a href="<?= admin_url('karyawan/delete/' . $k->id_karyawan) ?>"
                                            class="btn btn-outline-danger" onclick="return confirm('Hapus karyawan ini?')"><i
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
        <small class="text-body-secondary">Total: <?= count($karyawan) ?> karyawan</small>
    </div>
</div>