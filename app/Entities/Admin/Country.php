<?php
namespace App\Entities\Admin;

use CodeIgniter\Entity;

class Country extends \CodeIgniter\Entity\Entity
{
    protected $attributes = [
        "iso_code" => null,
        "country_name" => null,
        "enabled" => true,
        "updated_at" => null,
    ];
    protected $casts = [
        "enabled" => "boolean",
    ];
}
