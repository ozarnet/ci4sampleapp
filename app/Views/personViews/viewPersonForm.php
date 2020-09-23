<?=$this->include('Themes/_commonPartialsBs4/select2') ?>
<?=$this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?=$this->section('content');  ?>
<div class="row">
	<div class="col-md-12">
<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title"><?=$pageTitle ?></h3>
</div><!-- /.card-header -->
			<?=form_open($formAction, ['id'=>'personForm', 'class'=>'form-horizontal'])  ?>
	<div class="card-body">
				<?=view('Themes/_commonPartials/_alertBoxes') ?>
				<?=view('personViews/_personFormItems') ?>
	</div><!-- /.card-body -->
	<div class="card-footer">
				<?=form_submit('save', ' Save ', ['class'=>'btn btn-primary']) ?>
				<a href="<?=route_to('App\Controllers\People::index') ?>" class="btn btn-default float-right">Cancel</a>
	</div><!-- /.card-footer -->
			<?=form_close() ?>
</div><!-- //.card -->
	</div><!--/.col -->
</div><!-- /.row -->
<?=$this->endSection() ?>