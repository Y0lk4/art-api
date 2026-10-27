<?php

namespace App\Domain\Services;

use App\Domain\Models\ArtistModel;
use App\Helpers\Core\Result;

class ArtistService
{
    public function __construct(private ArtistModel $artist_model) {}


    /**
     * Validates and inserts new artists into the database
     * @param array $new_artists
     * @return Result
     */
    public function doCreateArtists(array $new_artists): Result
    {
        //TODO: Use the Valicomb library to validate the singleton reosurces
        return Result::success("balright");
    }
}
