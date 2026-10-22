<?php
//* GET /keyboards (web resource)
//* Return the list of ALL vendors stored in the DB
//TODO: Implement a callback method

public function handleCreateArt(

        request $request,
        Response $response
): Response {


//*1) Get/retrieve the representation of the collection to be created.
//TODO: Check the NULL edge case
$payload = $request->getParsedBody();
json_decode()

//dd($payload);
//*2 Pass the new items to be created to the service so that they can be validated and inserted into database
$result= $this->vendors_services->doCreateVendors($payload);

if($result->isSuccess()) {

//TODO: prepare AND return a JSON error response.

}
//TODO: prepare AND return a JSON success response.
//echo "Kawkalaken!";
return $response;



}

$data = [

            "code" => 400,
            "message" => "Hanson list of vendors were created avec success!",
];


















