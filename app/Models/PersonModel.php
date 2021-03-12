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
			'notes',
			'birth_date',
			'person_type',
			'enabled',
			'score',
		];
	protected $returnType = 'App\Entities\Person';

	protected $useTimestamps = true;

	protected $createdField  = 'created_at';

	protected $updatedField  = 'updated_at';

	public static $labelField = 'first_name';

	public function findAllWithCities(string $selcols='id, t1.first_name, t1.middle_name, t1.last_name, t1.sex, t1.phone_number, t1.email_address, t1.city_id, t1.notes, t1.birth_date, t1.person_type, t1.enabled, t1.score, t1.created_at, t1.updated_at', int $limit=null, int $offset = 0) { 
		$sql = 'SELECT t1.'.$selcols.',  t2.city_name AS cities_city_name FROM ' . $this->table . ' t1  LEFT JOIN tbl_cities t2 ON t1.city_id = t2.id'; 
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