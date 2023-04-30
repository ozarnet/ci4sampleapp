        <div class="row">
            <div class="col-md-12 col-lg-6 px-4">
				<div class="mb-3">
					<?=form_label(lang('People.firstName').'*', 'firstName', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'first_name', 'type' => 'text', 'id' => 'firstName', 'value' => old('first_name', $person->first_name) , 'class' => 'form-control'.(($ferr = session('formErrors.first_name')) ? ' is-invalid' : ''), 'maxlength' => 40, 'required' => true ]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.middleName'), 'middleName', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'middle_name', 'type' => 'text', 'id' => 'middleName', 'value' => old('middle_name', $person->middle_name) , 'class' => 'form-control'.(($ferr = session('formErrors.middle_name')) ? ' is-invalid' : ''), 'maxlength' => 40]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.lastName').'*', 'lastName', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'last_name', 'type' => 'text', 'id' => 'lastName', 'value' => old('last_name', $person->last_name) , 'class' => 'form-control'.(($ferr = session('formErrors.last_name')) ? ' is-invalid' : ''), 'maxlength' => 50, 'required' => true ]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.gender'), 'sex', ['class'=>'form-label']); ?>
	
					<div class="form-check">
							<?=form_radio(['name' => 'sex', 'id'=>'f', 'value'=>'F', 'class'=>'form-check-input', 'checked' => ( $person->sex == 'F' ? true : false )]);  ?>
							<?=form_label(lang('People.F'), 'f', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->


					<div class="form-check">
							<?=form_radio(['name' => 'sex', 'id'=>'m', 'value'=>'M', 'class'=>'form-check-input', 'checked' => ( $person->sex == 'M' ? true : false )]);  ?>
							<?=form_label(lang('People.M'), 'm', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->


					<div class="form-check">
							<?=form_radio(['name' => 'sex', 'id'=>'n', 'value'=>'N', 'class'=>'form-check-input', 'checked' => ( $person->sex == 'N' ? true : false )]);  ?>
							<?=form_label(lang('People.N'), 'n', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->


					<div class="form-check">
							<?=form_radio(['name' => 'sex', 'id'=>'u', 'value'=>'U', 'class'=>'form-check-input', 'checked' => ( $person->sex == 'U' ? true : false )]);  ?>
							<?=form_label(lang('People.U'), 'u', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->

				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.phoneNumber'), 'phoneNumber', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'phone_number', 'type' => 'text', 'id' => 'phoneNumber', 'value' => old('phone_number', $person->phone_number) , 'class' => 'form-control'.(($ferr = session('formErrors.phone_number')) ? ' is-invalid' : ''), 'maxlength' => 20]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.emailAddress'), 'emailAddress', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'email_address', 'type' => 'email', 'id' => 'emailAddress', 'value' => old('email_address', $person->email_address) , 'class' => 'form-control'.(($ferr = session('formErrors.email_address')) ? ' is-invalid' : ''), 'maxlength' => 50]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.city'), 'cityId', ['class'=>'form-label']); ?>
							<?=form_dropdown('city_id', $cityList, old('city_id', $person->city_id), ['id' => 'cityId', 'class' => 'form-control select2bs2', 'style'=>'width: 100%;']) ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.birthDate'), 'birthDate', ['class'=>'form-label']); ?>
				<?=form_input(['name' => 'birth_date', 'type' => 'date', 'id' => 'birthDate', 'value' => old('birth_date', $person->birth_date) , 'class' => 'form-control'.(($ferr = session('formErrors.birth_date')) ? ' is-invalid' : ''), 'maxlength' => 10]);  ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

            </div><!--//.col -->
            <div class="col-md-12 col-lg-6 px-4">
				<div class="mb-3">
					<?=form_label(lang('People.personType'), 'personType', ['class'=>'form-label']); ?>
	
					<div class="form-check">
							<?=form_radio(['name' => 'person_type', 'id'=>'unspecified', 'value'=>'unspecified', 'class'=>'form-check-input', 'checked' => ( $person->person_type == 'unspecified' ? true : false )]);  ?>
							<?=form_label(lang('People.unspecified'), 'unspecified', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->


					<div class="form-check">
							<?=form_radio(['name' => 'person_type', 'id'=>'colleague', 'value'=>'colleague', 'class'=>'form-check-input', 'checked' => ( $person->person_type == 'colleague' ? true : false )]);  ?>
							<?=form_label(lang('People.colleague'), 'colleague', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->


					<div class="form-check">
							<?=form_radio(['name' => 'person_type', 'id'=>'employee', 'value'=>'employee', 'class'=>'form-check-input', 'checked' => ( $person->person_type == 'employee' ? true : false )]);  ?>
							<?=form_label(lang('People.employee'), 'employee', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->


					<div class="form-check">
							<?=form_radio(['name' => 'person_type', 'id'=>'customer', 'value'=>'customer', 'class'=>'form-check-input', 'checked' => ( $person->person_type == 'customer' ? true : false )]);  ?>
							<?=form_label(lang('People.customer'), 'customer', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->


					<div class="form-check">
							<?=form_radio(['name' => 'person_type', 'id'=>'friend', 'value'=>'friend', 'class'=>'form-check-input', 'checked' => ( $person->person_type == 'friend' ? true : false )]);  ?>
							<?=form_label(lang('People.friend'), 'friend', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->

				</div><!--//.mb-3 -->

				<div class="mb-3">
					<div class="form-check">
						<?=form_checkbox(['name'=>'is_friend', 'id' => 'isFriend', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($person->is_friend==true ? true : false )]); ?>
						<?=form_label(lang('People.isFriend'), 'isFriend', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->
			</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.notes'), 'notes', ['class'=>'form-label']); ?>
						<?=form_textarea(['name'=>'notes', 'id' => 'notes', 'value' => old('notes', $person->notes), 'rows' => 3, 'style' => 'height: 10em;', 'class' => 'form-control'.(($ferr = session('formErrors.notes')) ? ' is-invalid' : ''), 'maxlength' => 16313]) ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

				<div class="mb-3">
					<div class="form-check">
						<?=form_checkbox(['name'=>'enabled', 'id' => 'enabled', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($person->enabled==true ? true : false )]); ?>
						<?=form_label(lang('People.enabled'), 'enabled', ['class'=>'form-check-label']);  ?>
					</div><!--//.form-check -->
			</div><!--//.mb-3 -->

				<div class="mb-3">
					<?=form_label(lang('People.score'), 'score', ['class'=>'form-label']); ?>
							<?=form_input(['name' => 'score', 'id' => 'score', 'value' => old('score', $person->score), 'type' => 'range' , 'class' => 'form-range'.(($ferr = session('formErrors.score')) ? ' is-invalid' : '')]); ?>
						<?php if ( $ferr ) { ?>
							<div class="invalid-feedback">
								<?= $ferr ?>
							</div>
						<?php } ?>
				</div><!--//.mb-3 -->

            </div><!--//.col -->

        </div><!-- //.row -->