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
        $('.select2-pegawai').select2({
            dropdownParent: $('#add_pengajuan_nonmedis')
        });
    });
    $(document).ready(function() {
        // Inisialisasi Select2 untuk Modal Tambah Desa
        $('.select2-barang1').select2({
            dropdownParent: $('#add_pembelian_inventaris')
        });
    });
    $(document).ready(function() {
        // Inisialisasi Select2 untuk Modal Tambah Desa
        $('.select2-barang').select2({
            dropdownParent: $('#add_penerimaan_inventaris')
        });
    });

    function resetForm(formClass) {
        $('.' + formClass)[0].reset();
        $('.select2').val(null).trigger('change');
    }
</script>

<script>
    function fetchBarangDetails(kode_barang, rowIndex) {
        if (kode_barang) {

            if (isDuplicate(kode_barang)) {
                alert("Kode barang sudah ada di tabel. Silakan pilih barang yang lain.");
                // Reset dropdown jika duplikat ditemukan
                $(`#kode_barang_${rowIndex}`).val('');
                $(`#select_barang_${rowIndex}`).val('').trigger('change');
                $(`#nama_produsen_${rowIndex}`).val('');
                $(`#nama_merk_${rowIndex}`).val('');
                $(`#nama_jenis_${rowIndex}`).val('');
                return;
            }

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
        var potongan = (totalSebelumDiskon * (diskon / 100));
        // Hitung total setelah diskon
        var total = totalSebelumDiskon - potongan;

        // Masukkan hasil perhitungan ke input total
        document.getElementById('total_' + rowIndex).value = "Rp " + total.toFixed(2); // Tampilkan hasil di input total
        document.getElementById('subtotal_' + rowIndex).value = "Rp " + totalSebelumDiskon.toFixed(2); // Tampilkan hasil di input total
        document.getElementById('potongan_' + rowIndex).value = "Rp " + potongan.toFixed(2); // Tampilkan hasil di input total
    }

    function validateHarga(rowIndex) {
        var hargaInput = document.getElementById("harga_beli_" + rowIndex);
        var harga = parseFloat(hargaInput.value);

        if (harga < 0) {
            hargaInput.value = 0;
        }

        hitungTotal(rowIndex); // Update total setelah validasi
    }

    document.getElementById('ppn').addEventListener('input', function() {
        var ppnInput = this;
        if (ppnInput.value < 0) {
            ppnInput.value = 0;
        }
    });

    document.getElementById('meterai').addEventListener('input', function() {
        var meteraiInput = this;
        if (meteraiInput.value < 0) {
            meteraiInput.value = 0;
        }
    });

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

        if (jumlah < 1) {
            jumlahInput.value = 1;
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
    function fetchBarangDetails2(kode_barang, rowIndex) {
        if (kode_barang) {

            if (isDuplicate2(kode_barang)) {
                alert("Kode barang sudah ada di tabel. Silakan pilih barang yang lain.");
                // Reset dropdown jika duplikat ditemukan
                $(`#2kode_barang_${rowIndex}`).val('');
                $(`#2select_barang_${rowIndex}`).val('').trigger('change');
                $(`#2nama_produsen_${rowIndex}`).val('');
                $(`#2nama_merk_${rowIndex}`).val('');
                $(`#2nama_jenis_${rowIndex}`).val('');
                return;
            }

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
                        $(`#2kode_barang_${rowIndex}`).val(data.kode_barang);
                        $(`#2nama_produsen_${rowIndex}`).val(data.nama_produsen);
                        $(`#2nama_merk_${rowIndex}`).val(data.nama_merk);
                        $(`#2nama_jenis_${rowIndex}`).val(data.nama_jenis);
                    } else {
                        // Clear fields if no data found
                        $(`#2kode_barang_${rowIndex}`).val('');
                        $(`#2nama_produsen_${rowIndex}`).val('');
                        $(`#2nama_merk_${rowIndex}`).val('');
                        $(`#2nama_jenis_${rowIndex}`).val('');
                    }
                }
            });
        }
    }
</script>

<script>
    function hitungTotal2(rowIndex) {
        var hargaBeli = parseFloat(document.getElementById("2harga_beli_" + rowIndex).value) || 0;
        var diskon = parseFloat(document.getElementById("2diskon_" + rowIndex).value) || 0;
        var jumlah = parseFloat(document.getElementById("2jumlah_" + rowIndex).value) || 0;

        // Hitung total sebelum diskon
        var totalSebelumDiskon = hargaBeli * jumlah;
        var potongan = (totalSebelumDiskon * (diskon / 100));
        // Hitung total setelah diskon
        var total = totalSebelumDiskon - potongan;

        // Masukkan hasil perhitungan ke input total
        document.getElementById('2total_' + rowIndex).value = "Rp " + total.toFixed(2); // Tampilkan hasil di input total
        document.getElementById('2subtotal_' + rowIndex).value = "Rp " + totalSebelumDiskon.toFixed(2); // Tampilkan hasil di input total
        document.getElementById('2potongan_' + rowIndex).value = "Rp " + potongan.toFixed(2); // Tampilkan hasil di input total
    }

    function validateHarga2(rowIndex) {
        var hargaInput = document.getElementById("2harga_beli_" + rowIndex);
        var harga = parseFloat(hargaInput.value);

        if (harga < 0) {
            hargaInput.value = 0;
        }

        hitungTotal2(rowIndex); // Update total setelah validasi
    }

    document.getElementById('2ppn').addEventListener('input', function() {
        var ppnInput = this;
        if (ppnInput.value < 0) {
            ppnInput.value = 0;
        }
    });

    document.getElementById('2meterai').addEventListener('input', function() {
        var meteraiInput = this;
        if (meteraiInput.value < 0) {
            meteraiInput.value = 0;
        }
    });

    function validateDiskon2(rowIndex) {
        var diskonInput = document.getElementById("2diskon_" + rowIndex);
        var diskon = parseFloat(diskonInput.value);

        if (diskon > 100) {
            diskonInput.value = 100;
        } else if (diskon < 0) {
            diskonInput.value = 0;
        }

        hitungTotal2(rowIndex); // Update total setelah validasi
    }

    function validateJumlah2(rowIndex) {
        var jumlahInput = document.getElementById("2jumlah_" + rowIndex);
        var jumlah = parseFloat(jumlahInput.value);

        if (jumlah < 1) {
            jumlahInput.value = 1;
        }

        hitungTotal2(rowIndex); // Update total setelah validasi
    }

    // Pasang event listener untuk input harga beli, diskon, dan jumlah untuk setiap baris
    function setupEventListeners2(rowIndex) {
        document.getElementById("2harga_beli_" + rowIndex).addEventListener("input", function() {
            validateHarga2(rowIndex);
        });
        document.getElementById("2diskon_" + rowIndex).addEventListener("input", function() {
            validateDiskon2(rowIndex);
        });
        document.getElementById("2jumlah_" + rowIndex).addEventListener("input", function() {
            validateJumlah2(rowIndex);
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setupEventListeners(0); // Pasang listener untuk baris pertama
    });

    document.addEventListener("DOMContentLoaded", function() {
        setupEventListeners2(0); // Pasang listener untuk baris pertama
    });

    function isDuplicate(kode_barang) {
        let isDuplicate = false;

        // Loop through each existing row to check for duplicate kode_barang
        $('input[name="kode_barang[]"]').each(function() {
            if ($(this).val() === kode_barang) {
                isDuplicate = true;
                return false; // Stop the loop if a duplicate is found
            }
        });

        return isDuplicate;
    }

    function isDuplicate2(kode_barang) {
        let isDuplicate = false;

        // Loop through each existing row to check for duplicate kode_barang
        $('input[name="2kode_barang[]"]').each(function() {
            if ($(this).val() === kode_barang) {
                isDuplicate = true;
                return false; // Stop the loop if a duplicate is found
            }
        });

        return isDuplicate;
    }
</script>

<script>
    function fetchFaktur(no_faktur) {
        if (no_faktur) {

            $.ajax({
                url: '/penerimaan_inventaris/pilih_no_faktur',
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
                        $('#kd_rek_aset').val(faktur.kd_rek_aset);
                        $('#ppn').val(faktur.ppn);
                        $('#meterai').val(faktur.meterai);

                        console.log(no_faktur);
                        // Fetch inventory details for the faktur
                        fetch(`/penerimaan_inventaris/detail/${no_faktur}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log(data.detail);
                                    fillInventoryTable(data.detail);
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
                        $('#kd_rek_aset').val('');
                        $('#ppn').val('');
                        $('#meterai').val('');
                    }
                }
            });
        }
    }

    function fillInventoryTable(items) {
        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = ''; // Kosongkan tabel sebelum mengisi ulang

        items.forEach((item, index) => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td><input type="text" id="kode_barang_${index}" name="kode_barang[]" class="form-control" value="${item.kode_barang}" readonly></td>
            <td><input type="text" id="nama_barang_${index}" name="nama_barang[]" class="form-control" value="${item.nama_barang}" readonly></td>
            <td><input type="text" id="nama_produsen_${index}" name="nama_produsen[]" class="form-control" value="${item.nama_produsen}" readonly></td>
            <td><input type="text" id="nama_merk_${index}" name="nama_merk[]" class="form-control" value="${item.nama_merk}" readonly></td>
            <td><input type="text" id="nama_jenis_${index}" name="nama_jenis[]" class="form-control" value="${item.nama_jenis}" readonly></td>
            <td><input type="number" id="jumlah_${index}" name="jumlah[]" class="form-control" value="${item.jumlah}" readonly></td>
            <td><input type="number" id="harga_beli_${index}" name="harga_beli[]" class="form-control" value="${item.harga}" readonly></td>
            <td><input type="number" id="diskon_${index}" name="diskon[]" class="form-control" value="${item.dis}" readonly></td>
            <td><input type="text" id="total_${index}" name="total[]" class="form-control" value="${item.total}" readonly></td>
        `;
            tableBody.appendChild(newRow);
        });
    }
</script>