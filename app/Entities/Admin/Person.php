<?php
namespace App\Entities\Admin;

use CodeIgniter\Entity;

class Person extends \CodeIgniter\Entity\Entity
{
    protected $attributes = [
        "id" => null,
        "first_name" => null,
        "middle_name" => null,
        "last_name" => null,
        "sex" => null,
        "phone_number" => null,
        "email_address" => null,
        "city_id" => null,
        "person_type" => null,
        "birth_date" => null,
        "is_friend" => false,
        "notes" => null,
        "enabled" => false,
        "score" => null,
        "created_at" => null,
        "updated_at" => null,
    ];
    protected $casts = [
        "city_id" => "?int",
        "is_friend" => "boolean",
        "enabled" => "boolean",
        "score" => "?float",
    ];
    /**
     * Returns a full name: "first last"
     *
     * @return string
     */
    public function getFullName()
    {
        $fullName =
            (!empty($this->attributes["first_name"]) ? trim($this->attributes["first_name"]) . " " : "") .
            (!empty($this->attributes["last_name"]) ? trim($this->attributes["last_name"]) : "");
        $name = empty($fullName) ? $this->attributes["username"] : $fullName;
        return $name;
    }

    /**
     * Alias for getFullName()
     *
     * @return string
     */
    public function fullName()
    {
        return $this->getFullName();
    }
}
