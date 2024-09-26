<div class="modal modal-blur fade" id="add_pengajuan_nonmedis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pengajuan non_medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pengajuan_non_medis/add" method="POST" class="validation_pengajuan_non_medis" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nomor Pengajuan</label>
                        <div class="col">
                            <input type="text" class="form-control" name="no_pengajuan" placeholder="Masukkan No Pengajuan" id="no_pengajuan">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Tanggal</label>
                        <div class="col">
                            <input type="date" class="form-control" name="tanggal" placeholder="Masukkan tanggal">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Diajukan Oleh</label>
                        <div class="col">
                            <select class="form-select select2-pegawai" name="nik" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($pgwc as $dt_pegawai) : ?>
                                    <option value="<?= $dt_pegawai['nik'] ?>"> <?= $dt_pegawai['nik'] ?>-<?= $dt_pegawai['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Keterangan</label>
                        <div class="col">
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan"></textarea>
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