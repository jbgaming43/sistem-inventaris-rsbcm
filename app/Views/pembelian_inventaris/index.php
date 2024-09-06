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
                            <button type="button" class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#print_pembelian_inventaris">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                </svg>
                                Cetak
                            </button>
                            <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#add_pembelian_inventaris">
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom text-nowrap">
                                <?php $i = 1;
                                foreach ($pbnc as $dt_pembelian_inventaris) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $dt_pembelian_inventaris['no_faktur']; ?></td>
                                        <td class="text-center">
                                            <span data-bs-toggle="modal" data-bs-target="#edit_pembelian_inventaris<?= $dt_pembelian_inventaris['no_faktur']; ?>">
                                                <button type="button" class="btn btn-icon btn-yellow btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="true" />
                                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                        <path d="M13.5 6.5l4 4" />
                                                    </svg>
                                                </button>
                                            </span>
                                            <span data-bs-toggle="modal" data-bs-target="#delete_pembelian_inventaris<?= $dt_pembelian_inventaris['no_faktur']; ?>">
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

<?= $this->include('pembelian_inventaris/modal_add') ?>
<?= $this->endSection() ?>