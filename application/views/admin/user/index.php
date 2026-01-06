<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('user/create') ?>" class="btn btn-primary">
        <i class="cil-plus me-1"></i> Tambah User
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <?php
                    $roles = ['owner', 'admin', 'kasir', 'koki', 'waiter', 'driver', 'member'];
                    if (isset($current_user) && $current_user->role === 'master')
                        array_unshift($roles, 'master');
                    foreach ($roles as $r):
                        ?>
                        <option value="<?= $r ?>" <?= isset($filters['role']) && $filters['role'] === $r ? 'selected' : '' ?>>
                            <?= role_label($r) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Username, nama, email..."
                    value="<?= isset($filters['search']) ? $filters['search'] : '' ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="cil-search"></i> Filter
                </button>
                <a href="<?= admin_url('user') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Email / HP</th>
                        <th>Status</th>
                        <th>Login Terakhir</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-body-secondary">
                                Tidak ada data user
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($users as $user): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-2">
                                            <div class="avatar-placeholder avatar-md" style="font-size:0.8rem;">
                                                <?= get_initials($user->nama_lengkap) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><?= $user->nama_lengkap ?></div>
                                            <small class="text-body-secondary">@<?= $user->username ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $role_colors = [
                                        'master' => 'danger',
                                        'owner' => 'primary',
                                        'admin' => 'info',
                                        'kasir' => 'success',
                                        'koki' => 'warning text-dark',
                                        'waiter' => 'secondary',
                                        'driver' => 'dark',
                                        'member' => 'purple'
                                    ];
                                    $color = $role_colors[$user->role] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $color ?>" <?= $user->role === 'member' ? 'style="background-color: #6f42c1 !important;"' : '' ?>><?= role_label($user->role) ?></span>
                                </td>
                                <td>
                                    <div><?= $user->email ?: '-' ?></div>
                                    <small class="text-body-secondary"><?= $user->no_hp ?: '' ?></small>
                                </td>
                                <td>
                                    <?php if ($user->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $user->last_login ? time_ago($user->last_login) : '<span class="text-body-secondary">-</span>' ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= admin_url('user/edit/' . $user->id_user) ?>"
                                            class="btn btn-outline-primary" title="Edit">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <?php if (isset($current_user) && $user->id_user != $current_user->id_user && $user->role !== 'master'): ?>
                                            <a href="<?= admin_url('user/toggle/' . $user->id_user) ?>"
                                                class="btn btn-outline-secondary"
                                                title="<?= $user->is_active ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                                <i class="cil-<?= $user->is_active ? 'ban' : 'check' ?>"></i>
                                            </a>
                                            <a href="<?= admin_url('user/delete/' . $user->id_user) ?>"
                                                class="btn btn-outline-danger" title="Hapus"
                                                onclick="return confirm('Yakin hapus user ini?')">
                                                <i class="cil-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <small class="text-body-secondary">Total: <?= count($users) ?> user</small>
    </div>
</div>