<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <?= $pageTitle ?? '' ?>
        <?php if (isset($pageSubTitle)) { ?>
            <small class="font-weight-light ml-1 text-md"><?= $pageSubTitle ?></small>
        <?php } ?>
    </h1>
    <?php if (current_url() != '/' && current_url() != site_url()) : ?>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right text-sm">
                <?php $path = explode('/', uri_string()) ?>
                <?php if (count($path) > 0) { ?>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>">
                            Dashboard
                        </a>
                    </li>
                    <?php $accuPath=''; for ($i = 0; $i < count($path); $i++) { ?>
                        <?php if ($i == count($path) - 1) { ?>
                            <li class="breadcrumb-item active"><?= str_replace('-',' ',ucfirst($path[$i])) ?></li>
                        <?php } else { ?>
                            <?php $accuPath .= $path[$i].'/'.($path[$i]=='edit' ? $path[$i+1] : ''); ?>
                            <li class="breadcrumb-item"><a href="<?=  base_url($i > 0 ? $accuPath : $path[$i]) ?>"><?= str_replace('-',' ',ucfirst($path[$i])) ?></a></li>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?= base_url(uri_string()) ?>"><?= str_replace('-',' ',ucfirst(uri_string())) ?></a></li>
                <?php } ?>
            </ol>
        </div>
    <?php endif; ?>
</div>