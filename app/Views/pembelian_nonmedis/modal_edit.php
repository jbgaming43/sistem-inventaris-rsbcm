<?php foreach ($pem_nonmedis_con as $dt_pembelian_nonmedis) : ?>
    <div class="modal modal-blur fade" id="edit_pembelian_nonmedis<?= $dt_pembelian_nonmedis['no_faktur']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pembelian NonMedis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pembelian_non_medis/edit/<?= $dt_pembelian_nonmedis['no_faktur']; ?>" id="edit-form-<?= $dt_pembelian_nonmedis['no_faktur']; ?>" method="POST" class="validation_pembelian_inventaris" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Nomor faktur</label>
                            <div class="col">
                                <input type="hidden" class="form-control" name="no_faktur" id="no_faktur-<?= $dt_pembelian_nonmedis['no_faktur']; ?>" value="<?= $dt_pembelian_nonmedis['no_faktur']; ?>" readonly>
                                <input type="text" class="form-control" name="no_faktur_new" id="no_faktur-<?= $dt_pembelian_nonmedis['no_faktur']; ?>" value="<?= $dt_pembelian_nonmedis['no_faktur']; ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Tanggal beli</label>
                            <div class="col">
                                <input type="date" class="form-control" name="tgl_beli" id="tgl_beli-<?= $dt_pembelian_nonmedis['no_faktur']; ?>" value="<?= $dt_pembelian_nonmedis['tgl_beli']; ?>">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Supplier</label>
                            <div class="col">
                                <select class="form-select select2-petugas" name="kode_suplier" id="kode_suplier-<?= $dt_pembelian_nonmedis['no_faktur']; ?>" style="width: 100%">
                                    <?= $kode_suplier = $dt_pembelian_nonmedis['kode_suplier']; ?>
                                    <option value="" <?= $kode_suplier == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($ipsrs_sup_con as $dt_suplier) : ?>
                                        <option value="<?= $dt_suplier['kode_suplier'] ?>" <?= $dt_suplier['kode_suplier'] == $kode_suplier ? 'selected' : null; ?>> <?= $dt_suplier['kode_suplier'] ?>-<?= $dt_suplier['nama_suplier'] ?></option>
                                    <?php endforeach ?>
                                </select>

                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Petugas</label>
                            <div class="col">
                                <select class="form-select select2-petugas" name="nip" style="width: 100%">
                                    <?= $nip = $dt_pembelian_nonmedis['nip']; ?>
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
                                    <?= $kd_rek = $dt_pembelian_nonmedis['kd_rek']; ?>
                                    <option value="" <?= $kd_rek == '' ? 'selected' : null; ?>>- Pilih Nama -</option>
                                    <?php foreach ($akbc as $dt_akunbayar) : ?>
                                        <option value="<?= $dt_akunbayar['kd_rek'] ?>" <?= $dt_akunbayar['kd_rek'] == $kd_rek ? 'selected' : null; ?>><?= $dt_akunbayar['nama_bayar'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">PPN</label>
                            <div class="col">
                                <input type="number" class="form-control" id="ppn" name="ppn" placeholder="Masukkan PPN" min="0" value="<?= $dt_pembelian_nonmedis['ppn']; ?>" required>
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label class="col-3 col-form-label required">Biaya Tambahan</label>
                            <div class="col">
                                <input type="number" class="form-control" id="meterai" name="meterai" placeholder="Masukkan Biaya Tambahan" min="0" value="<?= $dt_pembelian_nonmedis['meterai']; ?>" required>
                            </div>
                        </div>
                        <!-- Add other fields similarly -->

                        <!-- Table for items -->
                        <div class="mb-2 row">
                            <div class="col">
                                <table class="table table-sm table-bordered" id="inventoryTable-<?= $dt_pembelian_nonmedis['no_faktur']; ?>">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>Diskon</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-<?= $dt_pembelian_nonmedis['no_faktur']; ?>" class="table-body">
                                        <!-- Rows will be populated by JavaScript -->
                                    </tbody>
                                    <tr>
                                        <td colspan="8"></td>
                                        <td><button type="button" class="btn btn-primary btn-icon" onclick="addRow2(this, '<?= $dt_pembelian_nonmedis['no_faktur']; ?>')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 5l0 14"></path>
                                                    <path d="M5 12l14 0"></path>
                                                </svg>
                                            </button></td>
                                    </tr>
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
        <?php foreach ($pem_nonmedis_con as $dt_pembelian_nonmedis) : ?>
                (function(modalId, tableBodyId, detailUrl) {
                    document.getElementById(modalId).addEventListener('show.bs.modal', function() {
                        console.log('Modal is about to be shown');
                        fetch(detailUrl)
                            .then(response => response.json())
                            .then(data => {
                                var tableBody = document.getElementById(tableBodyId);
                                var content = '';
                                data.forEach(item => {
                                    content += `<tr>
                                <td><input type="text" id="kode_barang_${rowIndex2}" name="2kode_brng[]" class="form-control" value="${item.kode_brng}" readonly required></td>
                                <td>
                                    <select id="2select_barang_${rowIndex2}" class="form-select select2-barang" style="width: 100%" onchange="fetchBarangNonMedisDetails(this.value, ${rowIndex2})">
                                        <option value="">- Pilih Nama -</option>
                                        <?php foreach ($ipsrs_barang_con as $dt_inventarisbarang) : ?>
                                            <option value="<?= $dt_inventarisbarang['kode_brng'] ?>" 
                                                ${'<?= $dt_inventarisbarang['kode_brng'] ?>' === item.kode_brng ? 'selected' : ''}>
                                                <?= $dt_inventarisbarang['nama_brng'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" id="kode_sat_${rowIndex2}" name="kode_sat[]" class="form-control" value="${item.kode_sat}" readonly required></td>
                                <td><input type="text" id="jenis_${rowIndex2}" name="jenis[]" class="form-control" value="${item.nm_jenis}" readonly required></td>
                                <td><input type="number" id="jumlah_${rowIndex2}" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" value="${item.jumlah}" required></td>
                                <td><input type="number" id="harga_${rowIndex2}" name="harga[]" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" value="${item.harga}" required></td>
                                <td><input type="number" id="diskon_${rowIndex2}" name="diskon[]" class="form-control" placeholder="Diskon (%)" min="0" max="100" step="0.01" value="${item.dis}" required></td>
                                <td><input type="text" id="total_${rowIndex2}" name="total[]" class="form-control" readonly value="${item.total}"></td>
                                <td><button type="button" class="btn btn-danger btn-icon" onclick="deleteRow(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24V0H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button></td>
                            </tr>`;
                                    rowIndex2++;
                                });
                                tableBody.innerHTML = content;

                                // Initialize Select2 on dynamically added selects
                                $('.select2-barang').select2({
                                    dropdownParent: $(`#${modalId}`)
                                });

                                // Memanggil setupEventListeners setelah baris ditambahkan ke DOM
                                for (let i = 0; i < rowIndex2; i++) {
                                    setupEventListeners2(i);
                                }
                            })
                            .catch(error => console.error('Error fetching details:', error));
                    });
                })(
                    'edit_pembelian_nonmedis<?= $dt_pembelian_nonmedis['no_faktur']; ?>',
                    'table-body-<?= $dt_pembelian_nonmedis['no_faktur']; ?>',
                    '<?= base_url('pembelian_non_medis/detail/' . $dt_pembelian_nonmedis['no_faktur']); ?>'
                );
        <?php endforeach; ?>
    });

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        button.closest('tr').remove();
    }

    function addRow2(button, noFaktur) {
        rowIndex2++;
        const tableBody = document.getElementById('table-body-' + noFaktur);

        if (!tableBody) {
            console.error("Tbody tidak ditemukan untuk no_faktur:", noFaktur);
            return;
        }

        const newRow = document.createElement('tr');

        newRow.innerHTML = `
        <td><input type="text" id="2kode_barang_${rowIndex2}" name="2kode_barang[]" class="form-control" style="pointer-events: none;" required data-readonly></td>
        <td>
            <select class="form-select select2-barang" id="2select_barang_${rowIndex2}" style="width: 100%" onchange="fetchBarangDetails2(this.value, ${rowIndex2})">
                <option value="">- Pilih Nama -</option>
                <?php foreach ($ipsrs_barang_con as $dt_inventarisbarang) : ?>
                    <option value="<?= $dt_inventarisbarang['kode_brng'] ?>"><?= $dt_inventarisbarang['nama_brng'] ?></option>
                <?php endforeach ?>
            </select>
        </td>
        <td><input type="text" id="2nama_merk_${rowIndex2}" name="2nama_merk[]" class="form-control" readonly></td>
        <td><input type="text" id="2nama_jenis_${rowIndex2}" name="2nama_jenis[]" class="form-control" readonly></td>
        <td><input type="number" id="2jumlah_${rowIndex2}" name="2jumlah[]" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
        <td><input type="number" id="2harga_beli_${rowIndex2}" name="2harga_beli[]" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" required></td>
        <td><input type="number" id="2diskon_${rowIndex2}" name="2diskon[]" class="form-control" placeholder="Diskon (%)" min="0" max="100" step="0.01" required></td>
        <td><input type="text" id="2total_${rowIndex2}" name="2total[]" class="form-control" readonly value="Rp0.00"></td>
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

        // Inisialisasi Select2 pada elemen yang baru ditambahkan
        $(`#2select_barang_${rowIndex2}`).select2({
            dropdownParent: $(`#edit_pembelian_inventaris${noFaktur}`) // pastikan dropdownParent mengacu pada modal yang benar
        });

        setupEventListeners2(rowIndex2); // Setup event listeners for new row
    }
</script>