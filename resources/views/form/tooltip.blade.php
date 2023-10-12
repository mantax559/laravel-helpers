@props(['icon', 'class', 'title',])

<i class="{{ $icon }} {{ $class ?? 'text-secondary' }}"
   data-toggle="tooltip"
   data-placement="left"
   title="{{ $title }}">
</i>

@once
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endonce
