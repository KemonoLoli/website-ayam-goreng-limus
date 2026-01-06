<!-- Profile Header -->
<div class="mb-4">
    <h4 class="mb-1">Profil Saya</h4>
    <p class="text-muted mb-0">Kelola informasi profil Anda</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="bi bi-person me-2"></i>Informasi Pribadi</h6>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama"
                                value="<?= set_value('nama', $konsumen->nama) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="no_hp"
                                value="<?= set_value('no_hp', $konsumen->no_hp) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="<?= set_value('email', $konsumen->email) ?>">
                        <small class="text-muted">Email juga digunakan untuk login</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3"
                            placeholder="Alamat lengkap untuk delivery"><?= set_value('alamat', $konsumen->alamat) ?></textarea>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3"><i class="bi bi-lock me-2"></i>Ubah Password</h6>
                    <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Minimal 6 karakter">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirm"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                        </button>
                        <a href="<?= site_url('member/dashboard') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Member Card -->
        <div class="card bg-gradient text-white" style="background: linear-gradient(135deg, #243036, #3d5a6c);">
            <div class="card-body text-center py-4">
                <div class="member-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    <?= substr($konsumen->nama, 0, 1) ?>
                </div>
                <h5 class="mb-1">
                    <?= $konsumen->nama ?>
                </h5>
                <span class="badge bg-warning text-dark mb-3">
                    <?= ucfirst($konsumen->tipe) ?>
                </span>
                <div class="d-flex justify-content-around border-top border-secondary pt-3 mt-3">
                    <div>
                        <h4 class="mb-0">
                            <?= number_format($konsumen->poin) ?>
                        </h4>
                        <small class="text-white-50">Poin</small>
                    </div>
                    <div>
                        <h6 class="mb-0">Rp
                            <?= number_format($konsumen->total_transaksi / 1000) ?>K
                        </h6>
                        <small class="text-white-50">Total Belanja</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="card mt-3">
            <div class="card-body">
                <h6><i class="bi bi-info-circle me-2"></i>Info Akun</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Username</td>
                        <td class="text-end">
                            <?= $konsumen->username ?? $konsumen->email ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tipe</td>
                        <td class="text-end">
                            <span class="badge bg-<?= $konsumen->tipe == 'vip' ? 'warning' : 'primary' ?>">
                                <?= ucfirst($konsumen->tipe) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Terdaftar</td>
                        <td class="text-end">
                            <?= date('d M Y', strtotime($konsumen->created_at)) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>