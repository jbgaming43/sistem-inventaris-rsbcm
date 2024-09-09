<?php foreach ($pem_inv_con as $dt_pembelian_inventaris) : ?>
    <div class="modal modal-blur fade" id="edit_pembelian_inventaris<?= $dt_pembelian_inventaris['no_faktur']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pembelian Inventaris</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-form-<?= $dt_pembelian_inventaris['no_faktur']; ?>" method="POST" class="validation_pembelian_inventaris" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Nomor faktur</label>
                            <div class="col">
                                <input type="text" class="form-control" name="no_faktur" id="no_faktur-<?= $dt_pembelian_inventaris['no_faktur']; ?>" value="<?= $dt_pembelian_inventaris['no_faktur']; ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Tanggal beli</label>
                            <div class="col">
                                <input type="date" class="form-control" name="tgl_beli" id="tgl_beli-<?= $dt_pembelian_inventaris['no_faktur']; ?>" value="<?= $dt_pembelian_inventaris['tgl_beli']; ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Supplier</label>
                            <div class="col">
                                <select class="form-select select2-petugas" name="kode_suplier" id="kode_suplier-<?= $dt_pembelian_inventaris['no_faktur']; ?>" style="width: 100%">
                                    <?= $kode_suplier = $dt_pembelian_inventaris['kode_suplier']; ?>
                                    <option value="" <?= $kode_suplier == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($supc as $dt_suplier) : ?>
                                        <option value="<?= $dt_suplier['kode_suplier'] ?>" <?= $dt_suplier['kode_suplier'] == $kode_suplier ? 'selected' : null; ?>> <?= $dt_suplier['kode_suplier'] ?>-<?= $dt_suplier['nama_suplier'] ?></option>
                                    <?php endforeach ?>
                                </select>

                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Petugas</label>
                            <div class="col">
                                <select class="form-select select2-petugas" name="nip" style="width: 100%">
                                    <?= $nip = $dt_pembelian_inventaris['nip']; ?>
                                    <option value="" <?= $nip == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($ptgc as $dt_petugas) : ?>
                                        <option value="<?= $dt_petugas['nip'] ?>" <?= $dt_petugas['nip'] == $nip ? 'selected' : null; ?>> <?= $dt_petugas['nip'] ?>-<?= $dt_petugas['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Akun Bayar</label>
                            <div class="col">
                                <select class="form-select" name="kd_rek" style="width: 100%">
                                    <?= $kd_rek = $dt_pembelian_inventaris['kd_rek']; ?>
                                    <option value="" <?= $kd_rek == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($akbc as $dt_akunbayar) : ?>
                                        <option value="<?= $dt_akunbayar['kd_rek'] ?>" <?= $dt_akunbayar['kd_rek'] == $kd_rek ? 'selected' : null; ?>><?= $dt_akunbayar['nama_bayar'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Akun Jenis</label>
                            <div class="col">
                                <select class="form-select" name="kd_rek_aset" style="width: 100%">
                                    <?= $kd_rek_aset = $dt_pembelian_inventaris['kd_rek_aset']; ?>
                                    <option value="" <?= $kd_rek_aset == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($rekc as $dt_akunjenis) : ?>
                                        <option value="<?= $dt_akunjenis['kd_rek'] ?>" <?= $dt_akunjenis['kd_rek'] == $kd_rek_aset ? 'selected' : null; ?>><?= $dt_akunjenis['nm_rek'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">PPN</label>
                            <div class="col">
                                <input type="number" class="form-control" id="ppn" name="ppn" placeholder="Masukkan PPN" min="0" value="<?= $dt_pembelian_inventaris['ppn']; ?>" required>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Biaya Tambahan</label>
                            <div class="col">
                                <input type="number" class="form-control" id="meterai" name="meterai" placeholder="Masukkan Biaya Tambahan" min="0" value="<?= $dt_pembelian_inventaris['meterai']; ?>" required>
                            </div>
                        </div>
                        <!-- Add other fields similarly -->
                        <!-- Table for items -->
                        <div class="mb-2 row">
                            <div class="col">
                                <table class="table table-sm table-bordered" id="inventoryTable-<?= $dt_pembelian_inventaris['no_faktur']; ?>">
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
                                    <tbody id="table-body-<?= $dt_pembelian_inventaris['no_faktur']; ?>">
                                        <!-- Rows will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    let rowIndex2 = 0;
    document.addEventListener('DOMContentLoaded', function() {
        <?php foreach ($pem_inv_con as $dt_pembelian_inventaris) : ?>
                (function(modalId, tableBodyId, detailUrl) {
                    document.getElementById(modalId).addEventListener('show.bs.modal', function() {
                        console.log('Modal is about to be shown');
                        fetch(detailUrl)
                            .then(response => response.json())
                            .then(data => {
                                console.log(data)
                                var tableBody = document.getElementById(tableBodyId);
                                var content = '';
                                data.forEach(item => {
                                    content += `<tr>
                                <td><input type="text" id="2kode_barang_${rowIndex2}" name="kode_barang[]" class="form-control" value="${item.kode_barang}" readonly></td>
                                <td>
                                    <select class="form-select select2-barang" style="width: 100%" onchange="fetchBarangDetails2(this.value, ${rowIndex2})">
                                        <option value="">- Pilih Nama -</option>
                                        <?php foreach ($brgc as $dt_inventarisbarang) : ?>
                                            <option value="<?= $dt_inventarisbarang['kode_barang'] ?>" 
                                                ${'<?= $dt_inventarisbarang['kode_barang'] ?>' === item.kode_barang ? 'selected' : ''}>
                                                <?= $dt_inventarisbarang['kode_barang'] ?> - <?= $dt_inventarisbarang['nama_barang'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" id="2nama_produsen_${rowIndex2}" name="nama_produsen[]" class="form-control" value="${item.nama_produsen}" readonly></td>
                                <td><input type="text" id="2nama_merk_${rowIndex2}" name="nama_merk[]" class="form-control" value="${item.nama_merk}" readonly></td>
                                <td><input type="text" id="2nama_jenis_${rowIndex2}" name="nama_jenis[]" class="form-control" value="${item.nama_jenis}" readonly></td>
                                <td><input type="number" id="2jumlah_${rowIndex2}" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" value="${item.jumlah}" required></td>
                                <td><input type="number" id="2harga_beli_${rowIndex2}" name="harga_beli[]" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" value="${item.harga}" required></td>
                                <td><input type="number" id="2diskon_${rowIndex2}" name="diskon[]" class="form-control" placeholder="Diskon (%)" min="0" max="100" step="0.01" value="${item.dis}" required></td>
                                <td><input type="text" id="2total_${rowIndex2}" name="total[]" class="form-control" readonly value="${item.total}"></td>
                                <td><button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Hapus</button></td>
                            </tr>`;
                                    rowIndex2++;
                                });
                                tableBody.innerHTML = content;

                                // Memanggil setupEventListeners setelah baris ditambahkan ke DOM
                                for (let i = 0; i < rowIndex2; i++) {
                                    setupEventListeners2(i);
                                }
                            })
                            .catch(error => console.error('Error fetching details:', error));
                    });
                })(
                    'edit_pembelian_inventaris<?= $dt_pembelian_inventaris['no_faktur']; ?>',
                    'table-body-<?= $dt_pembelian_inventaris['no_faktur']; ?>',
                    '<?= base_url('pembelian_inventaris/detail/' . $dt_pembelian_inventaris['no_faktur']); ?>'
                );
        <?php endforeach; ?>
    });
</script>