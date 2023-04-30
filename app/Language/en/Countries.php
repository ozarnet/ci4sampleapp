<?php



return [
		'active' => 'Active',
		'countries' => 'Countries',
		'country' => 'Country',
		'countryList' => 'Country List',
		'countryName' => 'Country Name',
		'deletedAt' => 'Deleted At',
		'enabled' => 'Enabled',
		'isoCode' => 'ISO Code',
		'moduleTitle' => 'Countries',
		'updatedAt' => 'Updated At',
		'validation' =>  [
			'country_name' =>  [
				'is_unique' => 'The {field} field must contain a unique value',
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',
				'required' => 'The {field} field is required.',

			],

			'iso_code' =>  [
				'is_unique' => 'The {field} field must contain a unique value',
				'max_length' => 'The {field} field cannot exceed {param} characters in length.',
				'required' => 'The {field} field is required.',

			],


		],


];