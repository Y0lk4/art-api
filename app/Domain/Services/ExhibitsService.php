<?php

namespace App\Domain\Services;

use App\Domain\Models\ExhibitModel;
use App\Helpers\Core\Result;

class ExhibitsService extends BaseService
{

    public function __construct(private ExhibitModel $exhibit_model) {}

    /**
     * validates and inserts exhibits into the database
     *
     * @param array $exhibits the exhibits array to be added into the database
     * @return Result
     */
    public function doCreateExhibit(array $exhibits): Result
    {
        //do shit
        //TODO: use the Valicomb lib to validate the singleton resources/items.
        // I will process ONLY 1 item.
        $exhibits = $exhibits[0];

        $last_id = $this->$exhibits->createExhibit();
        return Result::success('ur mom');
    }
}
