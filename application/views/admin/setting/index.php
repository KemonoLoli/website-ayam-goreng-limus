<!-- Page Header -->
<div class="page-header mb-4">
    <h1 class="page-title">Pengaturan</h1>
</div>

<form method="post" action="">
    <!-- General Settings -->
    <div class="card mb-4">
        <div class="card-header">Informasi Restoran</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Restoran</label>
                        <input type="text" name="settings[nama_restoran]" class="form-control"
                            value="<?= isset($settings['nama_restoran']) ? $settings['nama_restoran'] : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="settings[telepon]" class="form-control"
                            value="<?= isset($settings['telepon']) ? $settings['telepon'] : '' ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="settings[email]" class="form-control"
                            value="<?= isset($settings['email']) ? $settings['email'] : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="settings[alamat]" class="form-control"
                            value="<?= isset($settings['alamat']) ? $settings['alamat'] : '' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Settings -->
    <div class="card mb-4">
        <div class="card-header">Pengaturan Operasional</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Jam Buka</label>
                        <input type="time" name="settings[jam_buka]" class="form-control"
                            value="<?= isset($settings['jam_buka']) ? $settings['jam_buka'] : '10:00' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Jam Tutup</label>
                        <input type="time" name="settings[jam_tutup]" class="form-control"
                            value="<?= isset($settings['jam_tutup']) ? $settings['jam_tutup'] : '22:00' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Pajak (%)</label>
                        <input type="number" name="settings[pajak_persen]" class="form-control" step="0.1"
                            value="<?= isset($settings['pajak_persen']) ? $settings['pajak_persen'] : '0' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Ongkir Default (Rp)</label>
                        <input type="number" name="settings[ongkir_default]" class="form-control"
                            value="<?= isset($settings['ongkir_default']) ? $settings['ongkir_default'] : '10000' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HR Settings -->
    <div class="card mb-4">
        <div class="card-header">Pengaturan SDM</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Hari Kerja per Bulan</label>
                        <input type="number" name="settings[hari_kerja]" class="form-control"
                            value="<?= isset($settings['hari_kerja']) ? $settings['hari_kerja'] : '26' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Potongan per Hari Alpha (Rp)</label>
                        <input type="number" name="settings[potongan_per_hari]" class="form-control"
                            value="<?= isset($settings['potongan_per_hari']) ? $settings['potongan_per_hari'] : '50000' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Potongan Terlambat (Rp)</label>
                        <input type="number" name="settings[potongan_terlambat]" class="form-control"
                            value="<?= isset($settings['potongan_terlambat']) ? $settings['potongan_terlambat'] : '25000' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
</form>