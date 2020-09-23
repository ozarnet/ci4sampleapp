<?php
namespace App\Models;

class PersonModel extends GoBaseModel
{
    protected $table = 'tbl_people';
 
	protected $allowedFields = [
			'first_name',
			'middle_name',
			'last_name',
			'phone_number',
			'email_address',
			'country_code',
			'city_id',
			'birth_date',
			'is_friend',
			'created_at',
			'updated_at',
			'notes',
			'photo',
			'enabled',
			'score',
		];
	protected $returnType = 'App\Entities\Person';

	protected $useTimestamps = true;

	public static $labelField = 'first_name';

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

	public function findAllWithCities(string $selcols='*', int $limit=null, int $offset = 0) { 
		$sql = 'SELECT t1.'.$selcols.',  t3.city_name AS city_name FROM ' . $this->table . ' t1  LEFT JOIN tbl_cities t3 ON t1.city_id = t3.id'; 
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
	public function findAllWithAllRelations(string $selcols='*', int $limit=null, int $offset = 0) { 
		$sql = 'SELECT t1.'.$selcols.',  t2.country_name AS country_name,  t3.city_name AS city_name FROM ' . $this->table . ' t1  LEFT JOIN tbl_countries t2 ON t1.country_code = t2.iso_code LEFT JOIN tbl_cities t3 ON t1.city_id = t3.id';
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