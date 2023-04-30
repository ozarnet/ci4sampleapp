<?php



return [
		'F' => 'Female',
		'M' => 'Male',
		'N' => 'Non-binary',
		'U' => 'Unspecified',
		'age' => 'Age',
		'birthDate' => 'Birth Date',
		'city' => 'City',
		'colleague' => 'colleague',
		'countryCode' => 'Country Code',
		'createdAt' => 'Created At',
		'customer' => 'customer',
		'deletedAt' => 'Deleted At',
		'emailAddress' => 'Email Address',
		'employee' => 'employee',
		'enabled' => 'Active',
		'firstName' => 'First Name',
		'friend' => 'friend',
		'gender' => 'Gender',
		'id' => 'ID',
		'isFriend' => 'Is Friend',
		'lastName' => 'Last Name',
		'middleName' => 'Middle Name',
		'moduleTitle' => 'People',
		'notes' => 'Notes',
		'people' => 'People',
		'person' => 'Person',
		'personList' => 'Person List',
		'personType' => 'Person Type',
		'phoneNumber' => 'Phone Number',
		'photo' => 'Photo',
		'score' => 'Score',
		'unspecified' => 'unspecified',
		'updatedAt' => 'Updated At',
		'validation' =>  [
			'birth_date' =>  [
				'valid_date' => 'The {field} field must contain a valid date.',

			],

			'country_code' =>  [
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',

			],

			'middle_name' =>  [
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',

			],

			'notes' =>  [
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',

			],

			'person_type' =>  [
				'in_list' => 'The {field} field must be one of: {param}.',

			],

			'phone_number' =>  [
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',

			],

			'score' =>  [
				'decimal' => 'The {field} field must contain a decimal number.',

			],

			'sex' =>  [
				'in_list' => 'The {field} field must be one of: {param}.',

			],

			'email_address' =>  [
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',
				'valid_email' => 'The {field} field must contain a valid email address.',

			],

			'first_name' =>  [
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',
				'required' => 'The {field} field is required.',

			],

			'last_name' =>  [
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',
				'required' => 'The {field} field is required.',

			],


		],


];