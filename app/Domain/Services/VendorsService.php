<?php

namespace App\Domain\Services;

use LDAP\Result;

class VendorsService
{
public function __construct(
        private VendorsModel $vendors_model;

) {}
        //$this ->vendors_model = $vendors_model;





        /**
         * Validates and inserts new vendors in to the DB.
         *
         * @param array $new_vendors A list of one or more vendors to be created.
         * @return Result
         */
 public function doCreateVendors(array $new_vendors): Result
 {


//TODO: Use the Valicomb library to validate your new singleton resources/item
//code
// I will ONLY process one item
$new_vendor =_$new_vendor[0];
$last_id= 
        return Result::success("Hanson was able to create some things!");

 }

}
