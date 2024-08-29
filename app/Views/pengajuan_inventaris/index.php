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
                            <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#add_pengajuan_inventaris">
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
                                    <th>Tanggal</th>
                                    <th>NIK</th>
                                    <th>Diajukan Oleh</th>
                                    <th>Departemen</th>
                                    <th>Urgensi</th>
                                    <th>Latar Belakang</th>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Jml</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Keterangan</th>
                                    <th>NIK P.J.</th>
                                    <th>P.J. Terkait</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom">
                                <?php $i = 1;
                                foreach ($pbnc as $dt_pengajuan_inventaris) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['no_pengajuan']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['tanggal']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['nik']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['nama']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['departemen']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['urgensi']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['latar_belakang']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['nama_barang']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['spesifikasi']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['jumlah']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['harga']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['total']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['keterangan']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['nik_pj']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['nama_pj']; ?></td>
                                        <td><?= $dt_pengajuan_inventaris['status']; ?></td>
                                        <td>
                                            <span data-bs-toggle="modal" data-bs-target="#edit_pengguna<?= $dt_pengajuan_inventaris['id']; ?>">
                                                <button type="button" class="btn btn-icon btn-yellow btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="true" />
                                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                        <path d="M13.5 6.5l4 4" />
                                                    </svg>
                                                </button>
                                            </span>
                                            <span data-bs-toggle="modal" data-bs-target="#delete_pengguna<?= $dt_pengajuan_inventaris['id']; ?>">
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

<?= $this->include('pengajuan_inventaris/modal_add') ?>

<?= $this->endSection() ?>