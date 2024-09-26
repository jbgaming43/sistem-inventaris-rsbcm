<div class="modal modal-blur fade" id="add_penerimaan_inventaris" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pembayaran Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/penerimaan_inventaris/add" method="POST" class="validation_penerimaan_inventaris" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nomor faktur</label>
                        <div class="col">
                            <input list="options" class="form-control" name="no_faktur" placeholder="Masukkan No faktur" id="no_faktur" oninput="fetchFaktur(this.value)">
                            <datalist id="options">
                                <?php foreach($pembelian_inv_con as $dt_pembelian_inv) :?>
                                <option value="<?= $dt_pembelian_inv['no_faktur']?>">
                                <?php endforeach?>
                            </datalist>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">SP/Order</label>
                        <div class="col">
                            <input type="text" class="form-control" id="no_order" name="no_order" placeholder="Masukkan SP/Order" id="no_faktur" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Tanggal Datang</label>
                        <div class="col">
                            <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" placeholder="Masukkan tanggal beli" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Tanggal Faktur</label>
                        <div class="col">
                            <input type="date" class="form-control" id="tgl_faktur" name="tgl_faktur" placeholder="Masukkan tanggal beli" readonly>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Jatuh Tempo</label>
                        <div class="col">
                            <input type="date" class="form-control" id="tgl_tempo" name="tgl_tempo" placeholder="Masukkan tanggal beli" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Supplier</label>
                        <div class="col">
                            <select class="form-select select2-petugas" id="kode_suplier" name="kode_suplier" style="width: 100%" readonly>
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
                            <select class="form-select select2-petugas" id="nip" name="nip" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($ptgc as $dt_petugas) : ?>
                                    <option value="<?= $dt_petugas['nip'] ?>"> <?= $dt_petugas['nip'] ?>-<?= $dt_petugas['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Akun Jenis</label>
                        <div class="col">
                            <select class="form-select" id="kd_rek_aset" name="kd_rek_aset" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($rekc as $dt_akunjenis) : ?>
                                    <option value="<?= $dt_akunjenis['kd_rek'] ?>"><?= $dt_akunjenis['nm_rek'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">PPN</label>
                        <div class="col">
                            <input type="number" class="form-control" id="ppn" name="ppn" placeholder="Masukkan PPN" min="0" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Biaya Tambahan</label>
                        <div class="col">
                            <input type="number" class="form-control" id="meterai" name="meterai" placeholder="Masukkan Biaya Tambahan" min="0" required>
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
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    
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

<script>
    let rowIndex = 0;

    // Fungsi untuk menambah baris
    function addRow() {
        rowIndex++;
        const tableBody = document.getElementById('table-body');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td><input type="text" id="kode_barang_${rowIndex}" name="kode_barang[]" class="form-control" readonly></td>
        <td>
            <select id="select_barang_${rowIndex}" class="form-select select2-barang" style="width: 100%" onchange="fetchBarangDetails(this.value, ${rowIndex})">
                <option value="">- Pilih Nama -</option>
                <?php foreach ($brgc as $dt_inventarisbarang) : ?>
                    <option value="<?= $dt_inventarisbarang['kode_barang'] ?>"><?= $dt_inventarisbarang['nama_barang'] ?></option>
                <?php endforeach ?>
            </select>
        </td>
        <td><input type="text" id="nama_produsen_${rowIndex}" name="nama_produsen[]" class="form-control" readonly></td>
        <td><input type="text" id="nama_merk_${rowIndex}" name="nama_merk[]" class="form-control" readonly></td>
        <td><input type="text" id="nama_jenis_${rowIndex}" name="nama_jenis[]" class="form-control" readonly></td>
        <td><input type="number" id="jumlah_${rowIndex}" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
        <td><input type="number" id="harga_beli_${rowIndex}" name="harga_beli[]" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" required></td>
        <td><input type="number" id="diskon_${rowIndex}" name="diskon[]" class="form-control" placeholder="Diskon (%)" min="0" max="100" step="0.01" required></td>
        <td><input type="text" id="total_${rowIndex}" name="total[]" class="form-control" readonly value="Rp0.00"></td>
        <!-- Tambahkan input hidden untuk subtotal dan potongan -->
        
        <td>
            <button type="button" class="btn btn-danger btn-icon" onclick="removeRow(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24V0H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </button>
        </td>
    `;
        tableBody.appendChild(newRow);
        setupEventListeners(rowIndex); // Setup event listeners for new row
    }

    // Fungsi untuk menghapus baris
    function removeRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>