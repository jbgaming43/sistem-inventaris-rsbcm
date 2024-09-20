<?= $this->include('layouts/header') ?>
<div class="page page-center">
    <div class="container container-tight">
        <?php foreach ($inv_con as $dt_inv) : ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Info Barang</h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless fs-4">
                        <tr>
                            <td>No. Inventaris</td>
                            <td><?= $dt_inv['no_inv']; ?></td>
                        </tr>
                        <tr>
                            <td>No Faktur</td>
                            <td><?= $dt_inv['no_faktur']; ?></td>
                        </tr>
                        <tr>
                            <td>Kode Barang</td>
                            <td><?= $dt_inv['kode_barang']; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Barang</td>
                            <td><?= $dt_inv['nama_barang']; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Supplier</td>
                            <td><?= $dt_inv['nama_suplier']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal pengadaan</td>
                            <td><?= $dt_inv['tgl_pengadaan']; ?></td>
                        </tr>
                        <?php if (!empty($dt_inv['nama_ruang'])) : ?>
                            <tr>
                                <td>Nama Ruang</td>
                                <td><?= $dt_inv['nama_ruang']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($dt_inv['garansi'])) : ?>
                            <tr>
                                <td>Tgl Garansi</td>
                                <td><?= $dt_inv['garansi']; ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?= $this->include('layouts/footer') ?>