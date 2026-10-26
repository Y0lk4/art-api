<?php

namespace App\Domain\Models;

class ArtistModel extends BaseModel
{
    /**
     * Gets artists using filters and sorting.
     *
     * @param array $filters Filters to apply.
     * @return mixed List of artists.
     */
    public function getArtists(array $filters)
    {
        $filter_values = [];

        $sql = "SELECT * FROM artist WHERE 1";

        $full_name = $filters["full_name"] ?? '';
        if (!empty($full_name)) {
            $sql .= " AND full_name LIKE CONCAT('%', :full_name, '%')";
            $filter_values["full_name"] = $full_name;
        }

        $display_name = $filters["display_name"] ?? '';
        if (!empty($display_name)) {
            $sql .= " AND display_name LIKE CONCAT('%', :display_name, '%')";
            $filter_values["display_name"] = $display_name;
        }

        $nationality = $filters["nationality"] ?? '';
        if (!empty($nationality)) {
            $sql .= " AND nationality LIKE CONCAT('%', :nationality, '%')";
            $filter_values["nationality"] = $nationality;
        }

        $birth_date = $filters["birth_date"] ?? '';
        if (!empty($birth_date)) {
            $sql .= " AND birth_date = :birth_date";
            $filter_values["birth_date"] = $birth_date;
        }

        $death_date = $filters["death_date"] ?? '';
        if (!empty($death_date)) {
            $sql .= " AND death_date = :death_date";
            $filter_values["death_date"] = $death_date;
        }

        $gender = $filters["gender"] ?? '';
        if (!empty($gender)) {
            $sql .= " AND gender = :gender";
            $filter_values["gender"] = $gender;
        }

        $sortBy = $filters['sort'] ?? 'artist_id';
        $order = $filters['order'] ?? 'ASC';

        $validOrders = ['asc','desc'];
        $order = strtoupper($order);

        $sortMap = [
            'artist_id' => 'artist_id',
            'full_name' => 'full_name',
            'display_name' => 'display_name',
            'nationality' => 'nationality',
            'birth_date' => 'birth_date',
            'death_date' => 'death_date',
            'gender' => 'gender'
        ];

        if (!array_key_exists($sortBy, $sortMap)) {
            throw new \InvalidArgumentException("Invalid sort field: {$sortBy}");
        }

        if (!in_array(strtolower($order), $validOrders)) {
            throw new \InvalidArgumentException("Invalid sort order: {$order}");
        }

        $sql .= " ORDER BY {$sortMap[$sortBy]} {$order}";

        $artists = $this->paginate($sql, $filter_values);

        return $artists;
    }

    /**
     * Gets an artist by ID.
     *
     * @param int $id Artist ID.
     * @return array|false Artist data or false.
     */
    public function getArtistById(int $id): array | false
    {
        $sql = "SELECT * FROM artist WHERE artist_id = :artist_id";
        return $this->fetchSingle($sql, [':artist_id' => $id]);
    }

    /**
     * Adds a new artist.
     *
     * @param array $artist Artist data.
     * @return void
     */
    public function createArtist(array $artist)
    {
        $this->insert('artist', $artist);
    }
}