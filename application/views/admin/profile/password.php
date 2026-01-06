<!-- Page Header -->
<div class="page-header mb-4">
    <h1 class="page-title">Ganti Password</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" required minlength="6">
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" required minlength="6">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                        <a href="<?= admin_url('profile') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>