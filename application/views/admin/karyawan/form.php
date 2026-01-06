<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('karyawan') ?>" class="btn btn-outline-secondary"><i class="cil-arrow-left me-1"></i>
        Kembali</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="cil-user me-2"></i> Data Karyawan</div>
            <div class="card-body">
                <?php $is_edit = isset($karyawan); ?>

                <form method="post">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama"
                                    value="<?= $is_edit ? $karyawan->nama : set_value('nama') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <select class="form-select" name="jabatan" required>
                                    <option value="">-- Pilih --</option>
                                    <?php
                                    $jabatan_list = ['Kasir', 'Koki', 'Waiter', 'Driver', 'Admin'];
                                    $selected = $is_edit ? $karyawan->jabatan : set_value('jabatan');
                                    foreach ($jabatan_list as $jbt): ?>
                                        <option value="<?= $jbt ?>" <?= $selected === $jbt ? 'selected' : '' ?>><?= $jbt ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="text" class="form-control" name="no_hp"
                                    value="<?= $is_edit ? $karyawan->no_hp : set_value('no_hp') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?= $is_edit ? $karyawan->email : set_value('email') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat"
                            rows="2"><?= $is_edit ? $karyawan->alamat : set_value('alamat') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tgl_lahir"
                                    value="<?= $is_edit ? $karyawan->tgl_lahir : set_value('tgl_lahir') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Bergabung</label>
                                <input type="date" class="form-control" name="tgl_bergabung"
                                    value="<?= $is_edit ? $karyawan->tgl_bergabung : date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Gaji Pokok</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="gaji_pokok"
                                        value="<?= $is_edit ? $karyawan->gaji_pokok : set_value('gaji_pokok', 0) ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <?php
                            $status_list = ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif', 'cuti' => 'Cuti', 'resign' => 'Resign'];
                            $selected = $is_edit ? $karyawan->status : 'aktif';
                            foreach ($status_list as $val => $label): ?>
                                <option value="<?= $val ?>" <?= $selected === $val ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if (!$is_edit): ?>
                        <hr>
                        <h6 class="mb-3">Akun User (Opsional)</h6>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="create_user" id="create_user" value="1">
                            <label class="form-check-label" for="create_user">Buatkan akun login untuk karyawan ini</label>
                        </div>
                        <div id="user_fields" style="display:none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Default: password123">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('create_user').addEventListener('change', function () {
                                document.getElementById('user_fields').style.display = this.checked ? '' : 'none';
                            });
                        </script>
                    <?php endif; ?>

                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-check me-1"></i> <?= $is_edit ? 'Simpan' : 'Tambah' ?>
                        </button>
                        <a href="<?= admin_url('karyawan') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>