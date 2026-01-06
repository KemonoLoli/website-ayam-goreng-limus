<!-- Page Header -->
<div class="page-header mb-4">
    <h1 class="page-title">Profil Saya</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Informasi Profil</div>
            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" value="<?= $user->username ?>" disabled>
                                <small class="text-muted">Username tidak dapat diubah</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" value="<?= role_label($user->role) ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" required
                            value="<?= $user->nama_lengkap ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $user->email ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="<?= $user->no_hp ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <?php if ($user->foto): ?>
                            <small class="text-muted">Current: <?= $user->foto ?></small>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Profil</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Keamanan</div>
            <div class="card-body">
                <p>Untuk menjaga keamanan akun Anda, ubah password secara berkala.</p>
                <a href="<?= admin_url('profile/password') ?>" class="btn btn-outline-primary w-100">
                    Ganti Password
                </a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">Informasi Akun</div>
            <div class="card-body">
                <p class="mb-2"><strong>Login Terakhir:</strong><br>
                    <?= $user->last_login ? format_datetime($user->last_login) : 'Belum pernah' ?>
                </p>
                <p class="mb-0"><strong>Akun Dibuat:</strong><br>
                    <?= format_datetime($user->created_at) ?>
                </p>
            </div>
        </div>
    </div>
</div>