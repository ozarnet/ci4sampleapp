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
			<?= form_open($formAction, ["id" => "countryForm"]) ?>
			<div class="card-body">
				<?= view("Themes/_commonPartialsBs/_alertBoxes") ?>
				<?= !empty($validation->getErrors()) ? $validation->listErrors("bootstrap_style") : "" ?>
				<?= view("admin/countryViews/_countryFormItems") ?>
			</div><!-- /.card-body -->
			<div class="card-footer">
				<?= anchor(route_to("countryList"), lang("Basic.global.Cancel"), ["class" => "btn btn-secondary float-start"]) ?>
				<?= form_submit("save", lang("Basic.global.Save"), ["class" => "btn btn-primary float-end"]) ?>
			</div><!-- /.card-footer -->
			<?= form_close() ?>
    </div><!-- //.card -->
    </div><!--//.col -->
</div><!--//.row -->
<?= $this->endSection() ?>
