<!-- FILE KHUSUS UNTUK MENULISKAN SCRIPT CUSTOM -->

<!-- SCRIPT DATATABLE -->
<script>
    $(document).ready(function() {
        $('.dtTable').DataTable({
            "lengthChange": true,
            "autoWidth": true,
            "initComplete": function(settings, json) {
                $(".dtTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
        });
    })
    $(document).ready(function() {
        $('.dtTableDataset').DataTable({
            // "paging": false,
            "info": false,
            "lengthChange": true,
            "autoWidth": true,
            "initComplete": function(settings, json) {
                $(".dtTableDataset").wrap(
                    "<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
            "scroller": true,
            "lengthMenu": [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ], // Customize the entries per page
            "pageLength": -1,
            "order": [
                [1, 'asc']
            ], // Urutkan berdasarkan kolom ID (kolom kedua, indeks 1)
        });
    })
</script>

<!-- SCRIPT JS CUSTOM RESET FORM -->
<script>
    // fungsi untuk mereset elemen form
    function resetForm(formClass) {
        var form = $('.' + formClass);

        // Menghapus kelas is-invalid dan is-valid dari semua elemen dalam formulir
        form.find('.input-group').removeClass('is-invalid is-valid');
        form.find('.is-valid').removeClass('is-valid');
        form.find('.is-invalid').removeClass('is-invalid');

        // Menghapus pesan kesalahan yang ditambahkan oleh jQuery Validation
        form.find('.invalid-feedback').remove();

        // Menghapus nilai input
        form[0].reset();

        // Mereset status validasi
        form.validate().reset();
    }
</script>

<!-- SCRIPT JQUERY VALIDATION -->
<script>
    $(function() {
        // custom rules
        jQuery.validator.addMethod("letter", function(value, element) {
            return this.optional(element) || /^[A-Za-z.',-\s]+$/.test(value);
        }, "Inputan harus berupa huruf!");

        jQuery.validator.addMethod("alphanum", function(value, element) {
            return this.optional(element) || /^[a-z][a-z0-9\._]*$/.test(value);
        }, "Inputan harus berupa dan diawali huruf kecil, angka, underscore (_), atau titik (.) ");
        /*  ^ beginning of line
            [a-z] character class for lower values, to match the first letter
            [-a-z0-9\._] character class for the rest of the required value
            * zero or more for the last class
            $ end of String 
            https://stackoverflow.com/questions/1744377/regex-for-a-z-0-9-and*/

        // custom method for file extension validation
        $.validator.addMethod("fileExtension", function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, $.validator.format("File harus memiliki ekstensi {0}"));

        // custom method for file size validation
        $.validator.addMethod("fileSize", function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1024 * 1024); // param is in MB
        }, $.validator.format("File tidak boleh lebih dari {0} MB"));

        // variable untuk rule yg sama
        var req = "Data harus diisi!"
        var chose = "Data harus dipilih!"
        var num = "Data harus berupa angka!"
        var element = {
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        };

        // VALIDASI UNTUK DATA PENGGUNA
        $('.validation_pengguna').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    username: {
                        required: true,
                        alphanum: true,
                        minlength: 3,
                        remote: {
                            url: "<?= site_url('/pengguna/checkUsername') ?>", // Ganti base_url() dengan site_url() karena kita membutuhkan URL lengkap.
                            type: "post",
                            dataType: "json"
                        }
                    },
                    nama_pengguna: {
                        required: true,
                        letter: true
                    },
                    level: {
                        required: true,
                    },
                    no_telp: {
                        number: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    passconf: {
                        required: true,
                        equalTo: "#password"
                    },
                    profile_image: {
                        fileExtension: "png,jpg,jpeg",
                        fileSize: 2 // in MB
                    }
                },
                messages: {
                    username: {
                        required: req,
                        minlength: "username minimal memiliki 3 karakter",
                        remote: "Username sudah digunakan, gunakan username lainnya"
                    },
                    nama_pengguna: {
                        required: req,
                    },
                    level: {
                        required: chose,
                    },
                    no_telp: {
                        number: "No telepon harus berupa angka",
                    },
                    password: {
                        required: req,
                        minlength: "Password minimal 5 karakter"
                    },
                    passconf: {
                        required: req,
                        equalTo: "Password tidak cocok"
                    }
                },
                ...element
            })
        });

        // VALIDASI UNTUK Pengajuan Inventaris
        $('.validation_pengajuan_inventaris').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    no_pengajuan: {
                        required: true,
                    },
                    tanggal: {
                        required: true,
                    },
                    nik: {
                        required: true,
                    },
                    urgensi: {
                        required: true,
                    },
                    latar_belakang: {
                        required: true,
                    },
                    nama_barang: {
                        required: true,
                    },
                    spesifikasi: {
                        required: true,
                    },
                    jumlah: {
                        required: true,
                    },
                    harga: {
                        required: true,
                    },
                    keterangan: {
                        required: true,
                    },
                    nik_pj: {
                        required: true,
                    },

                },
                messages: {
                    no_pengajuan: {
                        required: req,
                    },
                    tanggal: {
                        required: req,
                    },
                    nik: {
                        required: chose,
                    },
                    urgensi: {
                        required: chose,
                    },
                    latar_belakang: {
                        required: req,
                    },
                    nama_barang: {
                        required: req,
                    },
                    spesifikasi: {
                        required: req,
                    },
                    jumlah: {
                        required: req,
                    },
                    harga: {
                        required: req,
                    },
                    keterangan: {
                        required: req,
                    },
                    nik_pj: {
                        required: chose,
                    },
                },
                ...element
            })
        });

        // VALIDASI UNTUK Print Inventaris
        $('.validation_print_inventaris').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    tanggal_awal: {
                        required: true,
                    },
                    tanggal_akhir: {
                        required: true,
                    },
                },
                messages: {
                    tanggal_awal: {
                        required: req,
                    },
                    tanggal_akhir: {
                        required: req,
                    },
                },
                ...element
            })
        });
    });
</script>

<!-- SCRIPT SELECT2 -->
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk Modal Tambah Desa
        $('.select2-pegawai').select2({
            dropdownParent: $('#add_pengajuan_inventaris')
        });
    });
    $(document).ready(function() {
        // Inisialisasi Select2 untuk Modal Tambah Desa
        $('.select2-pegawai2').select2({
            dropdownParent: $('#print_pengajuan_inventaris')
        });
    });
    $(document).ready(function() {
        // Inisialisasi Select2 untuk Modal Tambah Desa
        $('.select2-barang').select2({
            dropdownParent: $('#add_pembelian_inventaris')
        });
    });

    function resetForm(formClass) {
        $('.' + formClass)[0].reset();
        $('.select2').val(null).trigger('change');
    }
</script>

<!-- SCRIPT UNTUK MENGHITUNG JUMLAH DATA YANG DICENTANG DALAM TAMBAH DATASET -->
<script>
    // Menangkap elemen checkbox dan teks jumlah data yang dicentang
    const checkboxes = document.querySelectorAll('.form-check-input');
    const checkedCountText = document.getElementById('checkedCount');
    const layakCountText = document.getElementById('layakCount');
    const tidakLayakCountText = document.getElementById('tidakLayakCount');

    // Fungsi untuk menghitung jumlah checkbox yang dicentang
    function countChecked() {
        let totalChecked = 0;
        let layakChecked = 0;
        let tidakLayakChecked = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                totalChecked++;
                // Mendapatkan label dari baris yang sama dengan checkbox
                const label = checkbox.closest('tr').querySelector('.badge').textContent;
                if (label === 'Layak') {
                    layakChecked++;
                } else if (label === 'Tidak Layak') {
                    tidakLayakChecked++;
                }
            }
        });

        // Memperbarui teks jumlah data yang dicentang
        checkedCountText.textContent = totalChecked;
        layakCountText.textContent = layakChecked;
        tidakLayakCountText.textContent = tidakLayakChecked;
    }

    // Menambahkan event listener pada setiap checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', countChecked);
    });
</script>

<script>
    function fetchBarangDetails(kode_barang, rowIndex) {
        if (kode_barang) {
            $.ajax({
                url: '/pembelian_inventaris/pilih_barang',
                type: 'GET',
                data: {
                    kode_barang: kode_barang
                },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        // Update fields with ID including rowIndex
                        $(`#kode_barang_${rowIndex}`).val(data.kode_barang);
                        $(`#nama_produsen_${rowIndex}`).val(data.nama_produsen);
                        $(`#nama_merk_${rowIndex}`).val(data.nama_merk);
                        $(`#nama_jenis_${rowIndex}`).val(data.nama_jenis);
                    } else {
                        // Clear fields if no data found
                        $(`#kode_barang_${rowIndex}`).val('');
                        $(`#nama_produsen_${rowIndex}`).val('');
                        $(`#nama_merk_${rowIndex}`).val('');
                        $(`#nama_jenis_${rowIndex}`).val('');
                    }
                }
            });
        }
    }
</script>

<script>
    function hitungTotal(rowIndex) {
        var hargaBeli = parseFloat(document.getElementById("harga_beli_" + rowIndex).value) || 0;
        var diskon = parseFloat(document.getElementById("diskon_" + rowIndex).value) || 0;
        var jumlah = parseFloat(document.getElementById("jumlah_" + rowIndex).value) || 0;

        // Hitung total sebelum diskon
        var totalSebelumDiskon = hargaBeli * jumlah;

        // Hitung total setelah diskon
        var total = totalSebelumDiskon - (totalSebelumDiskon * (diskon / 100));

        // Masukkan hasil perhitungan ke input total
        document.getElementById('total_' + rowIndex).value = "Rp " + total.toFixed(2); // Tampilkan hasil di input total
    }

    function validateHarga(rowIndex) {
        var hargaInput = document.getElementById("harga_beli_" + rowIndex);
        var harga = parseFloat(hargaInput.value);

        if (harga < 0) {
            hargaInput.value = 0;
        }

        hitungTotal(rowIndex); // Update total setelah validasi
    }

    function validateDiskon(rowIndex) {
        var diskonInput = document.getElementById("diskon_" + rowIndex);
        var diskon = parseFloat(diskonInput.value);

        if (diskon > 100) {
            diskonInput.value = 100;
        } else if (diskon < 0) {
            diskonInput.value = 0;
        }

        hitungTotal(rowIndex); // Update total setelah validasi
    }

    function validateJumlah(rowIndex) {
        var jumlahInput = document.getElementById("jumlah_" + rowIndex);
        var jumlah = parseFloat(jumlahInput.value);

        if (jumlah < 0) {
            jumlahInput.value = 0;
        }

        hitungTotal(rowIndex); // Update total setelah validasi
    }

    // Pasang event listener untuk input harga beli, diskon, dan jumlah untuk setiap baris
    function setupEventListeners(rowIndex) {
        document.getElementById("harga_beli_" + rowIndex).addEventListener("input", function() {
            validateHarga(rowIndex);
        });
        document.getElementById("diskon_" + rowIndex).addEventListener("input", function() {
            validateDiskon(rowIndex);
        });
        document.getElementById("jumlah_" + rowIndex).addEventListener("input", function() {
            validateJumlah(rowIndex);
        });
    }
</script>

<script>
    let rowIndex = 0;

    // Fungsi untuk menambah baris
    function addRow() {
        rowIndex++;
        const tableBody = document.getElementById('table-body');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td><input type="text" id="kode_barang_${rowIndex}" name="kode_barang" class="form-control" readonly></td>
        <td><select class="form-select select2-barang" name="kode_barang" style="width: 100%" onchange="fetchBarangDetails(this.value, ${rowIndex})">
            <option value="">- Pilih Nama -</option>
            <?php foreach ($brgc as $dt_inventarisbarang) : ?>
                <option value="<?= $dt_inventarisbarang['kode_barang'] ?>"><?= $dt_inventarisbarang['nama_barang'] ?></option>
            <?php endforeach ?>
        </select></td>
        <td><input type="text" id="nama_produsen_${rowIndex}" name="nama_produsen" class="form-control" readonly></td>
        <td><input type="text" id="nama_merk_${rowIndex}" name="nama_merk" class="form-control" readonly></td>
        <td><input type="text" id="nama_jenis_${rowIndex}" name="nama_jenis" class="form-control" readonly></td>
        <td><input type="number" id="jumlah_${rowIndex}" name="jumlah" class="form-control" placeholder="Jumlah" min="0" step="1" required></td>
        <td><input type="number" id="harga_beli_${rowIndex}" name="harga_beli" class="form-control" placeholder="Masukkan harga beli" min="0" step="0.01" required></td>
        <td><input type="number" id="diskon_${rowIndex}" name="diskon" class="form-control" placeholder="Diskon (%)" min="0" max="100" step="0.01" required></td>
        <td><input type="text" id="total_${rowIndex}" class="form-control" readonly value="Rp0.00"></td>
        <td><button type="button" class="btn btn-danger  btn-icon" onclick="removeRow(this)">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 7l16 0" />
            <path d="M10 11l0 6" />
            <path d="M14 11l0 6" />
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
        </svg></button></td>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setupEventListeners(0); // Pasang listener untuk baris pertama
    });
</script>