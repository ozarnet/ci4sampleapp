<?php
    //  Open-Source License Information:
    /*
        The MIT License (MIT)

        Copyright (c) 2020 Gökhan Ozar (https://gokhan.ozar.net/)
        Copyright (c) 2014-2019 British Columbia Institute of Technology (https://www.bcit.ca)
        Copyright (c) 2019-2020 CodeIgniter Foundation (https://www.codeigniter.com)
        Copyright (c) 2014-2020 ColorlibHQ (https://adminlte.io)
        Copyright (c) 2019-2020 Agung Sugiarto  for portions of this code (https://agungsugiarto.github.io)


        Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
        to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
        and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

        The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
        INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 
        IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

    */
?>
<!DOCTYPE html>
<html lang="<?= config('App')->defaultLocale ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php if ( ENVIRONMENT=='production') : ?>
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <?php endif; ?>
    <title><?= isset($pageTitle) ? $pageTitle . ' | ': '' ?><?= config('Basics')->appName ?></title>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.12.0/css/all.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.7.2/dist/sweetalert2.min.css">

    <!-- Render additional css -->
    <?= $this->renderSection('css') ?>
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.0.4/dist/css/adminlte.min.css">

</head>

<body class="layout-fixed layout-navbar-fixed sidebar-mini <?= config('Basics')->theme['footer']['fixed'] ? 'layout-footer-fixed' : '' ?> <?= config('Basics')->theme['body-sm'] ? 'text-sm' : '' ?>">
<div class="wrapper">

    <!-- Navbar -->
    <?= $this->include('Themes/AdminLTE3/AdminLayout/_defaultHeaderNav') ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?= $this->include('Themes/AdminLTE3/AdminLayout/_leftSidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?= $this->include('Themes/AdminLTE3/AdminLayout/_contentHeader') ?>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <!-- <div class="p-3">
          <h5>Title</h5>
          <p>Sidebar content</p>
        </div> -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>&copy; <?= date('Y') ?> <a href="<?= config('Basics')->theme['footer']['orglink'] ?>">
        <?= config('Basics')->theme['footer']['organization']?></a>.</strong> All rights reserved.
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            <?= config('Basics')->appName ?>  created with 
            <a href="https://www.ozar.net/products/codeigniterwizard/"><strong>CodeIgniter Wizard</strong> Mac App</a>
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<?= $this->renderSection('footerAdditions') ?>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.0.4/dist/js/adminlte.min.js"></script>
<!-- Preload Script -->
<script>
    $('.sidebar-toggle').on('click',function(event){event.preventDefault();if(Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))){sessionStorage.setItem('sidebar-toggle-collapsed','')}else{sessionStorage.setItem('sidebar-toggle-collapsed','1')}});(function(){if(Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))){var body=document.getElementsByTagName('body')[0];body.className=body.className+' sidebar-collapse'}})()
</script>

<script>
    $.ajaxSetup({headers:{'<?= config('App')->CSRFHeaderName ?>':$('meta[name="<?= config('App')->CSRFTokenName ?>"]').attr('content')}})
</script>

<!-- Render section boilerplate js -->
<?= $this->renderSection('js') ?>
<!-- Sweeat alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.7.2/dist/sweetalert2.all.min.js"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    <?php if (session('sweet-success')) { ?>
    Toast.fire({
        icon: 'success',
        title: '<?= session('sweet-success.') ?>'
    });
    <?php } ?>
    <?php if (session('sweet-warning')) { ?>
    Toast.fire({
        icon: 'warning',
        title: '<?= session('sweet-warning.') ?>'
    });
    <?php } ?>
    <?php if (session('sweet-error')) { ?>
    Toast.fire({
        icon: 'error',
        title: '<?= session('sweet-error.') ?>'
    });
    <?php } ?>
</script>

<?php // echo $this->include('codeIgniter4DebugFooter'); ?>


</body>

</html>