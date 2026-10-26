<?php

namespace App\Domain\Services;

use App\Domain\Models\CultureModel;
use App\Helpers\Core\Result;

class CulturesService
{
    public function __construct(private CultureModel $cultures_model) {}


    /**
     * Validates and inserts new cultures into the database
     * @param array $new_cultures
     * @return Result
     */
    public function doCreateCultures(array $new_cultures): Result
    {
        //TODO: Use the Valicomb library to validate your new singleton resource
        return Result::success("Creation Successful!");
    }
}
