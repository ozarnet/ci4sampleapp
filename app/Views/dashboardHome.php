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
					<i class="far fa-square"></i>
				</div>
				<?= anchor(route_to('countries'), 'More info <i class="fas fa-arrow-circle-right"></i>', ['class'=>'small-box-footer']); ?>

			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

			<div class="small-box bg-success">
				<div class="inner">
					<h3><?= $totalNrOfCities; ?></h3>
					<p>Total Cities</p>
				</div>
				<div class="icon">
					<i class="far fa-question-circle"></i>
				</div>
				<?= anchor(route_to('cities'), 'More info <i class="fas fa-arrow-circle-right"></i>', ['class'=>'small-box-footer']); ?>

			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

			<div class="small-box bg-warning">
				<div class="inner">
					<h3><?= $totalNrOfPeople; ?></h3>
					<p>Total People</p>
				</div>
				<div class="icon">
					<i class="fas fa-chart-bar"></i>
				</div>
				<?= anchor(route_to('people'), 'More info <i class="fas fa-arrow-circle-right"></i>', ['class'=>'small-box-footer']); ?>

			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

		</div><!-- /.col -->
	</div><!-- /.row -->

<?= $this->endSection() ?>