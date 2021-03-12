<?=$this->include('Themes/_commonPartialsBs4/datatables') ?>
<?=$this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?=$this->section('content');  ?>
<div class="row">
	<div class="col-md-12">

		<div class="card card-info">
			<div class="card-header">
				<h3 class="card-title">City List</h3>
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

					<table id="tableOfCities" class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="text-nowrap">Action</th>
								<th>ID</th>
								<th>City Name</th>
								<th>Country</th>
								<th>Active</th>
								<th>Updated At</th>
								<th class="text-nowrap">Action</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
			</div><!--//.card-body -->
			<div class="card-footer">
				<?=anchor(route_to('newCity'), 'Add a New City', ['class'=>'btn btn-primary']); ?>
			</div><!--//.card-footer -->
		</div><!--//.card -->
	</div><!--//.col -->
</div><!--//.row -->

<?=$this->endSection() ?>


<?=$this->section('js') ?>
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            var lastColNr = $('#tableOfCities').find("tr:first th").length - 1;
            var actionBtns = function(data) {
                return `<td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-warning btn-edit mr-1" data-id="${data.id}"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-danger btn-delete ml-1" data-id="${data.id}"><i class="fas fa-trash"></i></button>
                        </div>
                        </td>`
            };
            var theTable = $('#tableOfCities').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                scrollX: true,
                lengthMenu: [ 5, 10, 25, 50, 75, 100, 250, 500, 1000, 2500 ],
                pageLength: 10,
                lengthChange: true,
                stateSave: true,
                order: [[1, 'asc']],
                ajax : {
                    url: '<?= route_to('cities') ?>',
                    method: 'GET'
                },
                columnDefs: [
                    {
                        orderable: false,
                        searchable: false,
                        targets: [0,lastColNr]
                    }
                ],
                columns : [
                    { 'data': actionBtns },
				{ 'data': 'id' },
				{ 'data': 'city_name' },
				{ 'data': 'countries_country_name' },
				{ 'data': 'enabled' },
				{ 'data': 'updated_at' },
                    { 'data': actionBtns }
                ]
            });
    
        theTable.on( 'draw.dt', function () {
                const boolCols = [4];
            for (let coln of boolCols) {
                theTable.column(coln, { page: 'current' }).nodes().each( function (cell, i) {
                    cell.innerHTML = cell.innerHTML == '1' ? '<i class="text-success fas fa-check"></i>' : '';
                });
            }
                const dateCols = [5];
            const shortDateFormat = '<?= convertPhpDateToMomentFormat('j F Y')?>';
            const dateTimeFormat = '<?= convertPhpDateToMomentFormat('j F Y H:i')?>';
            
            for (let coln of dateCols) {
                theTable.column(coln, { page: 'current' }).nodes().each( function (cell, i) {
                    const datestr = cell.innerHTML;
                    const dateStrLen = datestr.toString().trim().length;
                    if (dateStrLen > 0) {
                        let dateTimeParts= datestr.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
                        dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
                        const d = new Date(...dateTimeParts); // new Date(datestr);
                        const md = moment(d);
                        const usingThisFormat = dateStrLen > 11 ? dateTimeFormat : shortDateFormat;
                        const formattedDateStr = md.format(usingThisFormat);
                        cell.innerHTML = formattedDateStr;
                    }
                });
            }
    });
    
        $(document).on('click', '.btn-edit', function(e) {
        // ${$(this).attr('data-id')}
        window.location.href = `<?= route_to('cities') ?>/${$(this).attr('data-id')}/edit`;
    });
        $(document).on('click', '.btn-delete', function(e) {
        Swal.fire({
            title: "Are you sure you want to delete this record?",
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then((result) => {
            if (result.value) {
                $.ajax({
                    url: `<?= route_to('cities') ?>/${$(this).attr('data-id')}`,
                    method: 'DELETE',
                }).done((data, textStatus, jqXHR) => {
                    Toast.fire({
                        icon: 'success',
                        title: jqXHR.statusText,
                    });
                    theTable.ajax.reload();
                }).fail((jqXHR, textStatus, errorThrown) => {
                    Toast.fire({
                        icon: 'error',
                        title: jqXHR.responseJSON.messages.error,
                    });
                })
            }
        });
    });
                                
        });

    </script>
<?=$this->endSection() ?>