<!-- Page Header -->
<div class="page-header mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="<?= admin_url('rewards') ?>">Rewards</a></li>
            <li class="breadcrumb-item active">
                <?= isset($reward) ? 'Edit' : 'Tambah' ?>
            </li>
        </ol>
    </nav>
    <h1 class="page-title">
        <?= $page_title ?>
    </h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Reward <span class="text-danger">*</span></label>
                                <input type="text" name="nama_reward" class="form-control" required
                                    value="<?= isset($reward) ? $reward->nama_reward : '' ?>"
                                    placeholder="contoh: Diskon 10%, Gratis Es Teh, dll">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Poin Dibutuhkan <span class="text-danger">*</span></label>
                                <input type="number" name="poin_dibutuhkan" class="form-control" required min="1"
                                    value="<?= isset($reward) ? $reward->poin_dibutuhkan : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2"
                            placeholder="Deskripsi singkat reward"><?= isset($reward) ? $reward->deskripsi : '' ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Reward</label>
                                <select name="tipe_reward" class="form-select" id="tipeReward"
                                    onchange="toggleNilaiField()">
                                    <option value="discount_percent" <?= isset($reward) && $reward->tipe_reward == 'discount_percent' ? 'selected' : '' ?>>Diskon Persen (%)</option>
                                    <option value="discount_nominal" <?= isset($reward) && $reward->tipe_reward == 'discount_nominal' ? 'selected' : '' ?>>Diskon Nominal (Rp)</option>
                                    <option value="free_item" <?= isset($reward) && $reward->tipe_reward == 'free_item' ? 'selected' : '' ?>>Gratis Menu</option>
                                    <option value="voucher" <?= isset($reward) && $reward->tipe_reward == 'voucher' ? 'selected' : '' ?>>Voucher</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" id="nilaiField">
                                <label class="form-label" id="nilaiLabel">Nilai Diskon</label>
                                <input type="number" name="nilai_reward" class="form-control" step="0.01" min="0"
                                    value="<?= isset($reward) ? $reward->nilai_reward : '' ?>">
                                <small class="text-muted" id="nilaiHelp">Persentase diskon (contoh: 10 untuk
                                    10%)</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control" min="0"
                                    value="<?= isset($reward) && $reward->stok !== null ? $reward->stok : '' ?>"
                                    placeholder="Kosongkan untuk unlimited">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Masa Berlaku (hari)</label>
                                <input type="number" name="expired_days" class="form-control" min="1"
                                    value="<?= isset($reward) ? $reward->expired_days : 30 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                        value="1" <?= !isset($reward) || $reward->is_active ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="isActive">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="cil-save me-1"></i>Simpan
                        </button>
                        <a href="<?= admin_url('rewards') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Help Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="cil-info me-1"></i>Panduan</h6>
            </div>
            <div class="card-body small">
                <p><strong>Diskon Persen:</strong> Memberikan potongan persentase dari total belanja.</p>
                <p><strong>Diskon Nominal:</strong> Memberikan potongan dalam rupiah.</p>
                <p><strong>Gratis Menu:</strong> Member mendapat menu gratis tertentu.</p>
                <p><strong>Voucher:</strong> Voucher khusus yang bisa ditukar.</p>
                <hr>
                <p class="mb-0 text-muted">Stok kosong = unlimited. Member dapat menukarkan reward selama poin mencukupi
                    dan stok tersedia.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleNilaiField() {
        const tipe = document.getElementById('tipeReward').value;
        const nilaiLabel = document.getElementById('nilaiLabel');
        const nilaiHelp = document.getElementById('nilaiHelp');

        if (tipe === 'discount_percent') {
            nilaiLabel.textContent = 'Nilai Diskon (%)';
            nilaiHelp.textContent = 'Persentase diskon (contoh: 10 untuk 10%)';
        } else if (tipe === 'discount_nominal') {
            nilaiLabel.textContent = 'Nilai Diskon (Rp)';
            nilaiHelp.textContent = 'Nominal potongan dalam rupiah';
        } else if (tipe === 'free_item') {
            nilaiLabel.textContent = 'ID Menu (opsional)';
            nilaiHelp.textContent = 'ID menu yang gratis, atau kosongkan';
        } else {
            nilaiLabel.textContent = 'Nilai Voucher';
            nilaiHelp.textContent = 'Nilai nominal voucher';
        }
    }

    document.addEventListener('DOMContentLoaded', toggleNilaiField);
</script>