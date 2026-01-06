<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('supplier') ?>" class="btn btn-outline-secondary"><i class="cil-arrow-left me-1"></i>
        Kembali</a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php $is_edit = isset($supplier); ?>

                <form method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_supplier"
                            value="<?= $is_edit ? $supplier->nama_supplier : set_value('nama_supplier') ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kontak / No. HP</label>
                                <input type="text" class="form-control" name="kontak"
                                    value="<?= $is_edit ? $supplier->kontak : set_value('kontak') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?= $is_edit ? $supplier->email : set_value('email') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat"
                            rows="2"><?= $is_edit ? $supplier->alamat : set_value('alamat') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2"
                            placeholder="Produk yang dijual, dll"><?= $is_edit ? $supplier->keterangan : set_value('keterangan') ?></textarea>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1" id="is_active"
                            <?= ($is_edit ? $supplier->is_active : true) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>

                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-check me-1"></i> <?= $is_edit ? 'Simpan' : 'Tambah' ?>
                        </button>
                        <a href="<?= admin_url('supplier') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>