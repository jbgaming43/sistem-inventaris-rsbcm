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
                            <button type="button" class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#add_penerimaan_inventaris">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                </svg>
                                Cetak
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2>QR Codes</h2>
                        <?php if (!empty($qrImages)) : ?>
                            <?php foreach ($qrImages as $image) : ?>
                                <div style="margin-bottom: 20px;">
                                    <img src="<?= base_url('../uploads/' . basename($image)); ?>" alt="QR Code">
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Tidak ada QR Code yang dihasilkan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>