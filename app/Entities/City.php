<?php
namespace App\Entities;

class City extends GoBaseEntity
{ 
	protected $attributes = [
			'id' => null,
			'city_name' => null,
			'country_code' => null,
			'enabled' => false,
		];
	protected $casts = [
			'enabled' => 'boolean',
		]; 
}