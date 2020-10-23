<?php
namespace App\Models;

class PersonModel extends GoBaseModel
{
    protected $table = 'tbl_people';
 
	protected $allowedFields = [
			'first_name',
			'middle_name',
			'last_name',
			'sex',
			'phone_number',
			'email_address',
			'city_id',
			'person_type',
			'birth_date',
			'is_friend',
			'notes',
			'enabled',
			'score',
			'created_at',
			'updated_at',
		];
	protected $returnType = 'App\Entities\Person';

	protected $useTimestamps = true;

	public static $labelField = 'first_name';

	public function findAllWithCities(string $selcols='*', int $limit=null, int $offset = 0) { 
		$sql = 'SELECT t1.'.$selcols.',  t2.city_name AS city_name FROM ' . $this->table . ' t1  LEFT JOIN tbl_cities t2 ON t1.city_id = t2.id'; 
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