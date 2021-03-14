<nav class="navbar sticky-top navbar-expand navbar-<?= config('Basics')->theme['navbar']['type'] ?? 'dark' ?> bg-<?= config('Basics')->theme['navbar']['type'] ?? 'dark' ?> shadow">
    <a class="navbar-brand  col-md-3 col-lg-2 col-xl-2 px-3" href="<?= base_url() ?>"><?= config('Basics')->appName ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarExpanded"
            aria-controls="navbarExpanded" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarExpanded">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= route_to('/') ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.ozar.net/products/codeigniterwizard/sample/?r=uap411dm&layout=1&theme=bs4">About</a>
            </li>
        </ul>

    </div>
</nav>