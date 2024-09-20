<div class="modal modal-blur fade" id="add_garansi_penerimaan_inventaris" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pemesanan Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/penerimaan_inventaris/add_garansi" method="POST" class="validation_penerimaan_inventaris" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nomor Inventaris</label>
                        <div class="col">
                            <select class="form-select select2-petugas" id="no_inventaris" name="no_inventaris" style="width: 100%" required>
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($inv_con as $dt_inv) : ?>
                                    <option value="<?= $dt_inv['no_inventaris'] ?>"> <?= $dt_inv['no_inventaris'] ?>-<?= $dt_inv['nama_barang'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Jumlah hari</label>
                        <div class="col">
                        <input type="number" class="form-control" id="hari" name="hari" placeholder="Masukkan hari" min="0" step="1" value="0" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Jumlah bulan</label>
                        <div class="col">
                        <input type="number" class="form-control" id="bulan" name="bulan" placeholder="Masukkan bulan" min="0" step="1" value="0" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Jumlah tahun</label>
                        <div class="col">
                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Masukkan tahun" min="0" step="1" value="0" required>
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