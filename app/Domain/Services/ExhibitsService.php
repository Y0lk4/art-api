<?php

namespace App\Domain\Services;

use App\Domain\Models\ExhibitModel;
use App\Helpers\Core\Result;

class ExhibitsService extends BaseService
{

    public function __construct(private ExhibitModel $exhibit_model) {}
    

    public function enrichExhibitWithCountryDate(array $exhibit): array
    {
        $countryCode = $exhibit['country_code'] ?? 'CA';

        $url = "https://api.restcountries.com/countries/v5/codes.gec/" . $countryCode;
        $apiKey = $_ENV['REST_COUNTRIES_API_KEY'] ?? "YOUR_REST_COUNTRIES_API_KEY";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$apiKey}",
        "Accept: application/json"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpCode === 200 && $response){
            $countryData = json_decode($response, true);
            $exhibit['currency'] = $countryData['currencies'] ?? [];
            $exhibit['timezones'] = $countryData['timezones'] ?? [];
        }

        return $exhibit;
    }
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
