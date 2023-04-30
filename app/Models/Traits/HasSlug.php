<?php


namespace App\Models\Traits;


trait HasSlug
{
    public function setSlug(array $data) {
        if ( isset($data['data']['name']) && !empty($data['data']['name'])   && ( ! isset($data['data']['slug']) || empty($data['data']['slug'])  )) {
            $data['data']['slug'] = slugify($data['data']['name']);
        } else if (  isset($data['data']['title']) && !empty($data['data']['title'])  && ( ! isset($data['data']['slug']) || empty($data['data']['slug']) )) {
            $data['data']['slug'] = slugify($data['data']['title']);
        } else if (  isset($data['data']['designation']) && !empty($data['data']['designation'])  && ( ! isset($data['data']['slug']) || empty($data['data']['slug']) )) {
            $data['data']['slug'] = slugify($data['data']['designation']);
        }
        return $data;
    }
}