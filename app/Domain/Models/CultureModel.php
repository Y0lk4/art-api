<?php

namespace App\Domain\Models;

class CultureModel extends BaseModel
{
    /*public function createCultures(array $filters): array
    {
        $filter_values = [];
        //Execute SQL Query to read the list of keyboards
        $sql = "SELECT * FROM keyboards WHERE 1";

        $keyboard_name = $filters["name"] ?? '';

        if (!empty($keyboard_name)) {
            $sql .= " AND name LIKE CONCAT('%', :name, '%')";
            $filter_values["name"] = $keyboard_name;
        }
        $keyboard = $this->paginate($sql, $filter_values);

        return $keyboard;
    }

    public function getKeyboardById(int $id): array | false
    {
        //Use ? or named placeholders ex. :keyboard_id
        $sql = "SELECT * FROM keyboards WHERE keyboard_id = :keyboard_id";
        //returns either array or boolean if no result is found
        return $this->fetchSingle($sql, ["keyboard_id" => $id]);
    }
    public function getCasesByKeyboardId(int $keyboardId): array
    {
        $sql = "SELECT * FROM cases WHERE keyboard_id = :keyboard_id";
        return $this->fetchAll($sql, ["keyboard_id" => $keyboardId]);
    }*/

    public function createCultures(array $cultures)
    {
        $this->insert("cultures", $cultures);
    }
}
