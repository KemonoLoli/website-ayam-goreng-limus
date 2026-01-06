<!-- Page Header -->
<div class="page-header mb-4">
    <h1 class="page-title">Catat Pergerakan Stok</h1>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="cil-swap-horizontal me-2"></i>Form Pergerakan Stok
            </div>
            <div class="card-body">
                <form action="<?= admin_url('inventaris/create') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Bahan <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_bahan" required>
                            <option value="">-- Pilih Bahan --</option>
                            <?php foreach ($bahan as $b): ?>
                                <option value="<?= $b->id_bahan ?>">
                                    <?= $b->nama_bahan ?> (Stok: <?= number_format($b->stok, 0, ',', '.') ?>
                                    <?= $b->satuan ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Pergerakan <span class="text-danger">*</span></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="jenis_pergerakan" id="jenis_masuk" value="masuk"
                                required checked>
                            <label class="btn btn-outline-success" for="jenis_masuk">
                                <i class="cil-arrow-bottom me-1"></i> Masuk (Tambah)
                            </label>

                            <input type="radio" class="btn-check" name="jenis_pergerakan" id="jenis_keluar"
                                value="keluar">
                            <label class="btn btn-outline-danger" for="jenis_keluar">
                                <i class="cil-arrow-top me-1"></i> Keluar (Kurang)
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="qty" min="0.01" step="0.01" required
                            placeholder="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2"
                            placeholder="Contoh: Pembelian dari supplier, Pemakaian harian, dll"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-save me-1"></i> Simpan
                        </button>
                        <a href="<?= admin_url('inventaris') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>