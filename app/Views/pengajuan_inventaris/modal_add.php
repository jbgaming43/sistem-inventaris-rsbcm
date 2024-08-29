<div class="modal modal-blur fade" id="add_pengajuan_inventaris" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pengajuan Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pengajuan_inventaris/add" method="POST" class="validation_pengajuan_inventaris" enctype="multipart/form-data">
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
                        <label class="col-3 col-form-label required">Urgensi</label>
                        <div class="col">
                            <select class="form-select" name="urgensi">
                                <option value="">- Pilih Urgensi -</option>
                                <option value="Cito">Cito</option>
                                <option value="Emergensi">Emergensi</option>
                                <option value="Biasa">Biasa</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Latar Belakang</label>
                        <div class="col">
                            <textarea class="form-control" name="latar_belakang" placeholder="Masukkan Latar Belakang"></textarea>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nama Barang</label>
                        <div class="col">
                            <input type="text" class="form-control" name="nama_barang" placeholder="Masukkan nama barang">
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label class="col-3 col-form-label">Sepsifikasi</label>
                        <div class="col">
                            <textarea class="form-control" name="spesifikasi" placeholder="Masukkan spesifikasi"></textarea>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Jumlah</label>
                        <div class="col">
                            <input class="form-control" type="number" id="jumlah" name="jumlah" min="0" step="1">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Harga</label>
                        <div class="col">
                            <input class="form-control" type="number" id="harga" name="harga" min="0" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Keterangan</label>
                        <div class="col">
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan keterangan"></textarea>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">NIK P.J.</label>
                        <div class="col">
                            <select class="form-select select2-pegawai" name="nik_pj" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($pgwc as $dt_pegawai) : ?>
                                    <option value="<?= $dt_pegawai['nik'] ?>"> <?= $dt_pegawai['nik'] ?>-<?= $dt_pegawai['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
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