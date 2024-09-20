<?= $this->extend('layouts/page') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/breadcrumb') ?>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <?= $this->include('layouts/alert') ?>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h3 class="card-title">Card with action</h3> -->
                        <div class="card-actions">
                            <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#add_penerimaan_inventaris">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Tambah
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2>QR Codes</h2>
                        <?php if (!empty($qrImages)): ?>
                            <?php foreach ($qrImages as $image): ?>
                                <div style="margin-bottom: 20px;">
                                    <img src="<?= base_url('../uploads/' . basename($image)); ?>" alt="QR Code">
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada QR Code yang dihasilkan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>