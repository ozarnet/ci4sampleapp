<?php
namespace App\Models;

class CityModel extends GoBaseModel
{
    protected $table = 'tbl_cities';
 
	const SORTABLE = [
			1 => 't1.id',
			2 => 't1.city_name',
			3 => 't1.country_code',
			4 => 't1.enabled',
			5 => 't1.updated_at',
			6 => 't2.country_name',

		];


	protected $allowedFields = [
			'city_name',
			'country_code',
			'enabled',
		];
	protected $returnType = 'App\Entities\City';

	protected $useTimestamps = true;

	protected $updatedField  = 'updated_at';

	protected $createdField  = null;

	public static $labelField = 'city_name';

	public function findAllWithCountries(string $selcols='*', int $limit=null, int $offset = 0) { 
		$sql = 'SELECT t1.'.$selcols.',  t2.country_name AS countries_country_name FROM ' . $this->table . ' t1  LEFT JOIN tbl_countries t2 ON t1.country_code = t2.iso_code'; 
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


	/**
	* Get resource data.
	*
	* @param string $search
	*
	* @return \CodeIgniter\Database\BaseBuilder
	*/
	public function getResource(string $search = '')
	{
		$builder = $this->db->table($this->table.' t1')
				 ->select('t1.id AS id, t1.city_name AS city_name, t1.enabled AS enabled, t1.updated_at AS updated_at, t2.country_name AS countries_country_name');
		$builder->join('tbl_countries t2', 't1.country_code = t2.iso_code', 'left');

		return empty($search)
		    ? $builder
		    : $builder->groupStart()
				->like('t1.id', $search)
				->orLike('t1.city_name', $search)
				->orLike('t1.updated_at', $search)
				->orLike('t2.iso_code', $search)
				->orLike('t1.id', $search)
				->orLike('t1.city_name', $search)
				->orLike('t1.country_code', $search)
				->orLike('t1.updated_at', $search)
				->orLike('t2.country_name', $search)
		->groupEnd();
	} 
}