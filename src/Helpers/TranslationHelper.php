<?php

namespace Mantax559\LaravelHelpers\Helpers;

class TranslationHelper
{
    public static function getMostAccurate($model, string $idKey, bool $withDescription = false, array $parentModelNames = []): array
    {
        if (! empty($model->translation)) {
            $modelTranslation = $model->translation;
        } else {
            $modelTranslation = $model->translations->where('translation_status', config('laravel-helpers.translations_enum.confirmed'))->first();

            if (empty($modelTranslation)) {
                $modelTranslation = $model->translations->where('translation_status', config('laravel-helpers.translations_enum.manual'))->first();
            }

            if (empty($modelTranslation)) {
                $modelTranslation = $model->translations->where('translation_status', config('laravel-helpers.translations_enum.external'))->first();
            }

            if (empty($modelTranslation)) {
                $modelTranslation = $model->translations->where('translation_status', config('laravel-helpers.translations_enum.auto'))->first();
            }
        }

        $fullTitle = $modelTranslation->title;
        $parentModel = $model;
        foreach ($parentModelNames as $parentModelName) {
            $parentModel = $parentModel->$parentModelName;
            if (empty($parentModel->translation)) {
                $parentModelTitle = '<i><span class="text-secondary">'.__('Nėra vertimo').'</span></i>';
            } else {
                $parentModelTitle = $parentModel->title;
            }
            $fullTitle = $parentModelTitle.' <i class="fas fa-angle-right text-secondary px-2"></i> '.$fullTitle;
        }

        $data = [
            'id' => $modelTranslation->$idKey,
            'translation_status' => $modelTranslation->translation_status,
            'locale' => $modelTranslation->locale,
            'title' => $fullTitle,
            'title_value' => $modelTranslation->title,
        ];

        if ($withDescription) {
            $data['description_value'] = $modelTranslation->description;
        }

        return $data;
    }
}
