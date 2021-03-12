        <div class="row">
            <div class="col-sm-6 pl-4 pr-4">

				<div class="form-group row">

					<label for="firstName" class="col-md-4 col-form-label">
						First Name*
					</label>
					<div class="col-md-8">
						<input type="text" id="firstName" name="first_name" required maxLength="40" class="form-control" value="<?=old('first_name', $person->first_name) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="middleName" class="col-md-4 col-form-label">
						Middle Name
					</label>
					<div class="col-md-8">
						<input type="text" id="middleName" name="middle_name" maxLength="40" class="form-control" value="<?=old('middle_name', $person->middle_name) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="lastName" class="col-md-4 col-form-label">
						Last Name*
					</label>
					<div class="col-md-8">
						<input type="text" id="lastName" name="last_name" required maxLength="50" class="form-control" value="<?=old('last_name', $person->last_name) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="sex" class="col-md-4 col-form-label">
						Gender
					</label>
					<div class="col-md-8">

    <div class="form-check">
							<label for="f" class="form-check-label">
								<input type="radio" id="f" name="sex" value="F" class="form-check-input" <?= $person->sex == 'F' ? 'checked' : '' ?>>
								Female
							</label>
    </div><!--//.form-check -->



    <div class="form-check">
							<label for="m" class="form-check-label">
								<input type="radio" id="m" name="sex" value="M" class="form-check-input" <?= $person->sex == 'M' ? 'checked' : '' ?>>
								Male
							</label>
    </div><!--//.form-check -->


					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="phoneNumber" class="col-md-4 col-form-label">
						Phone Number
					</label>
					<div class="col-md-8">
						<input type="text" id="phoneNumber" name="phone_number" maxLength="20" class="form-control" value="<?=old('phone_number', $person->phone_number) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="emailAddress" class="col-md-4 col-form-label">
						Email Address
					</label>
					<div class="col-md-8">
						<input type="email" id="emailAddress" name="email_address" maxLength="50" class="form-control" value="<?=old('email_address', $person->email_address) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="birthDate" class="col-md-4 col-form-label">
						Birth Date
					</label>
					<div class="col-md-8">
						<input type="date" id="birthDate" name="birth_date" maxLength="10" class="form-control" value="<?=old('birth_date', $person->birth_date) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->
            </div><!--//.col -->
            <div class="col-sm-6 pl-4 pr-4">

				<div class="form-group row">

					<label for="cityId" class="col-md-4 col-form-label">
						City
					</label>
					<div class="col-md-8">
						<select id="cityId" name="city_id" class="form-control select2bs" style="width: 100%;" >
							<option value="">Please select a city...</option>

							<?php foreach($cityList as $item) : ?>
							<option value="<?=$item->id ?>"<?=$item->id==$person->city_id ? ' selected':'' ?>>
								<?=$item->city_name ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="personType" class="col-md-4 col-form-label">
						Contact Type
					</label>
					<div class="col-md-8">

    <div class="form-check">
							<label for="unspecified" class="form-check-label">
								<input type="radio" id="unspecified" name="person_type" value="unspecified" class="form-check-input" <?= $person->person_type == 'unspecified' ? 'checked' : '' ?>>
								unspecified
							</label>
    </div><!--//.form-check -->



    <div class="form-check">
							<label for="colleague" class="form-check-label">
								<input type="radio" id="colleague" name="person_type" value="colleague" class="form-check-input" <?= $person->person_type == 'colleague' ? 'checked' : '' ?>>
								colleague
							</label>
    </div><!--//.form-check -->



    <div class="form-check">
							<label for="employee" class="form-check-label">
								<input type="radio" id="employee" name="person_type" value="employee" class="form-check-input" <?= $person->person_type == 'employee' ? 'checked' : '' ?>>
								employee
							</label>
    </div><!--//.form-check -->



    <div class="form-check">
							<label for="customer" class="form-check-label">
								<input type="radio" id="customer" name="person_type" value="customer" class="form-check-input" <?= $person->person_type == 'customer' ? 'checked' : '' ?>>
								customer
							</label>
    </div><!--//.form-check -->



    <div class="form-check">
							<label for="friend" class="form-check-label">
								<input type="radio" id="friend" name="person_type" value="friend" class="form-check-input" <?= $person->person_type == 'friend' ? 'checked' : '' ?>>
								friend
							</label>
    </div><!--//.form-check -->


					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="notes" class="col-md-4 col-form-label">
						Notes
					</label>
					<div class="col-md-8">
						<textarea rows="3" id="notes" name="notes" class="form-control"><?=old('notes', $person->notes) ?></textarea>
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">

					<div class="offset-md-4 col-md-8">
						<div class="form-check">

							<label for="enabled" class="col-md-4 col-form-label">
								<input type="checkbox" id="enabled" name="enabled" value="1"  class="form-check-input"<?=$person->enabled== true ? 'checked' : ''; ?>>
								Active
							</label>
						</div><!--//.form-check -->
					</div>

				</div><!--//.form-group -->

				<div class="form-group row">

					<label for="score" class="col-md-4 col-form-label">
						Score
					</label>
					<div class="col-md-8">
						<input type="range" id="score" name="score" maxLength="5" class="form-control" value="<?=old('score', $person->score) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->
            </div><!--//.col -->

        </div><!-- //.row -->