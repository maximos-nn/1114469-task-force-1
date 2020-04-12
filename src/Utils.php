<?php

namespace TaskForce;

class Utils
{
    public static function validateStringArray(array $array): bool
    {
        if (!count($array)) {
            return false;
        }
        foreach ($array as $item) {
            if (!is_string($item)) {
                return false;
            }
        }
        return true;
    }
}
