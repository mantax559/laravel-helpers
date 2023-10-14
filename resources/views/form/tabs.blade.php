<ul class="{{ $class }}">
    @isset($tabTitle1)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }} active" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-1">{{ $tabTitle1 }}</a>
        </li>
    @endisset
    @isset($tabTitle2)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-2">{{ $tabTitle2 }}</a>
        </li>
    @endisset
    @isset($tabTitle3)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-3">{{ $tabTitle3 }}</a>
        </li>
    @endisset
    @isset($tabTitle4)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-4">{{ $tabTitle4 }}</a>
        </li>
    @endisset
    @isset($tabTitle5)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-5">{{ $tabTitle5 }}</a>
        </li>
    @endisset
    @isset($tabTitle6)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-6">{{ $tabTitle6 }}</a>
        </li>
    @endisset
    @isset($tabTitle7)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-7">{{ $tabTitle7 }}</a>
        </li>
    @endisset
    @isset($tabTitle8)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-8">{{ $tabTitle8 }}</a>
        </li>
    @endisset
    @isset($tabTitle9)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-9">{{ $tabTitle9 }}</a>
        </li>
    @endisset
</ul>
<div class="{{ config('laravel-helpers.form.tabs.content_class') }}">
    @isset($tabContent1)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade show active" id="{{ config('laravel-helpers.form.tabs.name') }}-1">
            {{ $tabContent1 }}
        </div>
    @endisset
    @isset($tabContent2)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-2">
            {{ $tabContent2 }}
        </div>
    @endisset
    @isset($tabContent3)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-3">
            {{ $tabContent3 }}
        </div>
    @endisset
    @isset($tabContent4)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-4">
            {{ $tabContent4 }}
        </div>
    @endisset
    @isset($tabContent5)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-5">
            {{ $tabContent5 }}
        </div>
    @endisset
    @isset($tabContent6)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-6">
            {{ $tabContent6 }}
        </div>
    @endisset
    @isset($tabContent7)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-7">
            {{ $tabContent7 }}
        </div>
    @endisset
    @isset($tabContent8)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-8">
            {{ $tabContent8 }}
        </div>
    @endisset
    @isset($tabContent9)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') }} fade" id="{{ config('laravel-helpers.form.tabs.name') }}-9">
            {{ $tabContent9 }}
        </div>
    @endisset
</div>
