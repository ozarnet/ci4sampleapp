<?=$this->include('Themes/_commonPartialsBs4/datatables') ?>
<?=$this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?=$this->section('content');  ?>
<div class="row">
	<div class="col-md-12">

		<div class="card card-info">
			<div class="card-header">
				<h3 class="card-title">Cities</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>

					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i>
					</button>

				</div><!--//.card-tools -->

			</div><!--//.card-header -->
			<div class="card-body">
				<?= view('Themes/_commonPartials/_alertBoxes'); ?>

					<table id="tableOfcities" class="table table-striped table-hover using-data-table">
						<thead>
							<tr>
								<th class="text-nowrap">Action</th>
								<th>ID</th>
								<th>City Name</th>
								<th>Country</th>
								<th>Active</th>
								<th class="text-nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($cityList as $item ) : ?>
							<tr>
								<td class="align-middle text-center text-nowrap">
									<a href="<?=route_to('editCity', $item->id) ?>" class="btn btn-sm btn-warning mr-1" data-id="<?=$item->id ?>"><i class="fas fa-edit"></i></a>
									<a href="#confirm2delete" class="btn btn-sm btn-danger ml-1" data-href="<?=route_to('deleteCity', $item->id) ?>" data-toggle="modal" data-target="#confirm2delete"><i class="fas fa-times"></i></a>
								</td>
								<td class="align-middle text-center">
									<?=$item->id ?>
								</td>
								<td class="align-middle">
									<?=$item->city_name ?>
								</td>
								<td class="align-middle">
									<?=$item->country_name ?>
								</td>
								<td class="align-middle text-center text-green">

								<?php if ( $item->enabled ) { ?>

									<i class="text-success fas fa-check"></i>

								<?php  }  ?>

								</td>
								<td class="align-middle text-center text-nowrap">
									<a href="<?=route_to('editCity', $item->id) ?>" class="btn btn-sm btn-warning mr-1" data-id="<?=$item->id ?>"><i class="fas fa-edit"></i></a>
									<a href="#confirm2delete" class="btn btn-sm btn-danger ml-1" data-href="<?=route_to('deleteCity', $item->id) ?>" data-toggle="modal" data-target="#confirm2delete"><i class="fas fa-times"></i></a>
								</td>
							</tr>

						<?php endforeach; ?>
						</tbody>
					</table>
			</div><!--//.card-body -->
			<div class="card-footer">
				<a href="<?=route_to('newCity') ?>" class="btn btn-primary">
				Add a New City
		</a>
			</div><!--//.card-footer -->
		</div><!--//.card -->
	</div><!--//.col -->
</div><!--//.row -->

<?=$this->endSection() ?>