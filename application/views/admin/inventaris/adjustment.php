<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('inventaris') ?>" class="btn btn-outline-secondary"><i class="cil-arrow-left me-1"></i>
        Kembali</a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="cil-transfer me-2"></i> Form Penyesuaian</div>
            <div class="card-body">
                <form method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Bahan <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_bahan" required>
                            <option value="">-- Pilih Bahan --</option>
                            <?php foreach ($bahan_list as $b): ?>
                                <option value="<?= $b->id_bahan ?>"><?= $b->nama_bahan ?> (Stok: <?= $b->stok ?>
                                    <?= $b->satuan ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Penyesuaian</label>
                        <div class="btn-group w-100">
                            <input type="radio" class="btn-check" name="jenis" id="jenis_masuk" value="masuk" checked>
                            <label class="btn btn-outline-success" for="jenis_masuk">
                                <i class="cil-arrow-bottom me-1"></i> Tambah Stok
                            </label>

                            <input type="radio" class="btn-check" name="jenis" id="jenis_keluar" value="keluar">
                            <label class="btn btn-outline-danger" for="jenis_keluar">
                                <i class="cil-arrow-top me-1"></i> Kurangi Stok
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="qty" min="0.01" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2"
                            placeholder="Alasan penyesuaian..."></textarea>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="cil-check me-1"></i> Simpan Penyesuaian
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>