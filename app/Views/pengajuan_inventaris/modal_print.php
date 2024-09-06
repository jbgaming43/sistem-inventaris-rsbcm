<div class="modal modal-blur fade" id="print_pengajuan_inventaris" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Print Data Pengajuan Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pengajuan_inventaris/print" method="POST" class="validation_print_inventaris" enctype="multipart/form-data" target="_blank">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Awal</label>
                        <div class="col">
                            <input type="date" class="form-control" name="tanggal_awal" placeholder="Masukkan tanggal">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Akhir</label>
                        <div class="col">
                            <input type="date" class="form-control" name="tanggal_akhir" placeholder="Masukkan tanggal">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Diajukan Oleh</label>
                        <div class="col">
                            <select class="form-select select2-pegawai2" name="nik" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($pgwc as $dt_pegawai) : ?>
                                    <option value="<?= $dt_pegawai['nik'] ?>"> <?= $dt_pegawai['nik'] ?>-<?= $dt_pegawai['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-seccondary" data-bs-dismiss="modal" onclick="resetForm('validation_print_inventaris')">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>