<?=$this->include('Themes/_commonPartialsBs4/datatables') ?>
<?=$this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?=$this->section('content');  ?>
<div class="row">
	<div class="col-md-12">

		<div class="card card-info">
			<div class="card-header">
				<h3 class="card-title">Person List</h3>
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

					<table id="tableOfPeople" class="table table-striped table-hover using-data-table">
						<thead>
							<tr>
								<th class="text-nowrap">Action</th>
								<th>ID</th>
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Gender</th>
								<th>Phone Number</th>
								<th>Email Address</th>
								<th>City</th>
								<th>Contact Type</th>
								<th>Birth Date</th>
								<th>Notes</th>
								<th>Active</th>
								<th>Score</th>
								<th>Created on</th>
								<th>Last Modified</th>
								<th class="text-nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($personList as $item ) : ?>
							<tr>
								<td class="align-middle text-center text-nowrap">
									<?=anchor(route_to('editPerson', $item->id), '<i class="fas fa-pencil-alt"></i>', ['class'=>'btn btn-sm btn-warning mr-1', 'data-id'=>$item->id]); ?> 
									<?=anchor('#confirm2delete', '<i class="fas fa-trash"></i>', ['class'=>'btn btn-sm btn-danger ml-1', 'data-href'=>route_to('deletePerson', $item->id), 'data-toggle'=>'modal', 'data-target'=>'#confirm2delete']); ?>
								</td>
								<td class="align-middle text-center">
									<?=$item->id ?>
								</td>
								<td class="align-middle">
									<?= esc($item->first_name) ?>
								</td>
								<td class="align-middle">
									<?= esc($item->middle_name) ?>
								</td>
								<td class="align-middle">
									<?= strlen($item->last_name) < 51 ? esc($item->last_name) : character_limiter(esc($item->last_name), 50)   ?>
								</td>
								<td class="align-middle">
									<?= esc($item->sex) ?>
								</td>
								<td class="align-middle">
									<?= esc($item->phone_number) ?>
								</td>
								<td class="align-middle">
									<?= esc($item->email_address) ?>
								</td>
								<td class="align-middle">
									<?= esc($item->cities_city_name) ?>
								</td>
								<td class="align-middle">
									<?= esc($item->person_type) ?>
								</td>
								<td class="align-middle text-nowrap">
									<?= empty($item->birth_date) ? '' : date('j F Y', strtotime($item->birth_date))  ?>
								</td>
								<td class="align-middle">
									<?= strlen($item->notes) < 51 ? esc($item->notes) : character_limiter(esc($item->notes), 50)   ?>
								</td>
								<td class="align-middle text-center text-green">

								<?php if ( $item->enabled ) { ?>

									<i class="text-success fas fa-check"></i>

								<?php  }  ?>

								</td>
								<td class="align-middle">
									<?= esc($item->score) ?>
								</td>
								<td class="align-middle text-nowrap">
									<?= empty($item->created_at) ? '' : date('j F Y H:i', strtotime($item->created_at))  ?>
								</td>
								<td class="align-middle text-nowrap">
									<?= empty($item->updated_at) ? '' : date('j F Y H:i', strtotime($item->updated_at))  ?>
								</td>
								<td class="align-middle text-center text-nowrap">
									<?=anchor(route_to('editPerson', $item->id), '<i class="fas fa-pencil-alt"></i>', ['class'=>'btn btn-sm btn-warning mr-1', 'data-id'=>$item->id]); ?> 
									<?=anchor('#confirm2delete', '<i class="fas fa-trash"></i>', ['class'=>'btn btn-sm btn-danger ml-1', 'data-href'=>route_to('deletePerson', $item->id), 'data-toggle'=>'modal', 'data-target'=>'#confirm2delete']); ?>
								</td>
							</tr>

						<?php endforeach; ?>
						</tbody>
					</table>
			</div><!--//.card-body -->
			<div class="card-footer">
				<?=anchor(route_to('newPerson'), 'Add a New Person', ['class'=>'btn btn-primary']); ?>
			</div><!--//.card-footer -->
		</div><!--//.card -->
	</div><!--//.col -->
</div><!--//.row -->

<?=$this->endSection() ?>