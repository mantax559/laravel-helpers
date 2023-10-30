<i @isset($id) id="{{ $id }}" @endisset class="{{ $class }}" title="{{ $title }}" data-toggle="tooltip" data-placement="{{ $position }}"></i>

@once
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endonce
