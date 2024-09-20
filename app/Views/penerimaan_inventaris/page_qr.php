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
                        <!-- OPSI PERTAMA -->

                        <?php if (!empty($qrImages)) : ?>
                            <div class="row">
                                <?php
                                foreach ($barang_qrImage as $item) : ?>
                                    <div class="col-6 col-sm-3 mb-2">
                                        <div class="card">
                                            <div class="card-body pb-0">
                                                <h3 class="card-title m-0 fs-4"><?= $item['barang']['no_inventaris']; ?></h3>
                                                <p class="text-mute"><?= $item['barang']['nama_barang']; ?></p>
                                            </div>
                                            <!-- Photo -->
                                            <img width="300cm" src="<?= base_url('../uploads/' . basename($item['qrImage'])); ?>" alt="QR Code<?= $item['barang']['no_inventaris']; ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p>Tidak ada QR Code yang dihasilkan.</p>
                        <?php endif; ?>

                        <!-- OPSI KEDUA -->
                        <!-- <table class="table table-bordered">
                            <?php foreach ($barang_qrImage as $item) : ?>
                                <tr>
                                    <td><?= $item['barang']['no_inventaris'] ?></td>
                                    <td><?= $item['barang']['nama_barang'] ?></td>
                                    <td>
                                        <img width="100px" src="<?= base_url('../uploads/' . basename($item['qrImage'])); ?>" alt="QR Code">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>