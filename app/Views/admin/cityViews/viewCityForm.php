<?= $this->include("Themes/_commonPartialsBs/select2bs5") ?>
<?= $this->include("Themes/_commonPartialsBs/sweetalert") ?>
<?= $this->extend("Themes/" . config("Basics")->theme["name"] . "/AdminLayout/defaultLayout") ?>
<?= $this->section("content") ?>
<div class="row">
    <div class="col-12">
		<div class="card card-info">
			<div class="card-header">
        		<h3 class="card-title"><?= $boxTitle ?? $pageTitle ?></h3>
			</div><!--//.card-header -->
			<?= form_open($formAction, ["id" => "cityForm"]) ?>
			<div class="card-body">
				<?= view("Themes/_commonPartialsBs/_alertBoxes") ?>
				<?= !empty($validation->getErrors()) ? $validation->listErrors("bootstrap_style") : "" ?>
				<?= view("admin/cityViews/_cityFormItems") ?>
			</div><!-- /.card-body -->
			<div class="card-footer">
				<?= anchor(route_to("cityList"), lang("Basic.global.Cancel"), ["class" => "btn btn-secondary float-start"]) ?>
				<?= form_submit("save", lang("Basic.global.Save"), ["class" => "btn btn-primary float-end"]) ?>
			</div><!-- /.card-footer -->
			<?= form_close() ?>
    </div><!-- //.card -->
    </div><!--//.col -->
</div><!--//.row -->
<?= $this->endSection() ?>


<?= $this->section("additionalInlineJs") ?>


    $('#countryCode').select2({
        theme: 'bootstrap-5',
        allowClear: false,
        ajax: {
            url: '<?= route_to("menuItemsOfCountries") ?>',
            type: 'post',
            dataType: 'json',

            data: function (params) {
                return {
                    id: 'iso_code',
                    text: 'country_name',
                    searchTerm: params.term,
                    <?= csrf_token() ?? "token" ?> : <?= csrf_token() ?>v
                };
            },
            delay: 60,
            processResults: function (response) {

                yeniden(response.<?= csrf_token() ?>);

                return {
                    results: response.menu
                };
            },

            cache: true
        }
    });


<?= $this->endSection() ?>
