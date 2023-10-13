<i {{ $attributes->merge($inputAttributes)->class($class) }}></i>

@once
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endonce
