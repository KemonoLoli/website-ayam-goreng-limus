<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('menu') ?>" class="btn btn-outline-secondary"><i class="cil-arrow-left me-1"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="cil-fastfood me-2"></i> Data Menu</div>
            <div class="card-body">
                <?php $is_edit = isset($menu); ?>

                <form method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control <?= form_error('nama_menu') ? 'is-invalid' : '' ?>"
                                    name="nama_menu" value="<?= $is_edit ? $menu->nama_menu : set_value('nama_menu') ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <select class="form-select" name="jenis">
                                    <?php
                                    $jenis_list = ['makanan' => 'Makanan', 'minuman' => 'Minuman', 'paket' => 'Paket', 'lainnya' => 'Lainnya'];
                                    $selected = $is_edit ? $menu->jenis : set_value('jenis');
                                    foreach ($jenis_list as $val => $label):
                                        ?>
                                        <option value="<?= $val ?>" <?= $selected === $val ? 'selected' : '' ?>><?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="id_kategori">
                                    <?php
                                    $selected_kat = $is_edit ? $menu->id_kategori : set_value('id_kategori');
                                    foreach ($categories as $val => $label): ?>
                                        <option value="<?= $val ?>" <?= $selected_kat == $val ? 'selected' : '' ?>>
                                            <?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi"
                            rows="3"><?= $is_edit ? $menu->deskripsi : set_value('deskripsi') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                        class="form-control <?= form_error('harga') ? 'is-invalid' : '' ?>" name="harga"
                                        value="<?= $is_edit ? $menu->harga : set_value('harga') ?>" required min="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga Promo</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="harga_promo"
                                        value="<?= $is_edit ? $menu->harga_promo : set_value('harga_promo') ?>" min="0">
                                </div>
                                <small class="text-body-secondary">Kosongkan jika tidak ada promo</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Menu</label>
                        <input type="file" class="form-control" name="gambar" accept="image/*">
                        <small class="text-body-secondary">Max 2MB. Format: JPG, PNG, GIF, WebP</small>
                        <?php if ($is_edit && $menu->gambar): ?>
                            <div class="mt-2">
                                <img src="<?= base_url('uploads/menu/' . $menu->gambar) ?>" alt="" width="100"
                                    class="rounded">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_aktif" value="1" id="is_aktif"
                                    <?= ($is_edit ? $menu->is_aktif : true) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_aktif">Aktif (tampil di POS)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_bestseller" value="1"
                                    id="is_bestseller" <?= ($is_edit && $menu->is_bestseller) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_bestseller">Tandai sebagai Bestseller</label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-check me-1"></i> <?= $is_edit ? 'Simpan Perubahan' : 'Tambah Menu' ?>
                        </button>
                        <a href="<?= admin_url('menu') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>