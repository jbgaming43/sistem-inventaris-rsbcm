<div class="modal modal-blur fade" id="add_pembayaran_inventaris" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pemesanan Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pembayaran_inventaris/add" method="POST" class="validation_pembayaran_inventaris" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nomor faktur</label>
                        <div class="col">
                        <select class="form-select" id="nip" name="nip" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($penerimaan_inv_con as $dt_penerimaan_inv) : ?>
                                    <option value="<?= $dt_penerimaan_inv['no_faktur'] ?>"><?= $dt_penerimaan_inv['no_faktur'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Tanggal bayar</label>
                        <div class="col">
                            <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar" placeholder="Masukkan tanggal beli" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Petugas</label>
                        <div class="col">
                            <select class="form-select select2-petugas" id="nip" name="nip" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($ptgc as $dt_petugas) : ?>
                                    <option value="<?= $dt_petugas['nip'] ?>"> <?= $dt_petugas['nip'] ?>-<?= $dt_petugas['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Biaya</label>
                        <div class="col">
                            <input type="number" class="form-control" id="ppn" name="ppn" placeholder="Masukkan PPN" min="0" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">keterangan</label>
                        <div class="col">
                            <textarea class="form-control" id="meterai" name="meterai" placeholder="Masukkan Keterangan" required></textarea>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Akun Bayar Hutang</label>
                        <div class="col">
                            <select class="form-select select2-petugas" id="nip" name="nip" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($akun_bayar_hutang_con as $dt_akun_bayar_hutang) : ?>
                                    <option value="<?= $dt_akun_bayar_hutang['nama_bayar'] ?>"> <?= $dt_akun_bayar_hutang['nama_bayar'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">nomor bukti</label>
                        <div class="col">
                            <textarea class="form-control" id="meterai" name="meterai" placeholder="Masukkan Nomor Bukti" required></textarea>
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