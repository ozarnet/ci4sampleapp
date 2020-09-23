<?= $this->include('Themes/_commonPartialsBs4/datatables') ?>
<?= $this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?= $this->section('content');  ?>

	<!-- Info boxes -->
	<div class="row">
		<div class="col-lg-3 col-6">

			<div class="small-box bg-info">
				<div class="inner">
					<h3><?= $totalNrOfCountries; ?></h3>
					<p>Total Countries</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="<?=route_to('App\Controllers\Countries::index') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

			<div class="small-box bg-success">
				<div class="inner">
					<h3><?= $totalNrOfCities; ?></h3>
					<p>Total Cities</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="<?=route_to('App\Controllers\Cities::index') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

			<div class="small-box bg-warning">
				<div class="inner">
					<h3><?= $totalNrOfPeople; ?></h3>
					<p>Total People</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="<?=route_to('App\Controllers\People::index') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

		</div><!-- /.col -->
	</div><!-- /.row -->

<?= $this->endSection() ?>