<div class="content-header pt-2 pb-1">
    <div class="container-fluid">
        <div class="row mb-2 align-items-end">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <?= $pageTitle ?? '' ?>
                    <?php if (isset($pageSubTitle)) { ?>
                        <small class="font-weight-light ml-1 text-md"><?= $pageSubTitle ?></small>
                    <?php } ?>
                </h1>
            </div>
            <?php if (current_url() != '/') { ?>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-sm">
                    <?php $path = explode('/', uri_string()) ?>
                    <?php if (count($path) > 1) { ?>
                        <li class="breadcrumb-item">
                            <a href="<?= route_to('#') ?>">
                                Dashboard
                            </a>
                        </li>
                        <?php for ($i = 0; $i < count($path); $i++) { ?>
                            <?php if ($i == count($path) - 1) { ?>
                                <li class="breadcrumb-item active"><?= ucfirst($path[$i]) ?></li>
                            <?php } else { ?>
                                <li class="breadcrumb-item"><a href="<?= base_url($path[$i]) ?>"><?= ucfirst($path[$i]) ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <li class="breadcrumb-item"><a href="<?= base_url(uri_string()) ?>"><?= ucfirst(uri_string()) ?></a></li>
                    <?php } ?>
                </ol>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
