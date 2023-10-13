<?php

namespace Mantax559\LaravelHelpers\Helpers;

class RedirectHelper
{
    public const SaveAndStay = 'save_and_stay';

    public const SaveAndClose = 'save_and_close';

    public const FileRemove = 'file_remove';

    public static function getUrl(string $model, string $action = self::SaveAndClose): string
    {
        if (cmprstr($action, self::SaveAndClose)) {
            $sessionKey = SessionHelper::getUrlKey($model);

            if (session()->missing($sessionKey)) {
                return config('laravel-helpers.homepage');
            } else {
                return session($sessionKey);
            }
        } else {
            return back()->getTargetUrl();
        }
    }
}
