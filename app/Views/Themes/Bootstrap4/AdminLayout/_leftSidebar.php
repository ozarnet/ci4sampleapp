<nav id="sidebarMenu" class="col-md-3 col-lg-2 col-xl-2 d-md-block bg-<?= config('Basics')->theme['sidebar']['type'] ?? 'light' ?> sidebar collapse mt-3">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="<?= route_to('/') ?>">
                    <i class="nav-icon fas fa-home"></i>
                    Dashboard <span class="sr-only">(current)</span><span class="right badge badge-warning">Updated</span>
                </a>
            </li>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Sections</span>
            </h6>
            <?= view('_partials/_leftSidebarContent'); ?>
        </ul>

       
      
    </div>
</nav>