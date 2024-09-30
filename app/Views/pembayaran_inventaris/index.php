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
                            <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#add_pembayaran_inventaris">
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
                                    <th>Tanggal Bayar</th>
                                    <th>Nomor Faktur</th>
                                    <th>Petugas</th>
                                    <th>Keterangan</th>
                                    <th>Nama Bayar</th>
                                    <th>Nomor Bukti</th>
                                    <th>Tagihan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom text-nowrap">
                                <?php $i = 1;
                                foreach ($pembayaran_inv_con as $dt_pembayaran_inventaris) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $dt_pembayaran_inventaris['tgl_bayar']; ?></td>
                                        <td><?= $dt_pembayaran_inventaris['no_faktur']; ?></td>
                                        <td><?= $dt_pembayaran_inventaris['nama']; ?></td>
                                        <td><?= $dt_pembayaran_inventaris['keterangan']; ?></td>
                                        <td><?= $dt_pembayaran_inventaris['nama_bayar']; ?></td>
                                        <td><?= $dt_pembayaran_inventaris['no_bukti']; ?></td>
                                        <td>Rp <?= number_format($dt_pembayaran_inventaris['besar_bayar'], 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <a href="pembayaran_inventaris/delete/<?= $dt_pembayaran_inventaris['no_faktur'] ?>">
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
                                            </a>
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

<?= $this->include('pembayaran_inventaris/modal_add') ?>
<?= $this->include('pembayaran_inventaris/modal_delete') ?>


<?= $this->endSection() ?>