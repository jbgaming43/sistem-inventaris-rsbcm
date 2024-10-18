<div class="modal modal-blur fade" id="add_penerimaan_nonmedis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Penerimaan Non Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/penerimaan_non_medis/add" method="POST" class="validation_penerimaan_nonmedis" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Nomor faktur</label>
                        <div class="col">
                            <input list="options" class="form-control" name="no_faktur" placeholder="Masukkan No faktur" id="no_faktur" oninput="fetchFakturNonMedis(this.value)">
                            <datalist id="options">
                                <?php foreach ($pembelian_nonmedis_con as $dt_pembelian_nonmedis) : ?>
                                    <option value="<?= $dt_pembelian_nonmedis['no_faktur'] ?>">
                                    <?php endforeach ?>
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
                                        <th>Satuan</th>
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
    function fetchFakturNonMedis(no_faktur) {
        if (no_faktur) {

            $.ajax({
                url: '/penerimaan_non_medis/pilih_no_faktur',
                type: 'GET',
                data: {
                    no_faktur: no_faktur
                },
                dataType: 'json',
                success: function(data) {
                    // Pastikan data adalah array dan memiliki elemen
                    if (data && data.length > 0) {
                        var faktur = data[0]; // Mengambil elemen pertama dari array

                        // Update fields with the retrieved data
                        $('#tgl_faktur').val(faktur.tgl_beli);
                        $('#kode_suplier').val(faktur.kode_suplier);
                        $('#nip').val(faktur.nip);
                        $('#ppn').val(faktur.ppn);
                        $('#meterai').val(faktur.meterai);

                        console.log(no_faktur);
                        // Fetch inventory details for the faktur
                        fetch(`/pembelian_non_medis/detail/${no_faktur}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log(data.detail);
                                    fillInventoryTablePenerimaanNonMedis(data.detail);
                                } else {
                                    alert('No faktur tidak ditemukan.');
                                }
                            })
                            .catch(error => console.error('Error fetching data:', error));


                    } else {
                        // Kosongkan field jika data tidak ditemukan
                        $('#tgl_faktur').val('');
                        $('#kode_suplier').val('');
                        $('#nip').val('');
                        $('#ppn').val('');
                        $('#meterai').val('');
                    }
                }
            });
        }
    }

    /* FUNCTION UNTUK MENGISI TABEL DETAIL BARANG */
    function fillInventoryTablePenerimaanNonMedis(items) {
        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = ''; // Kosongkan tabel sebelum mengisi ulang

        items.forEach((item, index) => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td><input type="text" id="kode_barang_${index}" name="kode_barang[]" class="form-control" value="${item.kode_brng}" readonly></td>
            <td><input type="text" id="nama_barang_${index}" name="nama_barang[]" class="form-control" value="${item.nama_brng}" readonly></td>
            <td><input type="text" id="kode_sat_${index}" name="kode_sat[]" class="form-control" value="${item.kode_sat}" readonly></td>
            <td><input type="text" id="nama_jenis_${index}" name="nama_jenis[]" class="form-control" value="${item.nm_jenis}" readonly></td>
            <td><input type="number" id="jumlah_${index}" name="jumlah[]" class="form-control" value="${item.jumlah}" readonly></td>
            <td><input type="number" id="harga_beli_${index}" name="harga_beli[]" class="form-control" value="${item.harga}" readonly></td>
            <td><input type="number" id="diskon_${index}" name="diskon[]" class="form-control" value="${item.dis}" readonly></td>
            <td><input type="text" id="total_${index}" name="total[]" class="form-control" value="${item.total}" readonly></td>
        `;
            tableBody.appendChild(newRow);
        });
    }
</script>