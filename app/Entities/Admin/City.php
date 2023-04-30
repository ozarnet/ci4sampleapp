<?php
namespace App\Entities\Admin;

use CodeIgniter\Entity;

class City extends \CodeIgniter\Entity\Entity
{
    protected $attributes = [
        "id" => null,
        "country_code" => null,
        "city_name" => null,
        "enabled" => false,
        "updated_at" => null,
    ];
    protected $casts = [
        "enabled" => "boolean",
    ];
}
