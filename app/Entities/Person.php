<?php
namespace App\Entities;

class Person extends GoBaseEntity
{ 
	protected $attributes = [
			'id' => null,
			'first_name' => null,
			'middle_name' => null,
			'last_name' => null,
			'sex' => null,
			'phone_number' => null,
			'email_address' => null,
			'city_id' => null,
			'notes' => null,
			'birth_date' => null,
			'person_type' => null,
			'enabled' => false,
			'score' => null,
			'created_at' => null,
			'updated_at' => null,
		];
	protected $casts = [
			'city_id' => '?int',
			'enabled' => 'boolean',
			'score' => '?float',
		]; 
}