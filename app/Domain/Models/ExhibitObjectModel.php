<?php

namespace App\Domain\Models;

class ExhibitObjectModel extends BaseModel
{
    //! not to be confused with artifacts, they're the same but this is tied to exhibits, not just the artifact itself
    public function getExhibitObjects(array $filters): array
    {

        $filter_values = [];
        // Execute SQL Query to read the list of vendors.
        $sql = "SELECT * from exhibits WHERE 1";

        $exhibit_id = $filters["exhibit_id"] ?? '';
        $object_id = $filters["object_id"] ?? '';
        $is_featured = $filters["is_featured"] ?? '';
        $tag = $filters["tag"] ?? '';
        $added_after = $filters['added_after'] ?? '';

        $sortBy = $filters['sort'] ?? 'exhibit_id';
        $order = $filters['order'] ?? 'ASC';

        $validOrders = ['asc','desc'];
        $order = strtoupper($order);

        $sortValues = [
            'exhibit_object_id' => 'exhibit_object_id',
            'exhibit_id' => 'exhibit_id',
            'object_id' => 'object_id',
            'display_order' => 'display_order',
            'added_at' => 'added_at',
            'updated_at' => 'updated_at',
        ];

        if (!array_key_exists($sortBy, $sortValues)) {
            throw new \InvalidArgumentException("Invalid sort field: {$sortBy}");
        }

        if (!in_array(strtolower($order), $validOrders)) {
            throw new \InvalidArgumentException("Invalid sort order: {$order}");
        }

        if (!empty($exhibit_id)) {
        $sql .= " AND exhibit_id = :exhibit_id";
        $filter_values["exhibit_id"] = $exhibit_id;
        }

        if (!empty($object_id)) {
            $sql .= " AND object_id = :object_id";
            $filter_values["object_id"] = $object_id;
        }

        if ($is_featured !== '') {
            $sql .= " AND is_featured = :is_featured";
            $filter_values["is_featured"] = $is_featured;
        }

        if (!empty($tag)) {
            $sql .= " AND tag = :tag";
            $filter_values["tag"] = $tag;
        }

        if (!empty($added_after)) {
            $sql .= " AND added_at >= :added_after";
            $filter_values["added_after"] = $added_after;
        }

        $this->setPaginationOptions((int) ($filters["page"] ?? 1), (int) ($filters["page_size"] ?? 10));


        $sql .= " ORDER BY {$sortValues[$sortBy]} {$order}";

        $exhibit_objects = $this->paginate($sql, $filter_values);


        return $exhibit_objects;
    }

    public function getExhibitObjectById(int $id): array | false
    {
        $sql = 'SELECT * FROM exhibit_object WHERE exhibit_object_id = :exhibit_object_id';

        

        //fetchSingle returns mixed, mixed returns an array of boolean
        return $this->fetchSingle(
            $sql,
            [
                "exhibit_object_id" => $id
            ]
        );
    }

    public function getExhibitObjectsByExhibitId(int $id, array $filters): array | false
    {
        // either use ? or named placeholders, named placeholders are preferred cuz its clearer
        $sql = 'SELECT * FROM exhibit_object WHERE exhibit_id = :exhibit_id';

        $filter_values = [
        'exhibit_id' => $id
        ];

        $sortBy = $filters['sort'] ?? 'exhibit_object_id';
        $order = $filters['order'] ?? 'ASC';

        $validOrders = ['asc','desc'];
        $order = strtoupper($order);

        $sortValues = [
            'exhibit_object_id' => 'exhibit_object_id',
            'exhibit_id' => 'exhibit_id',
            'object_id' => 'object_id',
            'display_order' => 'display_order',
            'added_at' => 'added_at',
            'updated_at' => 'updated_at',
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

        return $this->paginate($sql,$filter_values);
    }
}