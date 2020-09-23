		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<?=form_label('City Name', 'cityName'); ?>
					<?=form_input(['name' => 'city_name', 'id' => 'cityName', 'value' => (!empty(set_value('city_name')) ? set_value('city_name') : $city->city_name), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 60, 'required' => true ]);  ?>
				</div><!--//.form-group -->

				<div class="form-group">
					<div class="form-check">
						<?=form_checkbox(['name'=>'enabled', 'id' => 'enabled', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($city->enabled==true ? true : false )]); ?>
						<?=form_label('Active', 'enabled', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->
				</div><!--//.form-group -->

			</div><!--//.col -->
			<div class="col-sm-6">
				<div class="form-group">
					<?=form_label('Country', 'countryCode'); ?>
					<?=form_dropdown('country_code', $countryList, (!empty(set_value('country_code')) ? set_value('country_code') : $city->country_code), ['id' => 'countryCode', 'class' => 'form-control select2bs']) ?>
					</div><!--//.form-group -->

			</div><!--//.col -->

		</div><!-- //.row -->