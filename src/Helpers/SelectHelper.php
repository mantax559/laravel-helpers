<?php

namespace Mantax559\LaravelHelpers\Helpers;

use Illuminate\Support\Collection;

class SelectHelper
{
    public static function booleanOptions(): Collection
    {
        return collect([
            [
                'id' => '1',
                'text' => __('Taip')
            ],
            [
                'id' => '0',
                'text' => __('Ne')
            ]
        ]);
    }

    public static function logStatusOptions(): Collection
    {
        return collect([
            [
                'id' => 'success',
                'text' => __('Sėkmingas pranešimas')
            ],
            [
                'id' => 'warning',
                'text' => __('Įspėjimas')
            ],
            [
                'id' => 'error',
                'text' => __('Klaida')
            ]
        ]);
    }

    public static function invoiceIsEditableOptions(): Collection
    {
        return collect([
            [
                'id' => '1',
                'text' => __('Atrakinta')
            ],
            [
                'id' => '0',
                'text' => __('Užrakinta')
            ]
        ]);
    }
}
