<?php
$bulan_nama = [
    '',
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="<?= admin_url('laporan') ?>" class="btn btn-outline-secondary">
        <i class="cil-arrow-left me-1"></i> Kembali
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="get" class="row g-3 align-items-end">
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

<!-- Summary -->
<?php if ($summary): ?>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="fs-4 fw-bold"><?= $summary->total_karyawan ?: 0 ?></div>
                    <div>Karyawan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="fs-4 fw-bold"><?= format_rupiah($summary->total_gaji_pokok ?: 0) ?></div>
                    <div>Total Gaji Pokok</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="fs-4 fw-bold"><?= format_rupiah($summary->total_tunjangan ?: 0) ?></div>
                    <div>Total Tunjangan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="fs-4 fw-bold"><?= format_rupiah($summary->total_gaji_bersih ?: 0) ?></div>
                    <div>Total Pengeluaran</div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Payroll Table -->
<div class="card">
    <div class="card-header">Detail Penggajian - <?= $bulan_nama[(int) $bulan] ?> <?= $tahun ?></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Karyawan</th>
                        <th>Jabatan</th>
                        <th class="text-end">Gaji Pokok</th>
                        <th class="text-end">Tunjangan</th>
                        <th class="text-end">Potongan</th>
                        <th class="text-end">Gaji Bersih</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($gaji_list)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-body-secondary">Tidak ada data penggajian</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($gaji_list as $g): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= $g->nama ?></div>
                                    <small class="text-body-secondary"><?= $g->nip ?></small>
                                </td>
                                <td><?= $g->jabatan ?></td>
                                <td class="text-end"><?= format_rupiah($g->gaji_pokok) ?></td>
                                <td class="text-end text-success">+<?= format_rupiah($g->total_tunjangan) ?></td>
                                <td class="text-end text-danger">-<?= format_rupiah($g->total_potongan) ?></td>
                                <td class="text-end fw-bold"><?= format_rupiah($g->gaji_bersih) ?></td>
                                <td>
                                    <?php
                                    $colors = ['draft' => 'warning', 'disetujui' => 'info', 'dibayar' => 'success'];
                                    ?>
                                    <span
                                        class="badge bg-<?= $colors[$g->status] ?? 'secondary' ?>"><?= ucfirst($g->status) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>