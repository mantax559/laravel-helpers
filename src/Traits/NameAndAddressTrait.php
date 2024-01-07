<?php

namespace Mantax559\LaravelHelpers\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait NameAndAddressTrait
{
    protected function firstName(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, 4),
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, 4),
        );
    }

    protected function companyName(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, 4),
        );
    }

    protected function companyCode(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, [4, 7]),
        );
    }

    protected function companyVatNumber(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, [4, 7]),
        );
    }

    protected function city(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, 4),
        );
    }

    protected function address(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, 4),
        );
    }

    protected function postcode(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, [4, 7]),
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, [3, 7]),
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => format_string($value, 5),
        );
    }

    public function getFullAddressAttribute(): ?string
    {
        $fullAddress = array_filter([$this->address, $this->postcode, $this->city, $this->country->name]);

        if (empty($fullAddress)) {
            return null;
        }

        return implode(', ', $fullAddress);
    }

    public function getFullNameAttribute(): ?string
    {
        $namesList = $this->getNamesList();

        if (empty($namesList)) {
            return null;
        }

        return implode(' ', $namesList);
    }

    public function getAbbreviationNameAttribute(): ?string
    {
        $namesList = $this->getNamesList();

        return match (count($namesList)) {
            0 => null,
            1 => $namesList[0][0],
            2 => "{$namesList[0][0]}. {$namesList[1]}",
        };
    }

    public function getInitialNameAttribute(): ?string
    {
        $namesList = $this->getNamesList();

        return match (count($namesList)) {
            0 => null,
            1 => "{$namesList[0][0]}.",
            2 => "{$namesList[0][0]}. {$namesList[1][0]}.",
        };
    }

    private function getNamesList(): array
    {
        $list = [$this->first_name, $this->last_name];

        return array_filter($list);
    }
}
