<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?= $title ?> | Grosir Pak Enjang</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
    <link href="/assets/template/admin/plugins/material/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="/assets/template/admin/plugins/simplebar/simplebar.css" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="/assets/template/admin/plugins/nprogress/nprogress.css" rel="stylesheet" />

    <link href="/assets/template/admin/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" />

    <link href="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />

    <link href="/assets/template/admin/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.35/sweetalert2.min.css" rel="stylesheet" />
    <link href="/assets/template/admin/plugins/toaster/toastr.min.css" rel="stylesheet" />
    <link href="/assets/template/admin/plugins/select2/css/select2.min.css" rel="stylesheet" />

    <!-- MONO CSS -->
    <link id="main-css-href" rel="stylesheet" href="/assets/template/admin/css/style.css" />

    <!-- FAVICON -->
    <link href="/assets/template/admin/images/favicon.png" rel="shortcut icon" />

    <script src="/assets/template/admin/plugins/nprogress/nprogress.js"></script>

    <style>
        toastr {
            z-index: 7000;
        }
    </style>
</head>


<body class="navbar-fixed sidebar-fixed" id="body">

    <?= view('admin/layouts/navbar') ?>