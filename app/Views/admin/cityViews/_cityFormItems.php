        <div class="row">
            <div class="col-md-12 col-lg-6 px-4">
				<div class="mb-3">
					<?=form_label(lang('Cities.country'), 'countryCode', ['class'=>'form-label']); ?>
							<?=form_dropdown('country_code', $countryList, old('country_code', $city->country_code), ['id' => 'countryCode', 'class' => 'form-control select2bs2', 'style'=>'width: 100%;']) ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<div class="form-check">
						<?=form_checkbox(['name'=>'enabled', 'id' => 'enabled', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($city->enabled==true ? true : false )]); ?>
						<?=form_label(lang('Cities.active'), 'enabled', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->
			</div><!--//.mb-3 -->

            </div><!--//.col -->
            <div class="col-md-12 col-lg-6 px-4">
				<div class="mb-3">
					<?=form_label(lang('Cities.cityName').'*', 'cityName', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'city_name', 'type' => 'text', 'id' => 'cityName', 'value' => old('city_name', $city->city_name) , 'class' => 'form-control'.(($ferr = session('formErrors.city_name')) ? ' is-invalid' : ''), 'maxlength' => 60, 'required' => true ]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

            </div><!--//.col -->

        </div><!-- //.row -->