		<div class="row">
			<div class="col-md-6 pl-4 pr-4">

				<div class="form-group row">
					<label for="isoCode" class="col-md-4 col-form-label">
						ISO Code*
					</label>
					<div class="col-md-8">
						<input type="text" id="isoCode" name="iso_code" required maxLength="2" class="form-control" value="<?=old('iso_code', $country->iso_code) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->

				<div class="form-group row">
					<div class="offset-md-4 col-md-8">
						<div class="form-check">

							<label for="enabled" class="col-md-4 col-form-label">
								<input type="checkbox" id="enabled" name="enabled" value="1"  class="form-check-input"<?=$country->enabled== true ? 'checked' : ''; ?>>
								Active
							</label>
						</div><!--//.form-check -->
					</div>

				</div><!--//.form-group -->
			</div><!--//.col -->
			<div class="col-md-6 pl-4 pr-4">

				<div class="form-group row">
					<label for="countryName" class="col-md-4 col-form-label">
						Country Name*
					</label>
					<div class="col-md-8">
						<input type="text" id="countryName" name="country_name" required maxLength="60" class="form-control" value="<?=old('country_name', $country->country_name) ?>">
					</div><!--//.col -->
				</div><!--//.form-group -->
			</div><!--//.col -->

		</div><!-- //.row -->