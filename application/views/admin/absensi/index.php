<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <?php if ($is_admin): ?>
        <a href="<?= admin_url('absensi/rekap') ?>" class="btn btn-outline-primary">
            <i class="cil-chart me-1"></i> Lihat Rekap
        </a>
    <?php endif; ?>
</div>

<!-- Clock In/Out Card for Employee -->
<?php if ($my_karyawan): ?>
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="cil-calendar-check me-2"></i> Absensi Anda Hari Ini -
                <?= format_date(date('Y-m-d'), 'l, d F Y') ?>
            </div>
            <div class="d-flex align-items-center">
                <i class="cil-clock me-2"></i>
                <span id="live-clock" class="fw-bold fs-5">--:--:--</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="mb-1"><?= $my_karyawan->nama ?></h5>
                    <p class="text-body-secondary mb-0"><?= $my_karyawan->jabatan ?> (<?= $my_karyawan->nip ?>)</p>
                </div>
                <div class="col-md-8">
                    <div class="d-flex gap-3 align-items-center">
                        <!-- Clock In -->
                        <div class="text-center">
                            <small class="text-body-secondary d-block">Masuk</small>
                            <?php if ($my_attendance && $my_attendance->jam_masuk): ?>
                                <span class="badge bg-success fs-6"><?= substr($my_attendance->jam_masuk, 0, 5) ?></span>
                            <?php else: ?>
                                <a href="<?= admin_url('absensi/clock_in') ?>" class="btn btn-success btn-sm">
                                    <i class="cil-arrow-right"></i> Clock In
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Break -->
                        <div class="text-center">
                            <small class="text-body-secondary d-block">Istirahat</small>
                            <?php if ($my_attendance && $my_attendance->jam_mulai_istirahat): ?>
                                <?php if ($my_attendance->jam_selesai_istirahat): ?>
                                    <span class="badge bg-info"><?= substr($my_attendance->jam_mulai_istirahat, 0, 5) ?> -
                                        <?= substr($my_attendance->jam_selesai_istirahat, 0, 5) ?></span>
                                <?php else: ?>
                                    <div>
                                        <span
                                            class="badge bg-warning"><?= substr($my_attendance->jam_mulai_istirahat, 0, 5) ?></span>
                                        <a href="<?= admin_url('absensi/break_in') ?>"
                                            class="btn btn-warning btn-sm ms-1">Kembali</a>
                                    </div>
                                <?php endif; ?>
                            <?php elseif ($my_attendance && $my_attendance->jam_masuk && !$my_attendance->jam_pulang): ?>
                                <a href="<?= admin_url('absensi/break_out') ?>" class="btn btn-outline-warning btn-sm">Mulai</a>
                            <?php else: ?>
                                <span class="badge bg-secondary">-</span>
                            <?php endif; ?>
                        </div>

                        <!-- Clock Out -->
                        <div class="text-center">
                            <small class="text-body-secondary d-block">Pulang</small>
                            <?php if ($my_attendance && $my_attendance->jam_pulang): ?>
                                <span class="badge bg-danger fs-6"><?= substr($my_attendance->jam_pulang, 0, 5) ?></span>
                            <?php elseif ($my_attendance && $my_attendance->jam_masuk && !$my_attendance->jam_mulai_istirahat): ?>
                                <a href="<?= admin_url('absensi/clock_out') ?>" class="btn btn-danger btn-sm">
                                    <i class="cil-arrow-left"></i> Clock Out
                                </a>
                            <?php elseif ($my_attendance && $my_attendance->jam_selesai_istirahat): ?>
                                <a href="<?= admin_url('absensi/clock_out') ?>" class="btn btn-danger btn-sm">
                                    <i class="cil-arrow-left"></i> Clock Out
                                </a>
                            <?php else: ?>
                                <span class="badge bg-secondary">-</span>
                            <?php endif; ?>
                        </div>

                        <!-- Total Hours -->
                        <?php if ($my_attendance && $my_attendance->jam_pulang): ?>
                            <div class="text-center ms-3">
                                <small class="text-body-secondary d-block">Total Jam</small>
                                <span class="badge bg-primary fs-6"><?= number_format($my_attendance->total_jam_kerja, 1) ?>
                                    jam</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Clock Script -->
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').textContent = hours + ':' + minutes + ':' + seconds;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
<?php endif; ?>



<!-- Attendance List (Admin View) -->
<?php if ($is_admin): ?>
    <div class="card">
        <div class="card-header">
            <form method="get" class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control form-control-sm"
                        value="<?= $filters['tanggal'] ?>">
                </div>
                <div class="col-auto">
                    <label class="form-label">Karyawan</label>
                    <select name="karyawan" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <?php foreach ($karyawan_list as $k): ?>
                            <option value="<?= $k->id_karyawan ?>" <?= $filters['id_karyawan'] == $k->id_karyawan ? 'selected' : '' ?>>
                                <?= $k->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Karyawan</th>
                            <th>Jabatan</th>
                            <th>Masuk</th>
                            <th>Istirahat</th>
                            <th>Pulang</th>
                            <th>Total Jam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($attendances)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-body-secondary">Tidak ada data absensi</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($attendances as $a): ?>
                                <tr>
                                    <td><?= $a->nama ?></td>
                                    <td><?= $a->jabatan ?></td>
                                    <td><?= $a->jam_masuk ? substr($a->jam_masuk, 0, 5) : '-' ?></td>
                                    <td>
                                        <?php if ($a->jam_mulai_istirahat): ?>
                                            <?= substr($a->jam_mulai_istirahat, 0, 5) ?>
                                            <?= $a->jam_selesai_istirahat ? ' - ' . substr($a->jam_selesai_istirahat, 0, 5) : '' ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $a->jam_pulang ? substr($a->jam_pulang, 0, 5) : '-' ?></td>
                                    <td><?= $a->total_jam_kerja ? number_format($a->total_jam_kerja, 1) . ' jam' : '-' ?></td>
                                    <td><?= status_badge($a->status, 'attendance') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>