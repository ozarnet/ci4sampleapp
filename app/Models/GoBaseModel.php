<?php

/*
    The MIT License (MIT)

    Copyright (c) 2020 Gökhan Ozar (https://gokhan.ozar.net/)

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"),
    to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
    and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
    INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
    IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
    WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of GoBaseModel
 *
 * @author Gökhan Ozar
 */
abstract class GoBaseModel extends Model {

    /**
     * The name of the field (attribute) in this model which will be used to refer to as a human-friendly object name
     */
    public static $labelField;

    /**
     * Returns the model's DB table name
     * 
     * @return string
     */
    public function getDbTableName() {
        return $this->table;
    }
    
    /**
     * Returns the model's DB table name (Alias of getDbTableName() )
     * 
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }
    
    /**
     * Returns the model's name of primary key in the database
     * 
     * @return string
     */
    public function getPrimaryKeyName() {
        return $this->primaryKey;
    }

    /**
     * Returns the number of rows in the database table
     *
     * @return int
     */
    public function getCount() {
        $name = filter_var($this->table, FILTER_SANITIZE_STRING);
        $count = $this->db->table($name)->countAll();
        return $count;
    }

    /**
     * @param string $columns2select
     * @param string $resultSorting
     * @param bool $onlyActiveOnes
     * @param bool $alsoDeletedOnes
     * @param array $additionalConditions
     * @return array
     */
    public function getAllForMenu($columns2select='*', $resultSorting='id', bool $onlyActiveOnes=false, bool $alsoDeletedOnes=true, $additionalConditions = []) {

        $theseConditionsAreMet = [];

        if ($onlyActiveOnes) {
            if ( in_array('enabled', $this->allowedFields) ) {
                $theseConditionsAreMet['enabled'] = true;
            } elseif (in_array('active', $this->allowedFields)) {
                $theseConditionsAreMet['active'] = true;
            }
        }

        // This check is deprecated and left here only for backward compatibility and this method should be overridden in extending classes so as to check if the bound entity class has these attributes
        if (!$alsoDeletedOnes) {
            if (in_array('deleted_at', $this->allowedFields)) {
                $theseConditionsAreMet['deleted_at'] = null;
            }
            if (in_array('deleted', $this->allowedFields) ) {
                $theseConditionsAreMet['deleted'] = false;
            }
            if (in_array('date_time_deleted', $this->allowedFields)) {
                $theseConditionsAreMet['date_time_deleted'] = null;
            }
        }

        if (!empty($additionalConditions)) {
            $theseConditionsAreMet = array_merge($theseConditionsAreMet, $additionalConditions);
        }
        $queryBuilder = $this->db->table($this->table);
        $queryBuilder->select($columns2select);
        if (!empty($theseConditionsAreMet)) {
            $queryBuilder->where($theseConditionsAreMet);
        }
        $queryBuilder->orderBy($resultSorting);
        $result =  $queryBuilder->get()->getResult();

        return $result;
    }

    /**
     * 
     * @param mixed $columns2select either array or string
     * @param mixed $sortResultsBy  either string or array
     * @param bool $onlyActiveOnes
     * @param string $select1str e.g. 'Please select one...'
     * @param bool $alsoDeletedOnes
     * @param array $additionalConditions
     * @return array for use in dropdown menus
     */
    public function getAllForCiMenu( $columns2select = ['id', 'designation'], $sortResultsBy = 'id', bool $onlyActiveOnes=false, $selectionRequestLabel = 'Please select one...',  bool $alsoDeletedOnes = true, $additionalConditions = []) {

        $ciDropDownOptions = [];

        if (is_array($columns2select) && count($columns2select) >= 2) {

            $key = $columns2select[0];
            $val = $columns2select[1];

            $cols2selectStr = implode(',', $columns2select);
            
            $valInd = strpos($val, ' AS ');
            if ($valInd !== false) {
                $val = substr($val, $valInd+4);
            }
            
        } elseif (is_string($columns2select) && strpos($columns2select,',')!==false) {
            
            $cols2selectStr = $columns2select;
            
            $arr = explode(",", $columns2select, 2);
            $key = trim($arr[0]);
            $val = trim($arr[1]);
            
        } else {
            return ['error'=>'Invalid argument for columns/fields to select'];
        }
        
        $resultList = $this->getAllForMenu($cols2selectStr, $sortResultsBy, $onlyActiveOnes, $alsoDeletedOnes, $additionalConditions);

        if ($resultList != false) {
            
            if (!empty($selectionRequestLabel)) {
                $ciDropDownOptions[''] = $selectionRequestLabel;
            }

            foreach ($resultList as $res) {

                if (isset($res->$key) && isset($res->$val)) {
                    $ciDropDownOptions[$res->$key] = $res->$val;
                }
            }
        }

        return $ciDropDownOptions;
    }

}
