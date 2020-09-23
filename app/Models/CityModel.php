<?php
namespace App\Models;

class CityModel extends GoBaseModel
{
    protected $table = 'tbl_cities';
 
	protected $allowedFields = [
			'city_name',
			'country_code',
			'enabled',
		];
	protected $returnType = 'App\Entities\City';

	public static $labelField = 'city_name';

	public function findAllWithCountries(string $selcols='*', int $limit=null, int $offset = 0) { 
		$sql = 'SELECT t1.'.$selcols.',  t2.country_name AS country_name FROM ' . $this->table . ' t1  LEFT JOIN tbl_countries t2 ON t1.country_code = t2.iso_code'; 
		if (!is_null($limit) && intval($limit) > 0) {
			$sql .= ' LIMIT ' . intval($limit);
		}

		if (!is_null($offset) && intval($offset) > 0) {
			$sql .= ' OFFSET ' . intval($offset);
		}

		$query = $this->db->query($sql);
		$result = $query->getResultObject();
		return $result;
	}
 
}