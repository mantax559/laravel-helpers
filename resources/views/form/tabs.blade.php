<ul class="{{ $class }}">
    @foreach($tabs as $index => $tab)
        <li class="{{ config('laravel-helpers.form.tabs.item_class') }}">
            <a class="{{ config('laravel-helpers.form.tabs.link_class') . ($loop->first() ? 'active' : '') }}" data-toggle="pill" href="#{{ config('laravel-helpers.form.tabs.name') }}-{{ $index }}">
                {{ $tab['title'] }}
            </a>
        </li>
    @endforeach
</ul>
<div class="{{ config('laravel-helpers.form.tabs.content_class') }}">
    @foreach($tabs as $index => $tab)
        <div class="{{ config('laravel-helpers.form.tabs.panel_class') . ($loop->first() ? 'fade show active' : '') }}" id="{{ config('laravel-helpers.form.tabs.name') }}-{{ $index }}">
            {{ $tab['content'] }}
        </div>
    @endforeach
</div>
