<?php

declare(strict_types=1);

namespace App\Domain\Services;

use Frostybee\Valicomb\Validator;

/**
 * Base service class for all services.
 *
 * This class provides a base implementation for all services.
 * It is intended to be extended by specific service classes.
 */
abstract class BaseService
{

    private ?Validator $v = null;
    //*NOTES: This class is not used yet. It is a placeholder for future services.
    //*NOTES: Here, you can define common methods for all services such as logging, validation, etc.
    public function __construct()
    {
        $this->v = new Validator([]);
    }

    public function validateInteger(array $data)
    {
        $this->v->withData($data);
        $this->v->rule('required', 'integer');
    }

    public function validateRange(array $data, int $min, int $max)
    {
        $this->v->withData($data);
        $this->v->rule('between', [$min, $max]);
    }

    public function validateDate(array $data, string $date)
    {
        $this->v->withData($data);
        $this->v->rule('date', $date);
    }

    /**
     * Verifies if a data is in the array given
     * @param array $data the data that we are validating
     * @param array $array the array we are looking into to validate if the data is equal to a value in the array
     * @return bool
     * For example:
     *      data given: banana
     *      array: [banana, apple, grapes]
     *      returns true;
     */
    public function isInArray(array $data, array $array): bool
    {
        //how to make it not case sensitive
        $this->v->withData($data);
        $this->v->rule('in', $array);
        if ($this->v->validate()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Summary of validateBoolean
     * @param array $data the data that we need to validate
     * @param string $dataName the name of the data that is supposed to be a boolean
     * @return void
     */
    public function validateBoolean(array $data, string $dataName)
    {
        $this->v->withData($data);
        $this->v->rule('boolean', $dataName);
    }
}
