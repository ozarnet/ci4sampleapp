<?= $this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?= $this->section('content');  ?>

	<?=view('Themes/_commonPartialsBs/_alertBoxes') ?>


	<!-- Info boxes -->
	<div class="row">
		<div class="col-lg-3 col-6">

			<div class="small-box bg-info">
				<div class="inner">
					<h3><?= $totalNrOfCities; ?></h3>
					<p><?=lang('Cities.cities') ?></p>
				</div>
				<div class="icon">
					<i class="bi bi-asterisk"></i>
				</div>
				<?= anchor(route_to('cityList'), lang('Basic.global.MoreInfo').'  <i class="fas fa-arrow-circle-right"></i>', ['class'=>'small-box-footer']); ?>

			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

			<div class="small-box bg-success">
				<div class="inner">
					<h3><?= $totalNrOfCountries; ?></h3>
					<p><?=lang('Countries.countries') ?></p>
				</div>
				<div class="icon">
					<i class="bi bi-bookmarks-fill"></i>
				</div>
				<?= anchor(route_to('countryList'), lang('Basic.global.MoreInfo').'  <i class="fas fa-arrow-circle-right"></i>', ['class'=>'small-box-footer']); ?>

			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

			<div class="small-box bg-warning">
				<div class="inner">
					<h3><?= $totalNrOfPeople; ?></h3>
					<p><?=lang('People.people') ?></p>
				</div>
				<div class="icon">
					<i class="bi bi-bar-chart-line"></i>
				</div>
				<?= anchor(route_to('personList'), lang('Basic.global.MoreInfo').'  <i class="fas fa-arrow-circle-right"></i>', ['class'=>'small-box-footer']); ?>

			</div><!-- /.small-box -->

		</div><!-- /.col -->
		<div class="col-lg-3 col-6">

		</div><!-- /.col -->
	</div><!-- /.row -->

<?= $this->endSection() ?>