<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Mantax559\LaravelHelpers\Requests\Select2Request;
use ReflectionException;
use ReflectionFunction;

class Select2Helper
{
    const SORT_ASC = 0;

    const SORT_DESC = 1;

    /**
     * @throws ReflectionException
     */
    public function getArray(
        Select2Request $request,
        $model,
        $text,
        array $select,
        array $with = [],
        array $where = [],
        string $sort = null,
        string $sortDirection = self::SORT_ASC,
    ): array {
        $validated = $request->validated();

        if (! in_array('id', $select)) {
            $select[] = 'id';
        }

        $reflection = new ReflectionFunction($text);
        $textIdentifier = implode('-', [$reflection->getFileName(), $reflection->getStartLine(), $reflection->getEndLine()]);

        $cacheKey = external_code(implode('.', [$model, $textIdentifier, json_encode($select), json_encode($with), json_encode($where), $sort, $sortDirection]), 'select2', 'md5');

        if (Cache::missing($cacheKey)) {
            $data = $model::query()
                ->when(! empty($with), function ($query) use ($with) {
                    $query->with($with);
                })->when(! empty($where), function ($query) use ($where) {
                    $query->where($where);
                })->when(! empty($sort) && cmprint($sortDirection, self::SORT_ASC), function ($query) use ($sort) {
                    $query->orderBy($sort);
                })->when(! empty($sort) && cmprint($sortDirection, self::SORT_DESC), function ($query) use ($sort) {
                    $query->orderByDesc($sort);
                })->get($select)
                ->map(function ($item) use ($text) {
                    return [
                        'id' => $item->id,
                        'text' => $text($item),
                    ];
                })->when(empty($sort), function ($query) {
                    $query->sortBy('text');
                });

            Cache::put(
                $cacheKey,
                $data,
                now()->addSeconds(config('laravel-helpers.select2.data_cache_duration_seconds')),
            );
        } else {
            $data = Cache::get($cacheKey);
        }

        if (! empty($validated['values'])) {
            $data = $data->whereIn(
                'id',
                explode(',', $validated['values']),
            );
        } elseif (! empty($validated['query'])) {
            $data = $data->filter(function ($item) use ($validated) {
                return stristr($item['text'], $validated['query']);
            });
        }

        $data = array_values($data->toArray());

        if (! empty($validated['values']) || empty($validated['page'])) {
            return $data;
        } else {
            return $this->addPagination($data, $validated['page']);
        }
    }

    public function getJson(
        Select2Request $request,
        $model,
        $text,
        array $select,
        array $with = [],
        array $where = [],
        string $sort = null,
        string $sortDirection = self::SORT_ASC,
    ): JsonResponse {
        return response()->json(
            $this->getArray(
                $request,
                $model,
                $text,
                $select,
                $with,
                $where,
                $sort,
                $sortDirection,
            )
        );
    }

    private function addPagination(array $data, int $page): array
    {
        $result = [];

        $paginationDataPerQuery = config('laravel-helpers.select2.pagination_per_query');
        $totalPages = ceil(count($data) / $paginationDataPerQuery);
        $dataFrom = ($page - 1) * $paginationDataPerQuery;
        $dataTo = $dataFrom + $paginationDataPerQuery;

        foreach ($data as $index => $item) {
            if ($dataTo <= $index) {
                break;
            } elseif ($dataFrom <= $index) {
                $result[] = $item;
            }
        }

        return [
            'results' => $result,
            'pagination' => [
                'more' => ! cmprint($page, $totalPages),
            ],
        ];
    }
}
