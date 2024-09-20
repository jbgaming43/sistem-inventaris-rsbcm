<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Kode QR - <?= $no_faktur; ?></title>
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

        .grid-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            /* Add gap between items */
        }

        .grid-item {
            text-align: center;
        }

        .grid-item img {
            width: 4cm;
            /* Adjust the size of QR code image */
            height: auto;
        }

        .grid-item .label {
            display: inline-block;
            width: 4cm;
            /* Set the same width as the QR Code */
            text-align: center;
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
        <table>
            <?php if (!empty($qrImages)) : ?>
                <div class="grid-container">
                    <?php foreach ($barang_qrImage as $item) : ?>
                        <div class="grid-item">
                            <div class="label"><?= $item['barang']['no_inventaris']; ?></div>
                            <br>
                            <img src="<?= base_url('../uploads/' . basename($item['qrImage'])); ?>" alt="QR Code <?= $item['barang']['no_inventaris']; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>Tidak ada QR Code yang dihasilkan.</p>
            <?php endif; ?>
        </table>
    </div>
</body>

</html>
