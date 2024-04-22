![GitHub release (latest by date)](https://img.shields.io/github/v/release/mantax559/laravel-helpers?label=latest&style=flat-square)
![GitHub release (latest SemVer including pre-releases)](https://img.shields.io/github/v/release/mantax559/laravel-helpers?include_prereleases&label=pre-release&style=flat-square)
![Packagist](https://img.shields.io/packagist/l/mantax559/laravel-helpers?style=flat-square)
![PHP from Packagist](https://img.shields.io/packagist/php-v/mantax559/laravel-helpers?style=flat-square)
# Laravel Helpers
## Requirements
- Intl
## Installation & Setup
You can install the package via composer:

    composer require mantax559/laravel-helpers

After installation, add to the header:

    @stack('cdn-header')

And the footer:

    @stack('cdn-footer')
    @stack('scripts')

The package will automatically register its service provider.

## Customisation

### Config

You can optionally publish the config file with:

    php artisan vendor:publish --provider="Mantax559\LaravelHelpers\Providers\AppServiceProvider" --tag=config

### Tests
You can run tests with the command:

    vendor/bin/phpunit

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
