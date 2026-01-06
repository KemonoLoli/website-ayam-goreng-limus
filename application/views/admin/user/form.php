<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('user') ?>" class="btn btn-outline-secondary">
        <i class="cil-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="cil-user me-2"></i> Data User
            </div>
            <div class="card-body">
                <?php $is_edit = isset($user); ?>

                <form method="post" action="">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>"
                                    name="username" value="<?= $is_edit ? $user->username : set_value('username') ?>"
                                    required>
                                <div class="invalid-feedback"><?= form_error('username') ?></div>
                                <small class="text-body-secondary">Minimal 3 karakter, tanpa spasi</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Password
                                    <?php if (!$is_edit): ?>
                                        <span class="text-danger">*</span>
                                    <?php else: ?>
                                        <small class="text-body-secondary">(kosongkan jika tidak diubah)</small>
                                    <?php endif; ?>
                                </label>
                                <input type="password"
                                    class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
                                    name="password" <?= !$is_edit ? 'required' : '' ?>>
                                <div class="invalid-feedback"><?= form_error('password') ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>"
                            name="nama_lengkap"
                            value="<?= $is_edit ? $user->nama_lengkap : set_value('nama_lengkap') ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama_lengkap') ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?= $is_edit ? $user->email : set_value('email') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="text" class="form-control" name="no_hp"
                                    value="<?= $is_edit ? $user->no_hp : set_value('no_hp') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select <?= form_error('role') ? 'is-invalid' : '' ?>" name="role"
                                    required>
                                    <option value="">-- Pilih Role --</option>
                                    <?php
                                    $roles = ['owner', 'admin', 'kasir', 'koki', 'waiter', 'driver', 'member'];
                                    if ($this->current_user->role === 'master')
                                        array_unshift($roles, 'master');
                                    $selected_role = $is_edit ? $user->role : set_value('role');
                                    foreach ($roles as $r):
                                        ?>
                                        <option value="<?= $r ?>" <?= $selected_role === $r ? 'selected' : '' ?>>
                                            <?= role_label($r) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= form_error('role') ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        id="is_active" <?= ($is_edit ? $user->is_active : true) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="is_active">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-check me-1"></i> <?= $is_edit ? 'Simpan Perubahan' : 'Tambah User' ?>
                        </button>
                        <a href="<?= admin_url('user') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="cil-info me-2"></i> Informasi Role
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Master:</strong> Akses penuh ke semua fitur</li>
                    <li class="mb-2"><strong>Owner:</strong> Pemilik restoran, akses penuh</li>
                    <li class="mb-2"><strong>Admin:</strong> Administrasi operasional</li>
                    <li class="mb-2"><strong>Kasir:</strong> POS & transaksi</li>
                    <li class="mb-2"><strong>Koki:</strong> Dapur & produksi</li>
                    <li class="mb-2"><strong>Waiter:</strong> Pesanan meja</li>
                    <li class="mb-2"><strong>Driver:</strong> Pengantaran</li>
                    <li><strong>Member:</strong> Pelanggan member</li>
                </ul>
            </div>
        </div>
    </div>
</div>