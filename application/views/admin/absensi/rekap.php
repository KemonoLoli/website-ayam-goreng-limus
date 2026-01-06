<?php
$bulan_nama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('absensi') ?>" class="btn btn-outline-secondary">
        <i class="cil-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Karyawan</label>
                <select name="karyawan" class="form-select form-select-sm">
                    <option value="">Semua Karyawan</option>
                    <?php foreach ($karyawan_list as $k): ?>
                        <option value="<?= $k->id_karyawan ?>" <?= $karyawan_selected == $k->id_karyawan ? 'selected' : '' ?>>
                            <?= $k->nama ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select form-select-sm">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                            <?= $bulan_nama[$i] ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select form-select-sm">
                    <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="cil-search"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="card-header">Rekap Absensi - <?= $bulan_nama[(int)$bulan] ?> <?= $tahun ?></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Karyawan</th>
                        <th>Jabatan</th>
                        <th class="text-center">Hadir</th>
                        <th class="text-center">Izin</th>
                        <th class="text-center">Sakit</th>
                        <th class="text-center">Alpha</th>
                        <th class="text-center">Telat</th>
                        <th class="text-end">Jam Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rekap)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-body-secondary">Tidak ada data</td></tr>
                    <?php else: ?>
                        <?php foreach ($rekap as $r): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= $r['karyawan']->nama ?></div>
                                    <small class="text-body-secondary"><?= $r['karyawan']->nip ?></small>
                                </td>
                                <td><?= $r['karyawan']->jabatan ?></td>
                                <td class="text-center"><span class="badge bg-success"><?= $r['hadir'] ?? 0 ?></span></td>
                                <td class="text-center"><span class="badge bg-info"><?= $r['izin'] ?? 0 ?></span></td>
                                <td class="text-center"><span class="badge bg-warning"><?= $r['sakit'] ?? 0 ?></span></td>
                                <td class="text-center"><span class="badge bg-danger"><?= $r['alpha'] ?? 0 ?></span></td>
                                <td class="text-center"><?= $r['terlambat'] ?? 0 ?></td>
                                <td class="text-end"><?= number_format($r['total_jam'] ?? 0, 1) ?> jam</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
