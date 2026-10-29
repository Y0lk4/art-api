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
    //*NOTES: Here, you can define common methods for all services such as logging, validation, etc.
    public function __construct()
    {
        $this->v = new Validator([]);
    }
    /**
     * Summary of validateInteger
     * @param array $data
     * @return void
     */
    public function validateID(array $data, string $parameterName, string $idName): bool | array
    {
        $this->v->withData($data);
        $this->v->rule('required', $parameterName, $idName)
            ->rule('integer', $parameterName, $idName);

        if ($this->v->validate()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Summary of validateRange
     * @param array $data
     * @param int $min
     * @param int $max
     * @return void
     */
    public function validateRange(array $data, string $parameterName, int $min, int $max): bool | array
    {
        $this->v->withData($data);
        $this->v->rule('between', $parameterName, [$min, $max]);

        if ($this->v->validate()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Summary of validateDate
     * @param array $data
     * @param string $date
     * @return void
     */
    public function validateDate(array $data, string $parameterName, string $date): bool | array
    {
        $this->v->withData($data);
        $this->v->rule('date', $parameterName, $date);

        if ($this->v->validate()) {
            return true;
        } else {
            return false;
        }
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
    public function isInArray(array $data, string $parameterName, array $array): bool | array
    {
        //how to make it not case sensitive
        $this->v->withData($data);
        $this->v->forFields([
            $parameterName => [[
                'in',
                $array,
                'ignoreCase' => true
            ]],
        ]);
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
    public function validateBoolean(array $data, string $parameterName, string $bool): bool | array
    {
        $this->v->withData($data);
        $this->v->rule('boolean', $parameterName, $bool);
        if ($this->v->validate()) {
            return true;
        } else {
            return false;
        }
    }
}
