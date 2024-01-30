<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Mantax559\LaravelHelpers\Requests\Select2Request;
use ReflectionException;
use ReflectionFunction;

class Select2Helper
{
    const SORT_ASC = 'asc';

    const SORT_DESC = 'desc';

    public function getArray(
        Select2Request $request,
        $model,
        $text,
        array $select,
        array $with = [],
        array $where = [],
        string $sort = null,
        string $sortDirection = self::SORT_ASC
    ): array {
        $validated = $request->validated();

        $select = $this->ensureIdInSelect($select);

        $textIdentifier = $this->getTextIdentifier($text);
        $cacheKey = $this->generateCacheKey($model, $textIdentifier, $select, $with, $where, $sort, $sortDirection);

        $data = Cache::remember(
            $cacheKey,
            now()->addSeconds(config('laravel-helpers.select2.data_cache_duration_seconds')),
            fn () => $this->fetchDataFromModel($model, $select, $with, $where, $sort, $sortDirection, $text)
        );

        if (! empty($validated['values'])) {
            $data = $this->filterDataByIds($data, $validated['values']);
        } elseif (! empty($validated['query'])) {
            $data = $this->filterDataByText($data, $validated['query']);
        }

        return empty($validated['values']) || empty($validated['page'])
            ? array_values($data)
            : $this->addPagination($data, $validated['page']);
    }

    public function getJson(
        Select2Request $request,
        $model,
        $text,
        array $select,
        array $with = [],
        array $where = [],
        string $sort = null,
        string $sortDirection = self::SORT_ASC
    ): JsonResponse {
        return response()->json($this->getArray($request, $model, $text, $select, $with, $where, $sort, $sortDirection));
    }

    /**
     * @throws ReflectionException
     */
    private function getTextIdentifier($text): string
    {
        $reflection = new ReflectionFunction($text);

        return implode('-', [$reflection->getFileName(), $reflection->getStartLine(), $reflection->getEndLine()]);
    }

    private function generateCacheKey($model, $textIdentifier, array $select, array $with, array $where, string $sort, string $sortDirection): string
    {
        return external_code(implode('.', [$model, $textIdentifier, json_encode($select), json_encode($with), json_encode($where), $sort, $sortDirection]), 'select2', 'md5');
    }

    private function fetchDataFromModel($model, array $select, array $with, array $where, string $sort, string $sortDirection, $text)
    {
        return $model::query()
            ->when(! empty($with), fn ($query) => $query->with($with))
            ->when(! empty($where), fn ($query) => $query->where($where))
            ->when(! empty($sort), fn ($query) => $this->applySorting($query, $sort, $sortDirection))
            ->get($select)
            ->map(fn ($item) => ['id' => $item->id, 'text' => $text($item)])
            ->when(empty($sort), fn ($query) => $query->sortBy('text'));
    }

    private function filterDataByIds($data, $values)
    {
        return $data->whereIn('id', explode(',', $values));
    }

    private function filterDataByText($data, $query)
    {
        return $data->filter(fn ($item) => stristr($item['text'], $query));
    }

    private function addPagination(array $data, int $page): array
    {
        $paginationDataPerQuery = config('laravel-helpers.select2.pagination_per_query');
        $totalPages = ceil(count($data) / $paginationDataPerQuery);
        $dataFrom = ($page - 1) * $paginationDataPerQuery;

        return [
            'results' => array_slice($data, $dataFrom, $paginationDataPerQuery),
            'pagination' => ['more' => ! cmprint($page, $totalPages)],
        ];
    }

    private function ensureIdInSelect(array $select): array
    {
        if (! in_array('id', $select)) {
            $select[] = 'id';
        }

        return $select;
    }

    private function applySorting($query, string $sort, string $sortDirection)
    {
        $query->when(cmprstr($sortDirection, self::SORT_ASC), fn ($q) => $q->orderBy($sort, self::SORT_ASC), fn ($q) => $q->orderBy($sort, self::SORT_DESC));
    }
}
