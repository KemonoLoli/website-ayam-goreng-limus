<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('kategori') ?>" class="btn btn-outline-secondary"><i class="cil-arrow-left me-1"></i>
        Kembali</a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php $is_edit = isset($kategori); ?>

                <form method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_kategori"
                            value="<?= $is_edit ? $kategori->nama_kategori : set_value('nama_kategori') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi"
                            rows="2"><?= $is_edit ? $kategori->deskripsi : set_value('deskripsi') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Urutan</label>
                                <input type="number" class="form-control" name="urutan"
                                    value="<?= $is_edit ? $kategori->urutan : 0 ?>" min="0">
                                <small class="text-body-secondary">Urutan tampil di POS (kecil = duluan)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                        id="is_active" <?= ($is_edit ? $kategori->is_active : true) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="is_active">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-check me-1"></i> <?= $is_edit ? 'Simpan' : 'Tambah' ?>
                        </button>
                        <a href="<?= admin_url('kategori') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>