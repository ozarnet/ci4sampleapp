<?php
namespace App\Entities;

class City extends GoBaseEntity
{ 
	protected $attributes = [
			'id' => null,
			'city_name' => null,
			'country_code' => null,
			'enabled' => false,
			'updated_at' => null,
		];
	protected $casts = [
			'enabled' => 'boolean',
		]; 
}