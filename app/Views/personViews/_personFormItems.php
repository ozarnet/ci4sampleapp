		<div class="row">
			<div class="col-sm-6">

				<div class="form-group row">
					<?=form_label('First Name', 'firstName', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'first_name', 'id' => 'firstName', 'value' => (!empty(set_value('first_name')) ? set_value('first_name') : $person->first_name), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 40, 'required' => true ]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Middle Name', 'middleName', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'middle_name', 'id' => 'middleName', 'value' => (!empty(set_value('middle_name')) ? set_value('middle_name') : $person->middle_name), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 40]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Last Name', 'lastName', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'last_name', 'id' => 'lastName', 'value' => (!empty(set_value('last_name')) ? set_value('last_name') : $person->last_name), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 50, 'required' => true ]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Phone Number', 'phoneNumber', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'phone_number', 'id' => 'phoneNumber', 'value' => (!empty(set_value('phone_number')) ? set_value('phone_number') : $person->phone_number), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 20]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Email Address', 'emailAddress', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'email_address', 'id' => 'emailAddress', 'value' => (!empty(set_value('email_address')) ? set_value('email_address') : $person->email_address), 'type' => 'email' , 'class' => 'form-control', 'maxlength' => 50]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Birth Date', 'birthDate', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'birth_date', 'id' => 'birthDate', 'value' => (!empty(set_value('birth_date')) ? set_value('birth_date') : $person->birth_date), 'type' => 'date' , 'class' => 'form-control', 'maxlength' => 10]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<div class="offset-sm-3 col-sm-8">
						<div class="form-check">
						<?=form_checkbox(['name'=>'is_friend', 'id' => 'isFriend', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($person->is_friend==true ? true : false )]); ?>
						<?=form_label('Is Friend', 'isFriend', ['class'=>'form-check-label']);  ?>
						</div><!--//.form-check -->
					</div>

				</div><!--//.form-group -->

				<div class="form-group row">
					<div class="offset-sm-3 col-sm-8">
						<div class="form-check">
						<?=form_checkbox(['name'=>'enabled', 'id' => 'enabled', 'value' => 1, 'class' => 'form-check-input', 'checked' => ($person->enabled==true ? true : false )]); ?>
						<?=form_label('Active', 'enabled', ['class'=>'form-check-label']);  ?>
						</div><!--//.form-check -->
					</div>

				</div><!--//.form-group -->
			</div><!--//.col -->
			<div class="col-sm-6">

				<div class="form-group row">
					<?=form_label('Country', 'countryCode', ['class'=>'col-sm-3 col-form-label text-right']); ?>
			<div class="col-sm-8">
					<?=form_dropdown('country_code', $countryList, (!empty(set_value('country_code')) ? set_value('country_code') : $person->country_code), ['id' => 'countryCode', 'class' => 'form-control select2bs']) ?>
						</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('City', 'cityId', ['class'=>'col-sm-3 col-form-label text-right']); ?>
			<div class="col-sm-8">
					<?=form_dropdown('city_id', $cityList, (!empty(set_value('city_id')) ? set_value('city_id') : $person->city_id), ['id' => 'cityId', 'class' => 'form-control select2bs']) ?>
						</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Notes', 'notes', ['class'=>'col-sm-3 col-form-label text-right']); ?>
			<div class="col-sm-8">
					<?=form_textarea(['name'=>'notes', 'id' => 'notes', 'value' => (!empty(set_value('notes')) ? set_value('notes') : $person->notes), 'rows' => 3, 'class' => 'form-control', 'maxlength' => 16313]) ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Photo', 'photo', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'photo', 'id' => 'photo', 'value' => (!empty(set_value('photo')) ? set_value('photo') : $person->photo), 'type' => 'text' , 'class' => 'form-control', 'maxlength' => 255]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<?=form_label('Score', 'score', ['class'=>'col-sm-3 col-form-label text-right']); ?>
					<div class="col-sm-8">
						<?=form_input(['name' => 'score', 'id' => 'score', 'value' => (!empty(set_value('score')) ? set_value('score') : $person->score), 'type' => 'range' , 'class' => 'form-control', 'maxlength' => 31]);  ?>
					</div><!--//.col -->
				</div><!--//.form-group -->
			</div><!--//.col -->

		</div><!-- //.row -->