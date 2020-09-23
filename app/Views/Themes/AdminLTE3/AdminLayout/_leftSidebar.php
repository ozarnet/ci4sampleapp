<!-- Main Sidebar Container -->
<aside class="main-sidebar <?= config('Basics')->theme['sidebar']['border'] ? 'border-right' : ''?> sidebar-<?= config('Basics')->theme['sidebar']['type'] ?>-<?= config('Basics')->theme['sidebar']['links']['bg'] ?> elevation-<?= config('Basics')->theme['sidebar']['shadow'] ?>">
    <!-- Brand Logo -->
    <a href="<?= route_to('/') ?>" class="brand-link <?= !empty(config('Basics')->theme['sidebar']['brand']['bg']) ? 'bg-'.config('Basics')->theme['sidebar']['brand']['bg'] : '' ?>">
        <img src="<?= base_url(config('Basics')->theme['sidebar']['brand']['logo']['icon']) ?>" class="brand-image img-circle elevation-<?= config('Basics')->theme['sidebar']['brand']['logo']['shadow'] ?>" style="opacity: .8">
        <span class="brand-text"><?= config('Basics')->theme['sidebar']['brand']['logo']['text'] ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <?php if (config('Basics')->authImplemented && config('Basics')->theme['sidebar']['user']['visible'] && logged_in() ) { ?>
            <div class="user-panel py-3 d-flex">
                <div class="image">
                    <img src="https://cdn.jsdelivr.net/npm/admin-lte@3.0.2/dist/img/avatar.png" class="img-circle elevation-<?= config('Basics')->theme['sidebar']['user']['shadow'] ?>"
                         alt="User Image">
                </div>
                <div class="info">
                    <a href="<?= route_to('user-profile') ?>" class="d-block"><?= user()->username ?></a>
                </div>
            </div>
        <?php } ?>
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= route_to('/') ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home Page
                            <span class="right badge badge-warning">Updated</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Sections
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <?= view('_partials/_leftSidebarContent'); ?>
              
                    </ul><!--//.nav nav-treeview -->
                </li><!--//.nav-item has-treeview -->
            </ul><!--//.nav nav-pills nav-sidebar flex-column -->
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>