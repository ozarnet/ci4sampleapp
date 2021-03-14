<?=$this->include('Themes/_commonPartialsBs4/datatables') ?>
<?=$this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?=$this->section('content');  ?>
<div class="row">
    <div class="col-md-12">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Country List</h3>
           </div><!--//.card-header -->
            <div class="card-body">
				<?= view('Themes/_commonPartials/_alertBoxes'); ?>

					<table id="tableOfCountries" class="table table-striped table-hover using-data-table">
						<thead>
							<tr>
								<th class="text-nowrap">Action</th>
								<th>ISO Code</th>
								<th>Country Name</th>
								<th>Active</th>
								<th>Last Modified on</th>
								<th class="text-nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($countryList as $item ) : ?>
							<tr>
								<td class="align-middle text-center text-nowrap">
									<?=anchor(route_to('editCountry', $item->iso_code), '<i class="fas fa-pencil-alt"></i>', ['class'=>'btn btn-sm btn-warning mr-1', 'data-id'=>$item->iso_code]); ?> 
									<?=anchor('#confirm2delete', '<i class="fas fa-trash"></i>', ['class'=>'btn btn-sm btn-danger ml-1', 'data-href'=>route_to('deleteCountry', $item->iso_code), 'data-toggle'=>'modal', 'data-target'=>'#confirm2delete']); ?>
								</td>
								<td class="align-middle text-center">
									<?=$item->iso_code ?>
								</td>
								<td class="align-middle">
									<?= strlen($item->country_name) < 51 ? esc($item->country_name) : character_limiter(esc($item->country_name), 50)   ?>
								</td>
								<td class="align-middle text-center text-green">

								<?php if ( $item->enabled ) { ?>

									<i class="text-success fas fa-check"></i>

								<?php  }  ?>

								</td>
								<td class="align-middle text-nowrap">
									<?= empty($item->updated_at) ? '' : date('j F Y H:i', strtotime($item->updated_at))  ?>
								</td>
								<td class="align-middle text-center text-nowrap">
									<?=anchor(route_to('editCountry', $item->iso_code), '<i class="fas fa-pencil-alt"></i>', ['class'=>'btn btn-sm btn-warning mr-1', 'data-id'=>$item->iso_code]); ?> 
									<?=anchor('#confirm2delete', '<i class="fas fa-trash"></i>', ['class'=>'btn btn-sm btn-danger ml-1', 'data-href'=>route_to('deleteCountry', $item->iso_code), 'data-toggle'=>'modal', 'data-target'=>'#confirm2delete']); ?>
								</td>
							</tr>

						<?php endforeach; ?>
						</tbody>
					</table>
            </div><!--//.card-body -->
            <div class="card-footer">
				<?=anchor(route_to('newCountry'), 'Add a New Country', ['class'=>'btn btn-primary']); ?>
            </div><!--//.card-footer -->
        </div><!--//.card -->
    </div><!--//.col -->
</div><!--//.row -->

<?=$this->endSection() ?>