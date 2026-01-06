<?php
$bulan_nama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Slip Gaji - <?= $bulan_nama[(int)$gaji->bulan] ?> <?= $gaji->tahun ?></h1>
    <div>
        <a href="<?= admin_url('penggajian/print_slip/' . $gaji->id_penggajian) ?>" class="btn btn-outline-primary" target="_blank">
            <i class="cil-print me-1"></i> Cetak
        </a>
        <a href="<?= admin_url('penggajian') ?>" class="btn btn-outline-secondary">
            <i class="cil-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Detail Slip Gaji</div>
            <div class="card-body">
                <!-- Employee Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm mb-0">
                            <tr><th width="120">Nama</th><td><?= $gaji->nama ?></td></tr>
                            <tr><th>NIP</th><td><?= $gaji->nip ?></td></tr>
                            <tr><th>Jabatan</th><td><?= $gaji->jabatan ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm mb-0">
                            <tr><th width="120">Periode</th><td><?= $bulan_nama[(int)$gaji->bulan] ?> <?= $gaji->tahun ?></td></tr>
                            <tr><th>Hari Kerja</th><td><?= $gaji->total_hari_kerja ?> hari</td></tr>
                            <tr><th>Status</th><td>
                                <?php 
                                $colors = ['draft' => 'warning', 'disetujui' => 'info', 'dibayar' => 'success'];
                                ?>
                                <span class="badge bg-<?= $colors[$gaji->status] ?? 'secondary' ?>"><?= ucfirst($gaji->status) ?></span>
                            </td></tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <!-- Income -->
                <h6 class="text-success mb-3"><i class="cil-arrow-bottom me-2"></i>Pendapatan</h6>
                <table class="table table-sm">
                    <tr><td>Gaji Pokok</td><td class="text-end"><?= format_rupiah($gaji->gaji_pokok) ?></td></tr>
                    <tr><td>Tunjangan Kehadiran</td><td class="text-end"><?= format_rupiah($gaji->tunjangan_hadir) ?></td></tr>
                    <tr><td>Tunjangan Transport</td><td class="text-end"><?= format_rupiah($gaji->tunjangan_transport) ?></td></tr>
                    <tr><td>Tunjangan Makan</td><td class="text-end"><?= format_rupiah($gaji->tunjangan_makan) ?></td></tr>
                    <?php if ($gaji->tunjangan_lainnya > 0): ?>
                        <tr><td>Tunjangan Lainnya</td><td class="text-end"><?= format_rupiah($gaji->tunjangan_lainnya) ?></td></tr>
                    <?php endif; ?>
                    <tr class="table-success fw-bold">
                        <td>Total Pendapatan</td>
                        <td class="text-end"><?= format_rupiah($gaji->gaji_pokok + $gaji->total_tunjangan) ?></td>
                    </tr>
                </table>
                
                <!-- Deductions -->
                <h6 class="text-danger mb-3 mt-4"><i class="cil-arrow-top me-2"></i>Potongan</h6>
                <table class="table table-sm">
                    <tr><td>Potongan Absen</td><td class="text-end"><?= format_rupiah($gaji->potongan_absen) ?></td></tr>
                    <tr><td>Potongan Keterlambatan</td><td class="text-end"><?= format_rupiah($gaji->potongan_terlambat) ?></td></tr>
                    <?php if ($gaji->potongan_lainnya > 0): ?>
                        <tr><td>Potongan Lainnya</td><td class="text-end"><?= format_rupiah($gaji->potongan_lainnya) ?></td></tr>
                    <?php endif; ?>
                    <tr class="table-danger fw-bold">
                        <td>Total Potongan</td>
                        <td class="text-end"><?= format_rupiah($gaji->total_potongan) ?></td>
                    </tr>
                </table>
                
                <hr>
                
                <!-- Net -->
                <table class="table table-sm">
                    <tr class="table-primary fs-5 fw-bold">
                        <td>GAJI BERSIH (TAKE HOME PAY)</td>
                        <td class="text-end text-primary"><?= format_rupiah($gaji->gaji_bersih) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Aksi</div>
            <div class="card-body">
                <?php if ($gaji->status === 'draft'): ?>
                    <a href="<?= admin_url('penggajian/edit/' . $gaji->id_penggajian) ?>" class="btn btn-outline-primary w-100 mb-2">
                        <i class="cil-pencil me-1"></i> Edit
                    </a>
                    <a href="<?= admin_url('penggajian/approve/' . $gaji->id_penggajian) ?>" 
                       class="btn btn-success w-100 mb-2"
                       onclick="return confirm('Setujui slip gaji ini?')">
                        <i class="cil-check me-1"></i> Setujui
                    </a>
                    <a href="<?= admin_url('penggajian/delete/' . $gaji->id_penggajian) ?>" 
                       class="btn btn-outline-danger w-100"
                       onclick="return confirm('Hapus slip gaji ini?')">
                        <i class="cil-trash me-1"></i> Hapus
                    </a>
                <?php elseif ($gaji->status === 'disetujui'): ?>
                    <a href="<?= admin_url('penggajian/pay/' . $gaji->id_penggajian) ?>" 
                       class="btn btn-success w-100"
                       onclick="return confirm('Tandai sudah dibayar?')">
                        <i class="cil-wallet me-1"></i> Tandai Dibayar
                    </a>
                <?php else: ?>
                    <div class="text-center text-success py-3">
                        <i class="cil-check-circle fs-1"></i>
                        <p class="mb-0 mt-2">Gaji sudah dibayar</p>
                        <?php if ($gaji->tgl_dibayar): ?>
                            <small class="text-body-secondary"><?= format_datetime($gaji->tgl_dibayar) ?></small>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
