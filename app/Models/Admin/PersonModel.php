<?php
namespace App\Models\Admin;

class PersonModel extends \App\Models\GoBaseModel
{
    protected $table = "tbl_people";

    /**
     * Whether primary key uses auto increment.
     *
     * @var bool
     */
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        "first_name",
        "middle_name",
        "last_name",
        "sex",
        "phone_number",
        "email_address",
        "city_id",
        "person_type",
        "birth_date",
        "is_friend",
        "notes",
        "enabled",
        "score",
    ];
    protected $returnType = "App\Entities\Admin\Person";

    public static $labelField = "email_address";

    protected $validationRules = [
        "birth_date" => [
            "label" => "People.birthDate",
            "rules" => "valid_date|permit_empty",
        ],
        "email_address" => [
            "label" => "People.emailAddress",
            "rules" => "trim|max_length[50]|valid_email|permit_empty",
        ],
        "first_name" => [
            "label" => "People.firstName",
            "rules" => "trim|required|max_length[40]",
        ],
        "last_name" => [
            "label" => "People.lastName",
            "rules" => "trim|required|max_length[50]",
        ],
        "middle_name" => [
            "label" => "People.middleName",
            "rules" => "trim|max_length[40]",
        ],
        "notes" => [
            "label" => "People.notes",
            "rules" => "trim|max_length[16313]",
        ],
        "person_type" => [
            "label" => "People.personType",
            "rules" => "permit_empty|in_list[unspecified,colleague,employee,customer,friend]",
        ],
        "phone_number" => [
            "label" => "People.phoneNumber",
            "rules" => "trim|max_length[20]",
        ],
        "score" => [
            "label" => "People.score",
            "rules" => "decimal|permit_empty",
        ],
        "sex" => [
            "label" => "People.gender",
            "rules" => "trim|permit_empty|in_list[F,M,N,U]",
        ],
    ];

    protected $validationMessages = [
        "birth_date" => [
            "valid_date" => "People.validation.birth_date.valid_date",
        ],
        "email_address" => [
            "max_length" => "People.validation.email_address.max_length",
            "valid_email" => "People.validation.email_address.valid_email",
        ],
        "first_name" => [
            "max_length" => "People.validation.first_name.max_length",
            "required" => "People.validation.first_name.required",
        ],
        "last_name" => [
            "max_length" => "People.validation.last_name.max_length",
            "required" => "People.validation.last_name.required",
        ],
        "middle_name" => [
            "max_length" => "People.validation.middle_name.max_length",
        ],
        "notes" => [
            "max_length" => "People.validation.notes.max_length",
        ],
        "person_type" => [
            "in_list" => "People.validation.person_type.in_list",
        ],
        "phone_number" => [
            "max_length" => "People.validation.phone_number.max_length",
        ],
        "score" => [
            "decimal" => "People.validation.score.decimal",
        ],
        "sex" => [
            "in_list" => "People.validation.sex.in_list",
        ],
    ];

    public function findAllWithCities(string $selcols = "*", int $limit = null, int $offset = 0)
    {
        $sql =
            "SELECT t1." .
            $selcols .
            ",  t2.city_name AS city FROM " .
            $this->table .
            " t1  LEFT JOIN tbl_cities t2 ON t1.city_id = t2.id";
        if (!is_null($limit) && intval($limit) > 0) {
            $sql .= " LIMIT " . $limit;
        }

        if (!is_null($offset) && intval($offset) > 0) {
            $sql .= " OFFSET " . $offset;
        }

        $query = $this->db->query($sql);
        $result = $query->getResultObject();
        return $result;
    }
}
