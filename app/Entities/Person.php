<?php
namespace App\Entities;

class Person extends GoBaseEntity
{ 
	protected $attributes = [
			'id' => null,
			'first_name' => null,
			'middle_name' => null,
			'last_name' => null,
			'phone_number' => null,
			'email_address' => null,
			'country_code' => null,
			'city_id' => null,
			'birth_date' => null,
			'is_friend' => false,
			'created_at' => null,
			'updated_at' => null,
			'notes' => null,
			'photo' => null,
			'enabled' => false,
			'score' => null,
		];
	protected $casts = [
			'city_id' => 'int',
			'is_friend' => 'boolean',
			'enabled' => 'boolean',
			'score' => 'float',
		]; 
}