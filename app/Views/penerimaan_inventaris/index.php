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
                        <table class="table table-sm table-striped table-hover dtTable compact table-vcenter">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Permintaan Barang</th>
                                    <th>No order</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Supplier</th>
                                    <th>Petugas</th>
                                    <th>Tagihan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom text-nowrap">
                                <?php $i = 1;
                                foreach ($pesan_inv_con as $dt_pemesanan_inventaris) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $dt_pemesanan_inventaris['no_faktur']; ?></td>
                                        <td><?= $dt_pemesanan_inventaris['no_order']; ?></td>
                                        <td><?= $dt_pemesanan_inventaris['tgl_faktur']; ?></td>
                                        <td><?= $dt_pemesanan_inventaris['nama_suplier']; ?></td>
                                        <td><?= $dt_pemesanan_inventaris['nama']; ?></td>
                                        <td><?= $dt_pemesanan_inventaris['tagihan']; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('/penerimaan_inventaris/print/' . $dt_pemesanan_inventaris['no_faktur']); ?>" target="_blank">
                                                <button type="button" class="btn btn-icon btn-dark btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                                    </svg>
                                                </button>
                                            </a>
                                            <span data-bs-toggle="modal" data-bs-target="#edit_pembelian_inventaris<?= $dt_pemesanan_inventaris['no_faktur']; ?>">
                                                <button type="button" class="btn btn-icon btn-dark btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="QR">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-qrcode">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                        <path d="M7 17l0 .01" />
                                                        <path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                        <path d="M7 7l0 .01" />
                                                        <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                        <path d="M17 7l0 .01" />
                                                        <path d="M14 14l3 0" />
                                                        <path d="M20 14l0 .01" />
                                                        <path d="M14 14l0 3" />
                                                        <path d="M14 20l3 0" />
                                                        <path d="M17 17l3 0" />
                                                        <path d="M20 17l0 3" />
                                                    </svg>
                                                </button>
                                            </span>
                                            <span data-bs-toggle="modal" data-bs-target="#detail_penerimaan_inventaris<?= $dt_pemesanan_inventaris['no_faktur']; ?>">
                                                <button type="button" class="btn btn-icon btn-blue btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                        <path d="M12 9h.01" />
                                                        <path d="M11 12h1v4h1" />
                                                    </svg>
                                                </button>
                                            </span>

                                            <span data-bs-toggle="modal" data-bs-target="#delete_penerimaan_inventaris<?= $dt_pemesanan_inventaris['no_faktur']; ?>">
                                                <button type="button" class="btn btn-icon btn-red btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('penerimaan_inventaris/modal_add') ?>
<?= $this->include('penerimaan_inventaris/modal_delete') ?>
<?= $this->include('penerimaan_inventaris/modal_detail') ?>

<?= $this->endSection() ?>