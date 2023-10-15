<label @isset($id) for="{{ $id }}" @endisset class="{{ $class }}">
    {{ $title }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>
