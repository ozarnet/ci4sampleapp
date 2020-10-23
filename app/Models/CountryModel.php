<?php
namespace App\Models;

class CountryModel extends GoBaseModel
{
    protected $table = 'tbl_countries';
 
	protected $primaryKey = 'iso_code';


	protected $allowedFields = [
			'iso_code',
			'country_name',
			'enabled',
		];
	protected $returnType = 'App\Entities\Country';

	public static $labelField = 'country_name';
 
}