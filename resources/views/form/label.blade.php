<label for="{{ $id }}" class="{{ $class }}">
    {{ $title }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>
