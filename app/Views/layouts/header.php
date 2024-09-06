<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Inventari Barang RSBCM</title>

    <link rel="icon" type="image/png" href="<?= base_url(); ?>/assets/img/icon/rsbcm_logo.png" />

    <!-- CSS files -->
    <link href="<?= base_url('assets/dist/css/tabler.min.css?1684106062') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/css/tabler-flags.min.css?1684106062') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/css/tabler-payments.min.css?1684106062') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/css/tabler-vendors.min.css?1684106062') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/css/demo.min.css?1684106062') ?>" rel="stylesheet" />

    <!-- CSS Libraries -->
    <!-- CSS Datatables -->
    <link href="<?= base_url('assets/dist/libs/datatables/datatables.min.css') ?>" rel="stylesheet" />
    <!-- CSS Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/libs/select2/css/select2.min.css') ?>" rel="stylesheet">

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        /* Menghilangkan spinner di Chrome, Safari, Edge, Opera */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Menghilangkan spinner di Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <script src="<?= base_url('assets/dist/js/demo-theme.min.js?1684106062') ?>"></script>