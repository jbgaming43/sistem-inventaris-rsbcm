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
            min-height: 297mm; /* A4 height */
        }
        .container {
            width: 210mm; /* A4 width */
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
            flex: 1; /* Allow the container to grow and fill the space */
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
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 10px;
            text-align: center;
        }
        .signatures {
            position: absolute;
            bottom: 0mm; /* Distance from the bottom of the page */
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 20mm; /* Extra margin to ensure it's pushed to the bottom */
        }
        .signatures div {
            text-align: center;
            width: 24%;
        }

        @media print {
            @page {
                size: A4; /* Set page size to A4 */
                margin: 20mm; /* Set margins */
            }
            body {
                width: 210mm; /* Set width to A4 size */
                margin: 0;
            }
            .container {
                width: auto; /* Adjust container width for print */
                position: relative; /* Ensure container's position is relative */
            }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="container">
        <div class="header">
            <img src="<?= base_url('../assets/img/icon/rsbcm_logo.png'); ?>" alt="RS BORNEO CITRA MEDIKA" style="height: 60px;">
            <h1>PERMINTAAN PEMBELIAN</h1>
        </div>

        <hr>
        
        <table class="details">
            <tr>
                <td>Tgl. Permintaan:</td>
                <td><?= date('d-M-Y', strtotime($tanggal_awal)) ?></td>
            </tr>
            <tr>
                <td>Tgl. Kebutuhan:</td>
                <td><?= date('d-M-Y', strtotime($tanggal_awal)) ?></td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Pengajuan</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Oleh</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $item['no_pengajuan'] ?></td>
                            <td><?= $item['tanggal'] ?></td>
                            <td><?= $item['nama_barang'] ?></td>
                            <td><?= $item['nama'] ?></td>
                            <td><?= $item['jumlah'] ?></td>
                            <td><?= $item['keterangan'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="signatures">
            <div>
                <p>Diminta</p>
                <br><br><br>
                <p>__________________</p>
            </div>
            <div>
                <p>Diajukan</p>
                <br><br><br>
                <p>__________________</p>
            </div>
            <div>
                <p>Diketahui</p>
                <br><br><br>
                <p>__________________</p>
            </div>
            <div>
                <p>Disetujui</p>
                <br><br><br>
                <p>__________________</p>
            </div>
        </div>
    </div>
</body>
</html>
