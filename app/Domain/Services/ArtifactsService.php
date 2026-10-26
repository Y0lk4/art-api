<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Models\ArtModel;
use App\Helpers\Core\PDOService;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;

class ArtifactsService extends BaseService
{
    public function __construct(private PDOService $pdo_service) {}

    public function getArtifacts(array $query): array
    {
        $allowed = ['title', 'department_id', 'culture_id', 'start_year', 'is_public_domain', 'sort', 'page', 'limit', 'offset'];
        foreach ($query as $name => $value) {
            if (!in_array($name, $allowed, true) || !is_string($value)) {
                throw new InvalidArgumentException('Invalid query parameter: ' . $name . '.');
            }
        }

        $filters = [];
        if (isset($query['title'])) {
            $length = preg_match_all('/./us', $query['title']);
            if ($length === false || $length < 1 || $length > 255 || trim($query['title']) === '') {
                throw new InvalidArgumentException('title must contain between 1 and 255 characters.');
            }
            $filters['title'] = $query['title'];
        }
        foreach (['department_id', 'culture_id', 'start_year'] as $name) {
            if (isset($query[$name])) {
                $filters[$name] = $this->validateInteger($query[$name], $name, $name === 'start_year' ? -2147483648 : 1);
            }
        }
        if (isset($query['is_public_domain'])) {
            if (!in_array($query['is_public_domain'], ['true', 'false'], true)) {
                throw new InvalidArgumentException('is_public_domain must be true or false.');
            }
            $filters['is_public_domain'] = $query['is_public_domain'] === 'true' ? 1 : 0;
        }

        $sort = $query['sort'] ?? 'title';
        $sort_field = str_starts_with($sort, '-') ? substr($sort, 1) : $sort;
        if (!in_array($sort_field, ArtModel::SORT_FIELDS, true)) {
            throw new InvalidArgumentException('sort must be title, start_year, end_year, acquisition_date, or created_at, optionally prefixed with -.');
        }

        $page = $this->validateInteger($query['page'] ?? '1', 'page', 1);
        $limit = $this->validateInteger($query['limit'] ?? '10', 'limit', 1, 100);
        $offset = isset($query['offset'])
            ? $this->validateInteger($query['offset'], 'offset', 0)
            : ($page - 1) * $limit;
        if ($offset > 2147483647) {
            throw new InvalidArgumentException('Pagination offset must not exceed 2147483647.');
        }

        $model = new ArtModel($this->pdo_service);
        return array_map($this->formatArtifact(...), $model->getArtifacts($filters, $sort, $limit, $offset));
    }

    public function getArtifactById(string $artifact_id, array $query = []): array|false
    {
        if ($query !== []) {
            throw new InvalidArgumentException('Query parameters are not supported for a single artifact.');
        }
        $object_id = $this->validateInteger($artifact_id, 'artifact_id', 1);
        $model = new ArtModel($this->pdo_service);
        $artifact = $model->getArtifactById($object_id);

        return $artifact === false ? false : $this->formatArtifact($artifact);
    }

    private function validateInteger(string $value, string $name, int $minimum, int $maximum = 2147483647): int
    {
        if (!preg_match('/^-?(0|[1-9][0-9]*)$/D', $value)) {
            throw new InvalidArgumentException($name . ' must be an integer between ' . $minimum . ' and ' . $maximum . '.');
        }
        $integer = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => $minimum, 'max_range' => $maximum]]);
        if ($integer === false) {
            throw new InvalidArgumentException($name . ' must be an integer between ' . $minimum . ' and ' . $maximum . '.');
        }

        return $integer;
    }

    private function formatArtifact(array $artifact): array
    {
        foreach (['object_id', 'department_id', 'culture_id', 'period_id', 'medium_id', 'start_year', 'end_year'] as $field) {
            if ($artifact[$field] !== null) {
                $artifact[$field] = (int) $artifact[$field];
            }
        }
        foreach (['height_cm', 'width_cm'] as $field) {
            if ($artifact[$field] !== null) {
                $artifact[$field] = (float) $artifact[$field];
            }
        }
        foreach (['is_highlight', 'is_public_domain'] as $field) {
            if ($artifact[$field] !== null) {
                $artifact[$field] = (bool) $artifact[$field];
            }
        }
        $timezone = new DateTimeZone(date_default_timezone_get());
        foreach (['created_at', 'updated_at'] as $field) {
            if ($artifact[$field] !== null) {
                $artifact[$field] = (new DateTimeImmutable($artifact[$field], $timezone))->format(DATE_RFC3339);
            }
        }

        return $artifact;
    }
}
