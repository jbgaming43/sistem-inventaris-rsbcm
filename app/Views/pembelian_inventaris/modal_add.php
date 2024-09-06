<div class="modal modal-blur fade" id="add_pembelian_inventaris" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pembelian Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pembelian_inventaris/add" method="POST" class="validation_pembelian_inventaris" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nomor faktur</label>
                        <div class="col">
                            <input type="text" class="form-control" name="no_faktur" placeholder="Masukkan No faktur" id="no_faktur">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Tanggal beli</label>
                        <div class="col">
                            <input type="date" class="form-control" name="tgl_beli" placeholder="Masukkan tanggal beli">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Supplier</label>
                        <div class="col">
                            <select class="form-select select2-petugas" name="kode_suplier" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($supc as $dt_suplier) : ?>
                                    <option value="<?= $dt_suplier['kode_suplier'] ?>"> <?= $dt_suplier['kode_suplier'] ?>-<?= $dt_suplier['nama_suplier'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Petugas</label>
                        <div class="col">
                            <select class="form-select select2-petugas" name="nip" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($ptgc as $dt_petugas) : ?>
                                    <option value="<?= $dt_petugas['nip'] ?>"> <?= $dt_petugas['nip'] ?>-<?= $dt_petugas['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Akun Bayar</label>
                        <div class="col">
                            <select class="form-select" name="kd_rek" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($akbc as $dt_akunbayar) : ?>
                                    <option value="<?= $dt_akunbayar['kd_rek'] ?>"><?= $dt_akunbayar['nama_bayar'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Akun Jenis</label>
                        <div class="col">
                            <select class="form-select" name="kd_rek" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($rekc as $dt_akunjenis) : ?>
                                    <option value="<?= $dt_akunjenis['kd_rek'] ?>"><?= $dt_akunjenis['nm_rek'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col">
                            <table class="table table-sm table-bordered" id="inventoryTable">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Produsen</th>
                                        <th>Merk</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Harga Beli</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <td><input type="text" id="kode_barang_0" name="kode_barang[]" class="form-control" readonly></td>
                                        <td><select class="form-select select2-barang" name="kode_barang[]" style="width: 100%" onchange="fetchBarangDetails(this.value, 0)">
                                                <option value="">- Pilih Nama -</option>
                                                <?php foreach ($brgc as $dt_inventarisbarang) : ?>
                                                    <option value="<?= $dt_inventarisbarang['kode_barang'] ?>"><?= $dt_inventarisbarang['nama_barang'] ?></option>
                                                <?php endforeach ?>
                                            </select></td>
                                        <td><input type="text" id="nama_produsen_0" name="nama_produsen[]" class="form-control" readonly></td>
                                        <td><input type="text" id="nama_merk_0" name="nama_merk[]" class="form-control" readonly></td>
                                        <td><input type="text" id="nama_jenis_0" name="nama_jenis[]" class="form-control" readonly></td>
                                        <td><input type="number" id="jumlah_0" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
                                        <td><input type="number" id="harga_beli_0" name="harga_beli[]" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" required></td>
                                        <td><input type="number" id="diskon_0" name="diskon[]" class="form-control" placeholder="Diskon (%)" min="0" max="100" step="0.01" required></td>
                                        <td><input type="text" id="total_0" class="form-control" readonly value="Rp0.00"></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="addRow()">Tambah</button>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-seccondary" data-bs-dismiss="modal" onclick="resetForm('validation_pengguna')">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>