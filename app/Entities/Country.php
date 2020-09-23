<?php
namespace App\Entities;

class Country extends GoBaseEntity
{ 
	protected $attributes = [
			'iso_code' => null,
			'country_name' => null,
			'enabled' => true,
		];
	protected $casts = [
			'enabled' => 'boolean',
		]; 
}