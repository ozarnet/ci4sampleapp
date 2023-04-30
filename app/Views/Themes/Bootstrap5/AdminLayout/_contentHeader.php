<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <?= $pageTitle ?? '' ?>
        <?php if (isset($pageSubTitle)) { ?>
            <small class="font-weight-light d-none d-xl-block"><?= $pageSubTitle ?></small>
        <?php } ?>
    </h1>
    <?php if (!isset($currentLocale) && current_url() != '/' && current_url() != site_url()) : ?>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end text-sm">
                <?php $path = explode('/', uri_string()); ?>
                <?php if (count($path) > 0) { ?>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>">
                            <?=lang('Basic.global.Dashboard')?>
                        </a>
                    </li>
                    <?php $accuPath=''; for ($i = 0; $i < count($path); $i++) { ?>
                        <?php if ($i == count($path) - 1) { ?>
                            <li class="breadcrumb-item active"><?= mb_convert_case(lang('Basic.global.'. $path[$i]), MB_CASE_TITLE, "UTF-8") ?></li>
                        <?php } else { ?>
                            <?php $accuPath .= $path[$i].'/'.($path[$i]=='edit' ? $path[$i+1] : ''); ?>
                            <?php $segment = mb_convert_case(lang('Basic.global.'. $path[$i]), MB_CASE_TITLE, "UTF-8"); ?>
                            <li class="breadcrumb-item"><a href="<?= base_url($i > 0 ? $accuPath : $path[$i]) ?>"><?= is_numeric($path[$i]) || strpos($segment, 'Basic.global') !== false ? $path[$i] : $segment ?></a></li>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?= base_url(uri_string()) ?>"><?= str_replace('-',' ', ucfirst(uri_string())) ?></a></li>
                <?php } ?>
            </ol>
        </div>
    <?php endif; ?>
</div>