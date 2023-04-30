<?php

namespace App\Entities;

/**
 * Base Entity Class for providing common methods to all child entities
 *
 * @author Gökhan Ozar
 */
abstract class GoBaseEntity extends \CodeIgniter\Entity\Entity
{
    /**
     * Merges the current object's property values with the passed in arguments in array format
     *
     * @param array $args - an associative array of properties to be set
     * @return $this - returns the current object instance
     */
    public function mergeAttributes(array $args = []) {
        foreach ($args as $key => $value) {
            if (isset($this->attributes[$key])) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }
}