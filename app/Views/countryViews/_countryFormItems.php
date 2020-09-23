		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<?=form_label('ISO Code', 'isoCode'); ?>
					<?=form_input(['name' => 'iso_code', 'id' => 'isoCode', 'value' => (!empty(set_value('iso_code')) ? set_value('iso_code') : $country->iso_code), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 2, 'required' => true ]);  ?>
				</div><!--//.form-group -->

				<div class="form-group">
					<div class="form-check">
						<?=form_checkbox(['name'=>'enabled', 'id' => 'enabled', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($country->enabled==true ? true : false )]); ?>
						<?=form_label('Active', 'enabled', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->
				</div><!--//.form-group -->

			</div><!--//.col -->
			<div class="col-sm-6">
				<div class="form-group">
					<?=form_label('Country Name', 'countryName'); ?>
					<?=form_input(['name' => 'country_name', 'id' => 'countryName', 'value' => (!empty(set_value('country_name')) ? set_value('country_name') : $country->country_name), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 60, 'required' => true ]);  ?>
				</div><!--//.form-group -->

			</div><!--//.col -->

		</div><!-- //.row -->