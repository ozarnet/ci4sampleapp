<!-- Navbar -->
<!--<nav class="main-header navbar navbar-expand navbar-white navbar-light">-->
<nav class="main-header navbar navbar-expand navbar-<?= config('Basics')->theme['navbar']['bg'] ?> navbar-<?= config('Basics')->theme['navbar']['type'] ?> <?= config('Basics')->theme['navbar']['type'] ? '' : 'border-bottom-0' ?>">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= route_to('/') ?>" class="nav-link">Dashboard Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://www.ozar.net/products/codeigniterwizard/?ref=gh" class="nav-link">CodeIgniter Wizard </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://www.ozar.net/products/codeigniterwizard/sample/?ref=gh" class="nav-link">About This App</a>
        </li>
    </ul>

    <!-- Right navbar links can be defined here -->

</nav>
<!-- /.navbar -->