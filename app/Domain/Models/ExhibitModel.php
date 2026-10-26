<?php

namespace App\Domain\Models;

class ExhibitModel extends BaseModel
{
    //* Add your public methods here.

    public function getExhibits(array $filters): array
    {

        $filter_values = [];
        // Execute SQL Query to read the list of vendors.
        $sql = "SELECT * from exhibits WHERE 1";

        $exhibit_name = $filters["name"] ?? '';
        $visibility = $filters["visibility"] ?? '';
        $location_id = $filters['location_id'] ?? '';
        $created_after = $filters['created_after'] ?? '';
        $views_min = $filters['views_min'] ?? '';
        $views_max = $filters['views_max'] ?? '';

        $sortBy = $filters['sort'] ?? 'exhibit_id';
        $order = $filters['order'] ?? 'ASC';

        $validOrders = ['asc','desc'];
        $order = strtoupper($order);

        $sortValues = [
            'exhibit_id' => 'exhibit_id',
            'location_id' => 'location_id',
            'visibility' => 'visibility',
            'created_at' => 'created_at',
            'view_count' => 'view_count',
            'name' => 'name'
        ];

        if (!array_key_exists($sortBy, $sortValues)) {
            throw new \InvalidArgumentException("Invalid sort field: {$sortBy}");
        }

        if (!in_array(strtolower($order), $validOrders)) {
            throw new \InvalidArgumentException("Invalid sort order: {$order}");
        }

        if (!empty($exhibit_name)) {
            $sql .= " AND name LIKE CONCAT('%', :name, '%')";
            $filter_values["name"] = $exhibit_name;
        }

        if (!empty($visibility)) {
            $sql .= " AND visibility = : visibility";
            $filter_values["visibility"] = $visibility;
        }

        if (!empty($location_id)) {
            $sql .= " AND location_id = :location_id";
            $filter_values["location_id"] = $location_id;
        }

        if (!empty($created_after)) {
            $sql .= " AND created_at >= :created_after";
            $filter_values["created_after"] = $created_after;
        }

        if (!empty($views_min)) {
            $sql .= " AND view_count >= :views_min";
            $filter_values["views_min"] = $views_min;
        }

        if (!empty($views_max)) {
            $sql .= " AND view_count <= :views_max";
            $filter_values["views_max"] = $views_max;
        }

        $this->setPaginationOptions((int) ($filters["page"] ?? 1), (int) ($filters["page_size"] ?? 10));


        $sql .= " ORDER BY {$sortValues[$sortBy]} {$order}";

        $exhibits = $this->paginate($sql, $filter_values);


        return $exhibits;
    }

    public function getExhibitById(int $id): array | false
    {
        // either use ? or named placeholders, named placeholders are preferred cuz its clearer
        $sql = 'SELECT * FROM exhibits WHERE exhibit_id = :exhibit_id';

        

        //fetchSingle returns mixed, mixed returns an array of boolean
        return $this->fetchSingle(
            $sql,
            [
                "exhibit_id" => $id
            ]
        );
    }

    public function getExhibitsByLocationId(int $id, array $filters): array | false
    {
        // either use ? or named placeholders, named placeholders are preferred cuz its clearer
        $sql = 'SELECT * FROM exhibits WHERE location_id = :location_id';

        $sortBy = $filters['sort'] ?? 'exhibit_id';
        $order = $filters['order'] ?? 'ASC';

        $validOrders = ['asc','desc'];
        $order = strtoupper($order);

        $sortValues = [
            'exhibit_id' => 'exhibit_id',
            'location_id' => 'location_id',
            'visibility' => 'visibility',
            'created_at' => 'created_at',
            'view_count' => 'view_count',
            'name' => 'name'
        ];

        if (!array_key_exists($sortBy, $sortValues)) {
            throw new \InvalidArgumentException("Invalid sort field: {$sortBy}");
        }

        if (!in_array(strtolower($order), $validOrders)) {
            throw new \InvalidArgumentException("Invalid sort order: {$order}");
        }

        //fetchSingle returns mixed, mixed returns an array of boolean
        $this->setPaginationOptions((int) ($filters["page"] ?? 1), (int) ($filters["page_size"] ?? 10));

        $sql .= " ORDER BY {$sortValues[$sortBy]} {$order}";

        return $this->paginate($sql);
    }

    public function createExhibit(array $exhibit)
    {
        return $this->insert("exhibits", $exhibit);
    }
}
