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
                            <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#add_pengajuan_nonmedis">
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
                                    <th>Depo</th>
                                    <th>Nomor Permintaan Barang</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>Catatan</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Persetujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom">
                                <?php $i = 1;
                                foreach ($pbnc as $dt_pengajuan_nonmedis) { ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $dt_pengajuan_nonmedis['departemen']; ?></td>
                                        <td><?= $dt_pengajuan_nonmedis['no_pengajuan']; ?></td>
                                        <td><?= $dt_pengajuan_nonmedis['tanggal']; ?></td>
                                        <td><?= $dt_pengajuan_nonmedis['keterangan']; ?></td>
                                        <td><?= $dt_pengajuan_nonmedis['nama']; ?></td>
                                        <td><?= $dt_pengajuan_nonmedis['status']; ?></td>
                                        <td class="text-center">
                                            <?php
                                            if ($dt_pengajuan_nonmedis['status'] == 'Proses Pengajuan') {
                                            ?>
                                                <span data-bs-toggle="modal" data-bs-target="#setuju_pengajuan_nonmedis<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>">
                                                    <button type="button" class="btn btn-icon btn-green btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Setuju">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-square-check">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                            <path d="M9 12l2 2l4 -4" />
                                                        </svg>
                                                    </button>
                                                </span>
                                                <span data-bs-toggle="modal" data-bs-target="#tolak_pengajuan_nonmedis<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>">
                                                    <button type="button" class="btn btn-icon btn-red btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Tolak">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-square-x">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" />
                                                            <path d="M9 9l6 6m0 -6l-6 6" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <span data-bs-toggle="modal" data-bs-target="#detail_pengajuan_nonmedis<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>">
                                                <button type="button" class="btn btn-icon btn-blue btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                        <path d="M12 9h.01" />
                                                        <path d="M11 12h1v4h1" />
                                                    </svg>
                                                </button>
                                            </span>
                                            <?php
                                            if ($dt_pengajuan_nonmedis['status'] == 'Proses Pengajuan') {
                                            ?>
                                                <span data-bs-toggle="modal" data-bs-target="#delete_pengajuan_nonmedis<?= $dt_pengajuan_nonmedis['no_pengajuan']; ?>">
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
                                            <?php
                                            }
                                            ?>
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

<?= $this->include('pengajuan_nonmedis/modal_add') ?>
<?= $this->include('pengajuan_nonmedis/modal_delete') ?>
<?= $this->include('pengajuan_nonmedis/modal_alert') ?>
<?= $this->include('pengajuan_nonmedis/modal_detail') ?>

<?= $this->endSection() ?>