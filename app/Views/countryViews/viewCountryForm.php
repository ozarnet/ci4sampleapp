<?=$this->include('Themes/_commonPartialsBs4/select2') ?>
<?=$this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?=$this->section('content');  ?>
<div class="row">
    <div class="col-md-12">
		<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><?=$boxTitle ?? $pageTitle ?></h3>
</div><!-- /.card-header -->
			<?=form_open($formAction, ['id'=>'countryForm', 'class'=>'form-horizontal'])  ?>
			<div class="card-body">
				<?=view('Themes/_commonPartials/_alertBoxes') ?>
				<?=!empty($validation->getErrors()) ? $validation->listErrors('bootstrap_style') : '';  ?>
				<?=view('countryViews/_countryFormItems') ?>
			</div><!-- /.card-body -->
			<div class="card-footer">
				<?=anchor(route_to('countries'), 'Cancel', ['class'=>'btn btn-secondary float-left']); ?>
				<input type="submit" class="btn btn-primary float-right" name="save" value=" Save ">
			</div><!-- /.card-footer -->
			<?=form_close() ?>
</div><!-- //.card -->
    </div><!--/.col -->
</div><!-- /.row -->
<?=$this->endSection() ?>