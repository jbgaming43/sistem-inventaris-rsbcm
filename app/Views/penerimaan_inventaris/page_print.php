<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Pembelian - Print</title>
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
            justify-content: flex-end;
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
            <h1>PENERIMAAN INVENTARIS</h1>
        </div>

        <hr>
        <?php foreach ($penerimaan_inv_con as $dt_penerimaan_inv) : ?>
            <table class="details">
                <tr>
                    <td>No. Faktur</td>
                    <td>:</td>
                    <td><?= $dt_penerimaan_inv['no_faktur'] ?></td>
                </tr>
                <tr>
                    <td>No. Order</td>
                    <td>:</td>
                    <td><?= $dt_penerimaan_inv['no_order'] ?></td>
                </tr>
                <tr>
                    <td>Tgl. Datang</td>
                    <td>:</td>
                    <td><?= date('d-M-Y', strtotime($dt_penerimaan_inv['tgl_pesan'])) ?></td>
                </tr>
                <tr>
                    <td>Tgl. Beli</td>
                    <td>:</td>
                    <td><?= date('d-M-Y', strtotime($dt_penerimaan_inv['tgl_faktur'])) ?></td>
                </tr>
                <tr>
                    <td>Jatuh Tempo</td>
                    <td>:</td>
                    <td><?= date('d-M-Y', strtotime($dt_penerimaan_inv['tgl_tempo'])) ?></td>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>:</td>
                    <td><?= $dt_penerimaan_inv['nama_suplier'] ?></td>
                </tr>
                <tr>
                    <td>Petugas</td>
                    <td>:</td>
                    <td><?= $dt_penerimaan_inv['nama'] ?></td>
                </tr>
            </table>
        <?php endforeach ?>

        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Jenis</th>
                    <th>Harga Beli</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($penerimaan_inv_det_con)) : ?>
                    <?php foreach ($penerimaan_inv_det_con as $index => $dt_penerimaan_inv_det) : ?>
                        <tr style=" white-space: nowrap;">
                            <td><?= $index + 1 ?></td>
                            <td><?= $dt_penerimaan_inv_det['kode_barang'] ?></td>
                            <td><?= $dt_penerimaan_inv_det['nama_barang'] ?></td>
                            <td><?= $dt_penerimaan_inv_det['nama_merk'] ?></td>
                            <td><?= $dt_penerimaan_inv_det['nama_jenis'] ?></td>
                            <td>Rp <?= number_format($dt_penerimaan_inv_det['harga'], 0, ',', '.'); ?></td>
                            <td><?= $dt_penerimaan_inv_det['jumlah'] ?></td>
                            <td>Rp <?= number_format($dt_penerimaan_inv_det['total'], 0, ',', '.'); ?></td>
                        </tr>

                        <!-- menghitung sum jumlah -->
                        <?php $total_jumlah = 0;
                        $total_jumlah += $dt_penerimaan_inv_det['jumlah'] ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($penerimaan_inv_con as $dt_penerimaan_inv) : ?>
                    <?php if ($dt_penerimaan_inv['total1']) : ?>
                        <tr>
                            <td colspan="6"></td>
                            <td><?= $total_jumlah; ?></td>
                            <td>Rp <?= number_format($dt_penerimaan_inv['total1'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="signatures">

            <div>
                <p>Penerima</p>
                <br><br><br>
                <p>__________________</p>
            </div>
        </div>
    </div>
</body>

</html>