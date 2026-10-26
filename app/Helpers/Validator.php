<?php

namespace App\Helpers;

class Validator
{
    public static function isPositiveInt(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) !== false; 
        // filter var returns a number if true else it returns false, !== false is to make sure it returns true once its true instead of number.
    }

    public static function isInArray(string $value, array $allowed): bool 
    {
        return in_array($value, $allowed, true);
    }

    public static function isBoolean(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
        // !== makes it so it strictly returns false and not null, 
        // if something is unrecognize in this filter, it would just return null and not false
        // so !== enforces the false
    }

    public static function isIsoDate(string $value) : bool 
    {
        // i am to understand there's another cleaner way thats better but i didn't understand it so i didn't do it ~jonathan
        $timestamp = strtotime($value);

        if ($timestamp === false)
            {
                return false;
            }

        return true;
    }
}