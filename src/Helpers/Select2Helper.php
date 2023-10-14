<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Mantax559\LaravelHelpers\Requests\Select2Request;

class Select2Helper
{
    public function getArray(Select2Request $request, $model, string $key, array $with = [], array $where = [], string $sort = null): array
    {
        $validated = $request->validated();
        $cacheKey = external_code(implode('.', [$model, $key, json_encode($with), json_encode($where)]), 'select2', 'md5');

        if (Cache::missing($cacheKey)) {
            $data = $model::query()
                ->with($with)
                ->where($where)
                ->when(isset($sort), function ($query) use ($sort) {
                    $query->orderByDesc($sort);
                })->get($this->getSelectableKeys($model, $key))
                ->map(function ($item) use ($key) {
                    return [
                        'id' => $item->id,
                        'text' => $item->$key,
                    ];
                })->when(! isset($sort), function ($query) {
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

    public function getJson(Select2Request $request, $model, string $key, array $with = [], array $where = [], string $sort = null): JsonResponse
    {
        return response()->json(
            $this->getArray($request, $model, $key, $with, $where, $sort)
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

    private function getSelectableKeys($model, string $key): array
    {
        $keys = ['id'];

        if (isset(array_flip((new $model())->getFillable())[$key])) {
            $keys[] = $key;
        }

        return $keys;
    }
}
