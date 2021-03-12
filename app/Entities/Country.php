<?php
namespace App\Entities;

class Country extends GoBaseEntity
{ 
	protected $attributes = [
			'iso_code' => null,
			'country_name' => null,
			'enabled' => 1,
			'updated_at' => null,
		];
	protected $casts = [
			'enabled' => 'int',
		]; 
}