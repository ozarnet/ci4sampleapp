<div id="sidebar" class="d-none d-sm-none d-md-block d-flex flex-column flex-shrink-0 px-3 py-2 bg-<?= config('Basics')->theme['sidebar']['type'] ?? 'dark' ?> ">
    <a href="<?= base_url() ?>" class="navbar-brand d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <img class="me-1" src="<?= base_url() ?>/assets/logo.svg" alt="logo" width="40" height="32">
        <span class="fs-4"><?= config('Basics')->appName ?></span>
    </a>
    <hr class="mt-1">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url($currentLocale ?? '') ?>" class="nav-link<?=current_url() == base_url() || current_url() == base_url($currentLocale ?? '') || $currentModule == 'Dashboard' ? ' active': ''?>" aria-current="page">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#speedometer2"/>
                </svg>
                <?=lang('Basic.global.Dashboard')?>
            </a>
        </li>
        <?= view('_partials/_leftSidebarContent'); ?>
    </ul>
</div><!--//# sidebar -->