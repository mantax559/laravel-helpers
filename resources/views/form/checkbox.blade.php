<x-form::input-group :class="config('laravel-helpers.component.checkbox.group_class')" :name="$name" :class="$class">

    <input {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.component.checkbox.class'), config('laravel-helpers.component.error.input_class') => $hasError($name)]) }} />

    @isset($title)
        <x-form::label :class="config('laravel-helpers.component.checkbox.label_class')" :id="$id" :title="$title"/>
    @endisset

</x-form::input-group>
