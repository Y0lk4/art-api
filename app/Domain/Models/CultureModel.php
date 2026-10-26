<?php

namespace App\Domain\Models;

class CultureModel extends BaseModel
{
    public function getCultures(array $filters): array
    {

        $filter_values = [];
        //Execute SQL Query to read the list of cultures
        $sql = "SELECT * FROM culture WHERE 1";

        $culture_name = $filters["culture_name"] ?? '';
        if (!empty($culture_name)) {
            $sql .= " AND culture_name LIKE CONCAT('%', :culture_name, '%')";
            $filter_values["culture_name"] = $culture_name;
        }

        $region = $filters["region"] ?? '';
        if (!empty($region)) {
            $sql .= " AND region LIKE CONCAT('%', :region, '%')";
            $filter_values["region"] = $region;
        }

        $language_family = $filters["language_family"] ?? '';
        if (!empty($language_family)) {
            $sql .= " AND language_family LIKE CONCAT('%', :language_family, '%')";
            $filter_values["language_family"] = $language_family;
        }

        $continent = $filters["continent"] ?? '';
        if (!empty($continent)) {
            $sql .= " AND continent = :continent";
            $filter_values["continent"] = strtolower($continent);
        }

        if (isset($filters["is_extinct_culture"]) && $filters["is_extinct_culture"] !== '') {
            $sql .= " AND is_extinct_culture = :is_extinct_culture";
            $filter_values["is_extinct_culture"] = filter_var($filters["is_extinct_culture"], FILTER_VALIDATE_BOOL) ? 1 : 0 ;
        }

        $sortBy = $filters['sort'] ?? 'id';
        $order = $filters['order'] ?? 'ASC';

    
        $validOrders = ['asc','desc'];
        $order = strtoupper($order);

        $sortMap = [
            'id'        => 'culture_id',
            'name'      => 'culture_name',
            'region'    => 'region',
            'continent' => 'continent',
            'start'     => 'time_period_start',
            'end'       => 'time_period_end',
            'created'   => 'created_at'
        ];
        if (!array_key_exists($sortBy, $sortMap)) {
            throw new \InvalidArgumentException("Invalid sort field: {$sortBy}");
        }

        if (!in_array(strtolower($order), $validOrders)) {
            throw new \InvalidArgumentException("Invalid sort order: {$order}");
        }
        $actualField = $sortMap[$sortBy] ?? 'id';
       
        $sql .= " ORDER BY {$actualField} {$order}";

        $culture = $this->paginate($sql, $filter_values);

        return $culture;
    }

    public function getCultureById(int $id): array | false
    {
        //Use ? or named placeholders ex. :culture_id
        $sql = "SELECT * FROM culture WHERE culture_id = :culture_id";
        //returns either array or boolean if no result is found
        return $this->fetchSingle($sql, ["culture_id" => $id]);
    }

    public function createCultures(array $cultures)
    {
        $this->insert("culture", $cultures);
    }
}
