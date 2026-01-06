<!-- Page Header -->
<div class="page-header mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" required
                                    value="<?= isset($customer) ? $customer->nama : '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="no_hp" class="form-control"
                                    value="<?= isset($customer) ? $customer->no_hp : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= isset($customer) ? $customer->email : '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Pelanggan</label>
                                <select name="tipe" class="form-select" id="tipeSelect"
                                    onchange="togglePasswordField()">
                                    <option value="walk-in" <?= isset($customer) && $customer->tipe == 'walk-in' ? 'selected' : '' ?>>Walk-in</option>
                                    <option value="member" <?= isset($customer) && $customer->tipe == 'member' ? 'selected' : '' ?>>Member</option>
                                    <option value="vip" <?= isset($customer) && $customer->tipe == 'vip' ? 'selected' : '' ?>>VIP</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"
                            rows="3"><?= isset($customer) ? $customer->alamat : '' ?></textarea>
                    </div>

                    <!-- Password Section for Member -->
                    <div id="passwordSection"
                        class="<?= (!isset($customer) || $customer->tipe == 'walk-in') ? 'd-none' : '' ?>">
                        <hr class="my-4">
                        <h6 class="mb-3"><i class="cil-lock-locked me-2"></i>Akun Login Member</h6>

                        <?php if (isset($customer) && isset($customer->id_user) && $customer->id_user): ?>
                            <!-- Existing member account -->
                            <div class="alert alert-info py-2">
                                <i class="cil-check-circle me-1"></i>
                                Member ini sudah memiliki akun login. Username: <strong><?= $customer->username ?></strong>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password baru">
                            </div>
                            <a href="<?= admin_url('konsumen/reset_password/' . $customer->id_konsumen) ?>"
                                class="btn btn-outline-warning btn-sm"
                                onclick="return confirm('Reset password member ini?')">
                                <i class="cil-reload me-1"></i>Reset Password
                            </a>
                        <?php else: ?>
                            <!-- New member account -->
                            <div class="alert alert-warning py-2">
                                <i class="cil-warning me-1"></i>
                                Isi password untuk membuat akun login member.
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="memberPassword"
                                    placeholder="Minimal 6 karakter">
                                <small class="text-muted">Member akan login menggunakan Email/No HP + Password ini</small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= admin_url('konsumen') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <?php if (isset($customer)): ?>
            <!-- Customer Stats -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Poin</span>
                        <strong><?= number_format($customer->poin) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Transaksi</span>
                        <strong>Rp<?= number_format($customer->total_transaksi, 0, ',', '.') ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Terdaftar</span>
                        <strong><?= date('d M Y', strtotime($customer->created_at)) ?></strong>
                    </div>
                </div>
                <?php if ($customer->tipe == 'member' || $customer->tipe == 'vip'): ?>
                    <div class="card-footer">
                        <a href="<?= admin_url('konsumen/poin/' . $customer->id_konsumen) ?>"
                            class="btn btn-outline-primary btn-sm w-100">
                            <i class="cil-gift me-1"></i>Kelola Poin
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Help -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="cil-info me-1"></i>Panduan</h6>
            </div>
            <div class="card-body small">
                <p><strong>Walk-in:</strong> Pelanggan biasa tanpa akun login.</p>
                <p><strong>Member:</strong> Pelanggan dengan akun login, dapat mengakses dashboard member dan mendapat
                    diskon 5%.</p>
                <p><strong>VIP:</strong> Member dengan benefit khusus.</p>
                <hr>
                <p class="mb-0 text-muted">Untuk member, Email atau No HP akan digunakan sebagai username login.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordField() {
        const tipe = document.getElementById('tipeSelect').value;
        const passwordSection = document.getElementById('passwordSection');
        const passwordInput = document.getElementById('memberPassword');

        if (tipe === 'member' || tipe === 'vip') {
            passwordSection.classList.remove('d-none');
            if (passwordInput) passwordInput.required = true;
        } else {
            passwordSection.classList.add('d-none');
            if (passwordInput) passwordInput.required = false;
        }
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', togglePasswordField);
</script>