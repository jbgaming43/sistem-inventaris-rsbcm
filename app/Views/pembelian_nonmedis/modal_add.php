<div class="modal modal-blur fade" id="add_pembelian_nonmedis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pembelian nonmedis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pembelian_nonmedis/add" method="POST" class="validation_pembelian_nonmedis" enctype="multipart/form-data">
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
                        <label class="col-3 col-form-label required">Akun Jenis</label>
                        <div class="col">
                            <select class="form-select" name="kd_rek_aset" style="width: 100%">
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <td><input type="text" id="kode_brng_0" name="kode_brng[]" class="form-control" readonly></td>
                                        <td><select id="select_barang_0" class="form-select select2-barang1" style="width: 100%" onchange="fetchBarangDetails(this.value, 0)">
                                                <option value="">- Pilih Nama -</option>
                                                <?php foreach ($ipsrs_barang_con as $dt_ipsrs_barang) : ?>
                                                    <option value="<?= $dt_ipsrs_barang['kode_brng'] ?>"><?= $dt_ipsrs_barang['nama_brng'] ?></option>
                                                <?php endforeach ?>
                                            </select></td>
                                        <td><input type="text" id="nama_produsen_0" name="nama_produsen[]" class="form-control" readonly></td>
                                        <td><input type="text" id="nama_merk_0" name="nama_merk[]" class="form-control" readonly></td>
                                        <td><input type="text" id="nama_jenis_0" name="nama_jenis[]" class="form-control" readonly></td>
                                        <td><input type="number" id="jumlah_0" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
                                        <td><input type="number" id="harga_beli_0" name="harga_beli[]" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" required></td>
                                        <td><input type="number" id="diskon_0" name="diskon[]" class="form-control" placeholder="Diskon (%)" min="0" max="100" step="0.01" required></td>
                                        <td><input type="text" id="total_0" name="total[]" class="form-control" readonly value="Rp0.00"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-icon" onclick="addRow()">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 5l0 14"></path>
                                                    <path d="M5 12l14 0"></path>
                                                </svg>
                                            </button>
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

<script>
    let rowIndex = 0;

    // Fungsi untuk menambah baris
    function addRow() {
        rowIndex++;
        const tableBody = document.getElementById('table-body');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td><input type="text" id="kode_brng_${rowIndex}" name="kode_brng[]" class="form-control" readonly></td>
        <td>
            <select id="select_barang_${rowIndex}" class="form-select select2-barang1" style="width: 100%" onchange="fetchBarangNonMedisDetails(this.value, ${rowIndex})">
                <option value="">- Pilih Nama -</option>
                <?php foreach ($ipsrs_barang_con as $dt_ipsrs_barang) : ?>
                    <option value="<?= $dt_ipsrs_barang['kode_brng'] ?>"><?= $dt_ipsrs_barang['nama_brng'] ?></option>
                <?php endforeach ?>
            </select>
        </td>
        <td><input type="text" id="kode_sat_${rowIndex}" name="kode_sat[]" class="form-control" readonly></td>
        <td><input type="text" id="jenis_${rowIndex}" name="jenis[]" class="form-control" readonly></td>
        <td><input type="number" id="jumlah_${rowIndex}" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
        <td><input type="number" id="harga_${rowIndex}" name="harga[]" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" required></td>
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
        // Inisialisasi Select2 pada elemen baru
        $('#select_barang_' + rowIndex).select2({
            dropdownParent: $('#add_pembelian_nonmedis')
        });

        setupEventListeners(rowIndex); // Setup event listeners for new row
    }

    // Fungsi untuk menghapus baris
    function removeRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>