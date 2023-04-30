        <div class="row">
            <div class="col-md-12 col-lg-12 px-4">
				<div class="mb-3">
					<?=form_label(lang('Countries.isoCode').'*', 'isoCode', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'iso_code', 'type' => 'text', 'id' => 'isoCode', 'value' => old('iso_code', $country->iso_code) , 'class' => 'form-control'.(($ferr = session('formErrors.iso_code')) ? ' is-invalid' : ''), 'maxlength' => 2, 'required' => true ]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('Countries.countryName').'*', 'countryName', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'country_name', 'type' => 'text', 'id' => 'countryName', 'value' => old('country_name', $country->country_name) , 'class' => 'form-control'.(($ferr = session('formErrors.country_name')) ? ' is-invalid' : ''), 'maxlength' => 60, 'required' => true ]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<div class="form-check">
						<?=form_checkbox(['name'=>'enabled', 'id' => 'enabled', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($country->enabled==true ? true : false )]); ?>
						<?=form_label(lang('Countries.active'), 'enabled', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->
			</div><!--//.mb-3 -->

            </div><!--//.col -->

        </div><!-- //.row -->