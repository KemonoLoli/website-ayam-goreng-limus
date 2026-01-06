<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('bahan') ?>" class="btn btn-outline-secondary"><i class="cil-arrow-left me-1"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php $is_edit = isset($bahan); ?>
                
                <form method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_bahan" 
                               value="<?= $is_edit ? $bahan->nama_bahan : set_value('nama_bahan') ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text" class="form-control" name="kategori_bahan" 
                                       value="<?= $is_edit ? $bahan->kategori_bahan : set_value('kategori_bahan') ?>"
                                       placeholder="Misal: Daging, Bumbu, Sayur">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Satuan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="satuan" 
                                       value="<?= $is_edit ? $bahan->satuan : set_value('satuan', 'kg') ?>" 
                                       placeholder="kg, ltr, pcs" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" class="form-control" name="stok" 
                                       value="<?= $is_edit ? $bahan->stok : 0 ?>" step="0.01" min="0"
                                       <?= $is_edit ? 'readonly' : '' ?>>
                                <?php if ($is_edit): ?>
                                    <small class="text-body-secondary">Gunakan menu adjust untuk mengubah stok</small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Stok Minimum</label>
                                <input type="number" class="form-control" name="stok_minimum" 
                                       value="<?= $is_edit ? $bahan->stok_minimum : 0 ?>" step="0.01" min="0">
                                <small class="text-body-secondary">Alert jika stok di bawah ini</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga/Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="harga_per_satuan" 
                                           value="<?= $is_edit ? $bahan->harga_per_satuan : 0 ?>" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-check me-1"></i> <?= $is_edit ? 'Simpan' : 'Tambah' ?>
                        </button>
                        <a href="<?= admin_url('bahan') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
