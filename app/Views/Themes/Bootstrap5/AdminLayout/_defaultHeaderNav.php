<nav class="navbar navbar-expand navbar-<?= config('Basics')->theme['navbar']['type'] ?? 'dark' ?> bg-<?= config('Basics')->theme['navbar']['type'] ?? 'dark' ?> bg-<?= config('Basics')->theme['navbar']['bg'] ?? 'gray' ?> shadow mx-0" aria-label="Top Navigation Bar">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-outline-dark ms-n2 me-4 sidebar-toggle">
            <span class="navbar-toggler-icon"></span>
        </button>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExpanded" aria-controls="navbarExpanded" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarExpanded">
            <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                <li class="nav-item me-3 active">
                    <a class="nav-link active" aria-current="page"  href="<?= base_url($currentLocale ?? '') ?>"><?=lang('Basic.global.Home')?></a>
                </li>
                <li class="nav-item me-3 active">
                    <a class="nav-link" href="https://www.ozar.net/products/codeigniterwizard/sample?r=uap421dmml&layout=1&theme=bs5"><?=lang('Basic.global.About')?></a>
                </li>
            </ul>

            <!-- Right navbar links can be defined here -->
            <ul class="navbar-nav ml-auto">
                <!-- Language Dropdown Menu Placeholder -->
        <?php if (config('Basics')->authImplemented && config('Basics')->theme['sidebar']['user']['visible']) { ?>
            <?php if (logged_in()) { ?>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?=site_url() ?><?= user()->picture ?? 'assets/generic-user-avatar.png' ?>" class="user-image img-circle elevation-2"
                             alt="<?= user()->username ?> picture">
                        <span class="d-none d-md-inline"><?= empty(user()->fullName) ? user()->username : user()->fullName ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-dark">
                        <a href="<?= route_to('user-profile') ?>" class="dropdown-item">
                            <i class="bi bi-person-square"></i> &nbsp;
                            <?= lang('Basic.global.Profile') ?>
                        </a>
                        <a href="<?= route_to('logout') ?>" class="dropdown-item">
                            <i class="bi bi-box-arrow-right"></i> &nbsp;
                            <?= lang('Basic.global.SignOut') ?>
                        </a>
                    </div>
                </li>
            <?php } else { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                        <?= lang('Basic.global.Members') ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-dark dropdown-menu-right">
                        <a href="<?= route_to('login') ?>" class="dropdown-item">
                            <i class="bi bi-box-arrow-in-right"></i> &nbsp;
                            <?= lang('Auth.signIn') ?>
                        </a>
                        <a href="<?= route_to('register') ?>" class="dropdown-item">
                            <i class="bi bi-person-plus-fill"></i> &nbsp;
                            <?= lang('Auth.register') ?>
                        </a>
                    </div>
                </li>
            <?php } ?>
        <?php } ?>
            </ul>

        </div>
    </div>
</nav>