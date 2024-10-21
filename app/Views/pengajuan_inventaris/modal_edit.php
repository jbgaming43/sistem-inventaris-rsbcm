<?php foreach ($pengajuan_inv_con as $dt_pengajuan_inventaris) { ?>
    <div class="modal modal-blur fade" id="edit_pengajuan_inventaris<?= $dt_pengajuan_inventaris['no_pengajuan']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pengajuan Inventaris</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pengajuan_inventaris/edit/<?= $dt_pengajuan_inventaris['no_pengajuan']; ?>" method="POST" class="validation_pengajuan_inventaris" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Nomor Pengajuan</label>
                            <div class="col">
                                <input type="hidden" class="form-control" name="no_pengajuan" id="no_pengajuan" value="<?= $dt_pengajuan_inventaris['no_pengajuan']; ?>">
                                <input type="text" class="form-control" name="no_pengajuan_new" placeholder="Masukkan No Pengajuan" id="no_pengajuan" value="<?= $dt_pengajuan_inventaris['no_pengajuan']; ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Tanggal</label>
                            <div class="col">
                                <input type="date" class="form-control" name="tanggal" placeholder="Masukkan tanggal" value="<?= $dt_pengajuan_inventaris['tanggal']; ?>">
                            </div>
                        </div>
                        <div class="mb-2 row" >
                            <label class="col-3 col-form-label required">Diajukan Oleh</label>
                            <div class="col">
                                <select class="form-select" name="nik" style="width: 100%">
                                    <?= $nik = $dt_pengajuan_inventaris['nik']; ?>
                                    <option value="" <?= $nik == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($pegawai_con as $dt_pegawai) : ?>
                                        <option value="<?= $dt_pegawai['nik'] ?>" <?= $dt_pegawai['nik'] == $nik ? 'selected' : null; ?>> <?= $dt_pegawai['nik'] ?>-<?= $dt_pegawai['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Urgensi</label>
                            <div class="col">
                                <select class="form-select" name="urgensi">
                                    <?= $urgensi = $dt_pengajuan_inventaris['urgensi']; ?>
                                    <option value="" <?= $urgensi == '' ? 'selected' : null; ?>>- Pilih Urgensi -</option>
                                    <option value="Cito" <?= $urgensi == 'Cito' ? 'selected' : null; ?>>Cito</option>
                                    <option value="Emergensi" <?= $urgensi == 'Emergensi' ? 'selected' : null; ?>>Emergensi</option>
                                    <option value="Biasa" <?= $urgensi == 'Biasa' ? 'selected' : null; ?>>Biasa</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Latar Belakang</label>
                            <div class="col">
                                <textarea class="form-control" name="latar_belakang" placeholder="Masukkan Latar Belakang"><?= $dt_pengajuan_inventaris['latar_belakang']; ?></textarea>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Nama Barang</label>
                            <div class="col">
                                <input type="text" class="form-control" name="nama_barang" placeholder="Masukkan nama barang" value="<?= $dt_pengajuan_inventaris['nama_barang'] ?>">
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label class="col-3 col-form-label">Spesifikasi</label>
                            <div class="col">
                                <textarea class="form-control" name="spesifikasi" placeholder="Masukkan spesifikasi"><?= $dt_pengajuan_inventaris['spesifikasi']; ?></textarea>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Jumlah</label>
                            <div class="col">
                                <input class="form-control" type="number" id="jumlah" name="jumlah" min="0" step="1" value="<?= $dt_pengajuan_inventaris['jumlah'] ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Harga</label>
                            <div class="col">
                                <input class="form-control" type="number" id="harga" name="harga" min="0" step="0.01" placeholder="0.00" value="<?= $dt_pengajuan_inventaris['harga'] ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Keterangan</label>
                            <div class="col">
                                <textarea class="form-control" name="keterangan" placeholder="Masukkan keterangan"><?= $dt_pengajuan_inventaris['keterangan'] ?></textarea>
                            </div>
                        </div>
                        <div class="mb-2 row" id="add_pengajuan_inventaris2">
                            <label class="col-3 col-form-label required">NIK P.J.</label>
                            <div class="col">
                                <select class="form-select" name="nik_pj" style="width: 100%">
                                    <?= $nik_pj = $dt_pengajuan_inventaris['nik_pj']; ?>
                                    <option value="" <?= $nik_pj == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($pegawai_con as $dt_pegawai) : ?>
                                        <option value="<?= $dt_pegawai['nik'] ?>" <?= $dt_pegawai['nik'] == $nik_pj ? 'selected' : null; ?>> <?= $dt_pegawai['nik'] ?>-<?= $dt_pegawai['nama'] ?></option>
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

    <script>
        $(document).ready(function() {
            $('.select2-pegawai-add-inv').select2({
                dropdownParent: $('#edit_pengajuan_inventaris<?= $dt_pengajuan_inventaris['no_pengajuan']; ?>')
            });
        });
        $(document).ready(function() {
            $('.select2-pegawai-add-inv2').select2({
                dropdownParent: $('#edit_pengajuan_inventaris2')
            });
        });
    </script>
<?php } ?>