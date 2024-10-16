<div class="modal modal-blur fade" id="add_permintaan_nonmedis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Permintaan Non Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/permintaan_non_medis/add" method="POST" class="validation_permintaan_non_medis" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nomor Permintaan</label>
                        <div class="col">
                            <input type="text" class="form-control" name="no_permintaan" placeholder="Masukkan No Permintaan" id="no_permintaan">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Ruang</label>
                        <div class="col">
                            <input type="text" class="form-control" name="ruang" placeholder="Masukkan RUang" id="ruang">
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
                            <select class="form-select select2-pegawai-add-min-nm" name="nik" style="width: 100%">
                                <option value="">- Pilih Nama -</option>
                                <?php foreach ($pgwc as $dt_pegawai) : ?>
                                    <option value="<?= $dt_pegawai['nik'] ?>"> <?= $dt_pegawai['nik'] ?>-<?= $dt_pegawai['nama'] ?></option>
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
                                        <th>Satuan</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <td><input type="text" id="kode_brng_0" name="kode_brng[]" class="form-control" readonly></td>
                                        <td><select id="select_barangnonmedis_perm_0" class="form-select select2-barangnonmedis-perm" style="width: 100%" onchange="fetchBarangNonMedisDetails(this.value, 0)">
                                                <option value="">- Pilih Nama -</option>
                                                <?php foreach ($ipsrsbarang_con as $dt_barangnonmedis) : ?>
                                                    <option value="<?= $dt_barangnonmedis['kode_brng'] ?>"><?= $dt_barangnonmedis['nama_brng'] ?></option>
                                                <?php endforeach ?>
                                            </select></td>
                                        <td><input type="text" id="kode_sat_0" name="kode_sat[]" class="form-control" readonly></td>
                                        <td><input type="text" id="jenis_0" name="jenis[]" class="form-control" readonly></td>
                                        <td><input type="number" id="jumlah_0" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
                                        <td><input type="text" id="keterangan_0" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
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
            <select id="select_barangnonmedis_perm_${rowIndex}" class="form-select select2-barangnonmedis-perm" style="width: 100%" onchange="fetchBarangNonMedisDetails(this.value, ${rowIndex})">
                <option value="">- Pilih Nama -</option>
                <?php foreach ($ipsrsbarang_con as $dt_barangnonmedis) : ?>
                    <option value="<?= $dt_barangnonmedis['kode_brng'] ?>"><?= $dt_barangnonmedis['nama_brng'] ?></option>
                <?php endforeach ?>
            </select>
        </td>
        <td><input type="text" id="kode_sat_${rowIndex}" name="kode_sat[]" class="form-control" readonly></td>
        <td><input type="text" id="jenis_${rowIndex}" name="jenis[]" class="form-control" readonly></td>
        <td><input type="number" id="jumlah_${rowIndex}" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
        <td><input type="text" id="keterangan_${rowIndex}" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
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
        $('#select_barangnonmedis_perm_' + rowIndex).select2({
            dropdownParent: $('#add_permintaan_nonmedis')
        });

        setupEventListenersNonMedis(rowIndex); // Setup event listeners for new row
    }
    
    // Fungsi untuk menghapus baris
    function removeRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>