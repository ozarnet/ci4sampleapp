<?php


namespace App\Models;


class Collection
{
    /**
     * Return data to colection map datatable.
     *
     * @param array $data
     * @param int   $recordsTotal
     * @param int   $recordsFiltered
     *
     * @return array
     */
    public static function datatable(array $data, int $recordsTotal, int $recordsFiltered, string $error = null)
    {
        $draw = 1;
        $req = service('request');
        if (!empty($req->getPostGet('data'))) :
            $reqData = $req->getPostGet('data');
            $draw = $reqData['draw'];
        elseif (!empty($req->getPostGet('draw'))) :
            $draw = $req->getPostGet('draw');
        endif;

        $response = [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
            'token'           => csrf_hash(), // in case the CSRF token is regenerated
        ];

        if (!empty($error)) {
            $response['error'] = $error;
        }

        return $response;
    }
}