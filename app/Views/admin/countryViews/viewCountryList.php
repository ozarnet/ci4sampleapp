<?=$this->include('Themes/_commonPartialsBs/datatables') ?>
<?=$this->include('Themes/_commonPartialsBs/sweetalert') ?>
<?=$this->extend('Themes/'.config('Basics')->theme['name'].'/AdminLayout/defaultLayout') ?>
<?=$this->section('content');  ?>
<div class="row">
    <div class="col-md-12">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><?=lang('Countries.countryList') ?></h3>
           </div><!--//.card-header -->
            <div class="card-body">
				<?= view('Themes/_commonPartialsBs/_alertBoxes'); ?>

					<table id="tableOfCountries" class="table table-striped table-hover" style="width: 100%;">
						<thead>
							<tr>
								<th class="text-nowrap"><?= lang('Basic.global.Action') ?></th>
								<th><?=lang('Countries.isoCode')?></th>
								<th><?= lang('Countries.countryName') ?></th>
								<th><?= lang('Countries.active') ?></th>
								<th><?= lang('Countries.updatedAt') ?></th>
								<th class="text-nowrap"><?= lang('Basic.global.Action') ?></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
            </div><!--//.card-body -->
            <div class="card-footer">
				<div class="float-end">
                    <button type="button" class="btn btn-block btn-primary" id="btnAddRecord" data-bs-toggle="modal" data-bs-target="#modalCountryForm">
                        <?=lang('Basic.global.addNew').' '.lang('Countries.country') ?>
                    </button>
				<div> <!--./ float-end-->
            </div><!--//.card-footer -->
        </div><!--//.card -->
    </div><!--//.col -->
</div><!--//.row -->

<?=$this->endSection() ?>


<?=$this->section('footerAdditions') ?>
	<?=$this->include('admin/countryViews/_countryFormAdditions') ?>
<?=$this->endSection() ?>


<?=$this->section('additionalInlineJs') ?>
    
            const lastColNr = $('#tableOfCountries').find("tr:first th").length - 1;
            const actionBtns = function(data) {
                return `<td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-warning btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalCountryForm" data-id="${data.iso_code}"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete ms-1" data-id="${data.iso_code}"><i class="bi bi-trash"></i></button>
                        </div>
                        </td>`;
            };
            theTable = $('#tableOfCountries').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                responsive: true,
                scrollX: true,
                lengthMenu: [ 5, 10, 25, 50, 75, 100, 250, 500, 1000, 2500 ],
                pageLength: 10,
                lengthChange: true,
                
                stateSave: true,
                order: [[1, 'asc']],
                language: {
                    url: "/assets/dt/<?= config('Basics')->languages[$currentLocale] ?? config('Basics')->i18n ?>.json"
                },
                ajax : $.fn.dataTable.pipeline( {
                    url: '<?= route_to('dataTableOfCountries') ?>',
                    method: 'POST',
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    async: true,
                }),
                columnDefs: [
                    {
                        orderable: false,
                        searchable: false,
                        targets: [0,lastColNr]
                    }
                ],
                columns : [
                    { 'data': actionBtns },
					{ 'data': 'iso_code' },
					{ 'data': 'country_name' },
					{ 'data': 'enabled' },
					{ 'data': 'updated_at' },
                    { 'data': actionBtns }
                ]
            });

    
        theTable.on( 'draw.dt', function () {
                const boolCols = [3];
            for (let coln of boolCols) {
                theTable.column(coln, { page: 'current' }).nodes().each( function (cell, i) {
                    cell.innerHTML = cell.innerHTML == '1' ? '<i class="text-success bi bi-check-lg"></i>' : '';
                });
            }
                const dateCols = [4];
            const shortDateFormat = '<?= convertPhpDateToMomentFormat('d/m/Y')?>';
            const dateTimeFormat = '<?= convertPhpDateToMomentFormat('d/m/Y H:i')?>';
            
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

$(document).on('click', '#btnAddRecord', () => {
    $('#modalCountryLabel').html("Add a New Country");
    $('#countryForm').find('input[name="form_action"]').val('add');
    $('#countryForm').find('input[name="iso_code"]').val('');
    // call select2 functions here if applicable
});

$('#modalCountryForm').on('hidden.bs.modal', function() {
    $(this).find('#countryForm')[0].reset();
    $('.text-danger').remove();
    $('.is-invalid').removeClass('is-invalid');
});

$(document).on('click', '#btnSaveCountry', () => {
    $('.text-danger').remove();
    $('.is-invalid').removeClass('is-invalid');
    const theForm = $('#countryForm');
    if (theForm === undefined || theForm == null) {
        return;
    }
    const fa = $('#formAction').val();
    let u, fm;
    if (fa == 'add') {
        u = '<?= route_to('ajaxCreateCountry') ?>';
        fm = 'POST';
    } else {
        u = `<?= route_to('countryList') ?>/${ $('#isoCode').val() }/update`;
        fm = 'PUT';
    }

	const cbEnabled = theForm.find('#enabled');
			cbEnabled.val(1);
    $.ajax({
        url: u,
        method: fm,
        data: theForm.serialize()
    }).done((data, textStatus, jqXHR) => {
        Toast.fire({
            icon: 'success',
            title: jqXHR.statusText
        });
        // if (fa == 'add') {
            theTable.clearPipeline();
        // }

        $("#modalCountryForm").modal('hide');
        theForm.trigger("reset");

        theTable.ajax.reload();

    }).fail((xhr, status, error) => {
        let errMsg;
        if (errMsg = xhr.responseJSON.message ?? xhr.responseJSON.messages.error) {
            Toast.fire({
                icon: 'error',
                title: errMsg,
            });
        }

        $.each(xhr.responseJSON.messages, (elem, message) => {
            theForm.find('input[name="' + elem + '"]').addClass('is-invalid').after('<p class="text-danger">' + message + '</p>');
            theForm.find('textarea[name="' + elem + '"]').addClass('is-invalid').after('<p class="text-danger">' + message + '</p>');
        });
    });
});


function getDataToEdit(sender) {
    $.ajax({
        url: `<?= route_to('countryList') ?>/${sender}/edit`,
        method: 'GET',
    }).done((response) => {
        const editForm = $('#countryForm');
		editForm.find('#isoCode').val(response.data.iso_code);
		editForm.find('#countryName').val(response.data.country_name);
		editForm.find('#enabled').prop('checked', response.data.enabled);

        
        
        
        editForm.find('input[name="form_action"]').val('edit');
        $('#modalCountryLabel').html("Edit Country");
        $("#modalCountryForm").modal('show');

    }).fail((error) => {
        Toast.fire({
            icon: 'error',
            title: error.responseJSON.messages.error,
        });
        
    });
}

$(document).on('click', '.btn-edit', function(e) {
    e.preventDefault();
    const dest = $(this).attr('data-id');
    
    getDataToEdit(dest);
});
    
$(document).on('click', '.btn-delete', function(e) {
        Swal.fire({
            title: '<?= lang('Basic.global.sweet.sureToDeleteTitle', [mb_strtolower(lang('Countries.country'))]) ?>',
            text: '<?= lang('Basic.global.sweet.sureToDeleteText') ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: '<?= lang('Basic.global.sweet.deleteConfirmationButton') ?>',
            cancelButtonText: '<?= lang('Basic.global.Cancel') ?>',
            cancelButtonColor: '#d33'
        })
        .then((result) => {
            const dataId = $(this).data('id');
            const row = $(this).closest('tr');
            if (result.value) {
                $.ajax({
                    url: `<?= route_to('countryList') ?>/${dataId}`,
                    method: 'DELETE',
                }).done((data, textStatus, jqXHR) => {
                    Toast.fire({
                        icon: 'success',
                        title: data.msg ?? jqXHR.statusText,
                    });
                    
                    theTable.clearPipeline();
                    theTable.row($(row)).invalidate().draw();
                }).fail((jqXHR, textStatus, errorThrown) => {
                    Toast.fire({
                        icon: 'error',
                        title: jqXHR.responseJSON.messages.error,
                    });
                })
            }
        });
    });
                                
    

    
<?=$this->endSection() ?>