<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran Non Medis - Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 297mm;
            /* A4 height */
        }

        .container {
            width: 210mm;
            /* A4 width */
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
            flex: 1;
            /* Allow the container to grow and fill the space */
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details td {
            padding: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
        }

        .signatures {
            position: absolute;
            bottom: 0mm;
            /* Distance from the bottom of the page */
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 20mm;
            /* Extra margin to ensure it's pushed to the bottom */
        }

        .signatures div {
            text-align: center;
            width: 24%;
        }

        @media print {
            @page {
                size: A4;
                /* Set page size to A4 */
                margin: 20mm;
                /* Set margins */
            }

            body {
                width: 210mm;
                /* Set width to A4 size */
                margin: 0;
            }

            .container {
                width: auto;
                /* Adjust container width for print */
                position: relative;
                /* Ensure container's position is relative */
            }
        }
    </style>
</head>

<body onload="window.print();">
    <div class="container">
        <div class="header">
            <img src="<?= base_url('../assets/img/icon/rsbcm_logo.png'); ?>" alt="RS BORNEO CITRA MEDIKA" style="height: 60px;">
            <h1>PENGELUARAN NON MEDIS</h1>
        </div>

        <hr>
        <?php foreach ($pengeluaran_nonmedis_con as $dt_pengeluaran_nonmedis) : ?>
            <table class="details">
                <tr>
                    <!-- untuk yang kiri -->
                    <td>No. Faktur</td>
                    <td>:</td>
                    <td><?= $dt_pengeluaran_nonmedis['no_keluar'] ?></td>
                    <!-- untuk yang kanan -->
                    <td style="padding-left: 5cm;">Tanggal</td>
                    <td>:</td>
                    <td><?= date('d-M-Y', strtotime($dt_pengeluaran_nonmedis['tanggal'])) ?></td>
                </tr>
                <tr>
                    <!-- untuk yang kiri -->
                    <td>Diajukan oleh</td>
                    <td>:</td>
                    <td><?= $dt_pengeluaran_nonmedis['nama'] ?></td>
                    <!-- untuk yang kanan -->
                    <td style="padding-left: 5cm;">Keterangan</td>
                    <td>:</td>
                    <td><?= $dt_pengeluaran_nonmedis['keterangan'] ?></td>
                </tr>
            </table>
        <?php endforeach ?>

        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pengeluaran_nonmedis_det_con)) : ?>
                    <?php $total_jumlah = 0; ?>
                    <?php $total_total = 0; ?>
                    <?php foreach ($pengeluaran_nonmedis_det_con as $index => $dt_pengeluaran_nonmedis_det) : ?>
                        <tr style=" white-space: nowrap;">
                            <td><?= $index + 1 ?></td>
                            <td><?= $dt_pengeluaran_nonmedis_det['kode_brng'] ?></td>
                            <td><?= $dt_pengeluaran_nonmedis_det['nama_brng'] ?></td>
                            <td><?= $dt_pengeluaran_nonmedis_det['kode_sat'] ?></td>
                            <td><?= $dt_pengeluaran_nonmedis_det['jenis'] ?></td>
                            <td>Rp <?= number_format($dt_pengeluaran_nonmedis_det['harga'], 0, ',', '.'); ?></td>
                            <td><?= $dt_pengeluaran_nonmedis_det['jumlah'] ?></td>
                            <td>Rp <?= number_format($dt_pengeluaran_nonmedis_det['total'], 0, ',', '.'); ?></td>
                        </tr>

                        <!-- menghitung sum jumlah -->
                        <?php
                        $total_jumlah += $dt_pengeluaran_nonmedis_det['jumlah'];
                        $total_total += $dt_pengeluaran_nonmedis_det['total']; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
                <?php if ($total_jumlah) : ?>
                    <tr>
                        <td colspan="6"></td>
                        <td><?= $total_jumlah; ?></td>
                        <td>Rp <?= number_format($total_total, 0, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

        <div class="signatures">

            <div>
                <p>Pengirim</p>
                <br><br><br>
                <p>__________________</p>
            </div>
            <div>
                <p>Penerima</p>
                <br><br><br>
                <p>__________________</p>
            </div>
        </div>
    </div>
</body>

</html>