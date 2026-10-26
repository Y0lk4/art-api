<?php

declare(strict_types=1);

namespace App\Domain\Models;

class ArtModel extends BaseModel
{
    public const SORT_FIELDS = ['title', 'start_year', 'end_year', 'acquisition_date', 'created_at'];

    private const COLUMNS = 'object_id, title, object_name, department_id, culture_id, period_id, medium_id, '
        . 'object_date, start_year, end_year, height_cm, width_cm, credit_line, is_highlight, '
        . 'is_public_domain, acquisition_date, rights_and_reproduction, created_at, updated_at';

    public function getArtifacts(array $filters, string $sort, int $limit, int $offset): array
    {
        $descending = str_starts_with($sort, '-');
        $sort_field = $descending ? substr($sort, 1) : $sort;
        if (!in_array($sort_field, self::SORT_FIELDS, true)) {
            throw new \InvalidArgumentException('Invalid sort field.');
        }

        $sql = 'SELECT ' . self::COLUMNS . ' FROM artifact WHERE 1 = 1';
        $values = [];
        if (array_key_exists('title', $filters)) {
            $sql .= ' AND INSTR(LOWER(title), LOWER(:title)) > 0';
            $values['title'] = $filters['title'];
        }
        foreach (['department_id', 'culture_id', 'start_year', 'is_public_domain'] as $field) {
            if (array_key_exists($field, $filters)) {
                $sql .= ' AND ' . $field . ' = :' . $field;
                $values[$field] = $filters[$field];
            }
        }

        $sql .= ' ORDER BY ' . $sort_field . ($descending ? ' DESC' : ' ASC') . ', object_id ASC';
        $sql .= ' LIMIT :limit OFFSET :offset';
        $values['limit'] = $limit;
        $values['offset'] = $offset;

        return $this->fetchAll($sql, $values);
    }

    public function getArtifactById(int $object_id): array|false
    {
        return $this->fetchSingle(
            'SELECT ' . self::COLUMNS . ' FROM artifact WHERE object_id = :object_id',
            ['object_id' => $object_id]
        );
    }
}
