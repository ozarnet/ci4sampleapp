<?php
namespace App\Models\Admin;

class CountryModel extends \App\Models\GoBaseModel
{
    protected $table = "tbl_countries";

    /**
     * Whether primary key uses auto increment.
     *
     * @var bool
     */
    protected $useAutoIncrement = false;

    protected $primaryKey = "iso_code";

    const SORTABLE = [
        1 => "t1.iso_code",
        2 => "t1.country_name",
        3 => "t1.enabled",
        4 => "t1.updated_at",
    ];

    protected $allowedFields = ["iso_code", "iso_code", "country_name", "enabled"];
    protected $returnType = "App\Entities\Admin\Country";

    public static $labelField = "country_name";

    protected $validationRules = [
        "country_name" => [
            "label" => "Countries.countryName",
            "rules" => "trim|required|max_length[60]",
        ],
        "iso_code" => [
            "label" => "Countries.isoCode",
            "rules" => "trim|required|max_length[2]",
        ],
    ];

    protected $validationMessages = [
        "country_name" => [
            "is_unique" => "Countries.validation.country_name.is_unique",
            "max_length" => "Countries.validation.country_name.max_length",
            "required" => "Countries.validation.country_name.required",
        ],
        "iso_code" => [
            "is_unique" => "Countries.validation.iso_code.is_unique",
            "max_length" => "Countries.validation.iso_code.max_length",
            "required" => "Countries.validation.iso_code.required",
        ],
    ];

    /**
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = "")
    {
        $builder = $this->db
            ->table($this->table . " t1")
            ->select(
                "t1.iso_code AS iso_code, t1.country_name AS country_name, t1.enabled AS enabled, t1.updated_at AS updated_at"
            );

        return empty($search)
            ? $builder
            : $builder
                ->groupStart()
                ->like("t1.iso_code", $search)
                ->orLike("t1.country_name", $search)
                ->orLike("t1.updated_at", $search)
                ->orLike("t1.iso_code", $search)
                ->orLike("t1.country_name", $search)
                ->orLike("t1.updated_at", $search)
                ->groupEnd();
    }
}
