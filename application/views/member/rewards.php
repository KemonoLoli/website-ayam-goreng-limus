<!-- Rewards Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Poin & Rewards</h4>
        <p class="text-muted mb-0">Tukarkan poin Anda dengan rewards menarik</p>
    </div>
    <div class="text-end">
        <div class="badge badge-poin text-white fs-5 px-3 py-2">
            <i class="bi bi-star-fill me-1"></i>
            <?= number_format($poin) ?> Poin
        </div>
    </div>
</div>

<!-- Poin Info -->
<div class="card bg-gradient mb-4" style="background: linear-gradient(135deg, #f5af19, #f12711);">
    <div class="card-body text-white">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="mb-2"><i class="bi bi-info-circle me-2"></i>Cara Mendapatkan Poin</h5>
                <p class="mb-0">Setiap transaksi Rp 10.000 = 1 Poin. Semakin banyak belanja, semakin banyak poin!</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="<?= site_url('order') ?>" class="btn btn-light">
                    <i class="bi bi-cart-plus me-1"></i>Belanja Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Available Rewards -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="bi bi-gift me-2"></i>Rewards Tersedia</h6>
            </div>
            <div class="card-body">
                <?php if (empty($rewards)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-gift display-4 text-muted"></i>
                        <p class="text-muted mt-2">Tidak ada rewards tersedia saat ini</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($rewards as $reward): ?>
                            <div class="col-md-6">
                                <div class="card h-100 <?= $reward->can_claim ? 'border-primary' : 'border-secondary' ?>">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">
                                                <?= $reward->nama_reward ?>
                                            </h6>
                                            <span class="badge bg-<?= $reward->can_claim ? 'primary' : 'secondary' ?>">
                                                <?= number_format($reward->poin_dibutuhkan) ?> Poin
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-3">
                                            <?= $reward->deskripsi ?>
                                        </p>

                                        <?php if ($reward->can_claim): ?>
                                            <a href="<?= site_url('member/claim/' . $reward->id_reward) ?>"
                                                class="btn btn-primary btn-sm w-100"
                                                onclick="return confirm('Tukar <?= number_format($reward->poin_dibutuhkan) ?> poin untuk reward ini?')">
                                                <i class="bi bi-gift me-1"></i>Tukar Sekarang
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                                <i class="bi bi-lock me-1"></i>Butuh
                                                <?= number_format($reward->poin_dibutuhkan - $poin) ?> Poin lagi
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Active Claims -->
        <?php if (!empty($active_claims)): ?>
            <div class="card mt-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i>Voucher Aktif</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($active_claims as $claim): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>
                                        <?= $claim->nama_reward ?>
                                    </strong>
                                    <br><small class="text-muted">Kode: <code><?= $claim->kode_klaim ?></code></small>
                                    <br><small class="text-muted">Berlaku sampai:
                                        <?= date('d M Y', strtotime($claim->expired_at)) ?>
                                    </small>
                                </div>
                                <button class="btn btn-outline-primary btn-sm" onclick="copyCode('<?= $claim->kode_klaim ?>')">
                                    <i class="bi bi-clipboard"></i> Salin
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Poin History -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Poin</h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($poin_history)): ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada riwayat poin</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                        <?php foreach ($poin_history as $history): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="<?= $history->poin > 0 ? 'text-success' : 'text-danger' ?> fw-bold">
                                            <?= $history->poin > 0 ? '+' : '' ?>
                                            <?= number_format($history->poin) ?>
                                        </span>
                                        <br><small class="text-muted">
                                            <?= $history->keterangan ?: ucfirst($history->tipe) ?>
                                        </small>
                                    </div>
                                    <small class="text-muted">
                                        <?= date('d/m/y', strtotime($history->created_at)) ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Used Claims History -->
        <?php if (!empty($used_claims)): ?>
            <div class="card mt-3">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="bi bi-check2-circle me-2"></i>Voucher Terpakai</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($used_claims, 0, 5) as $claim): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <?= $claim->nama_reward ?>
                                    </span>
                                    <small class="text-muted">
                                        <?= date('d/m/y', strtotime($claim->used_at)) ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function copyCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Kode berhasil disalin: ' + code);
        });
    }
</script>