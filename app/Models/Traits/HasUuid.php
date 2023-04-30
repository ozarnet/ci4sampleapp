<?php


namespace App\Models\Traits;


trait HasUuid
{

    public function setNewUUID(array $data) {

        if (! isset($data['data']['uuid']) || empty($data['data']['uuid'])) {
            $data['data']['uuid'] = newUUID();
        }

        return $data;

    }
}