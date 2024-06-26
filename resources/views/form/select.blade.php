<x-form::input-group :name="$name" :class="$class" :append="$append">

    @isset($title)
        <x-form::label :id="$id" :title="$title" :required="$required"/>
    @endisset

    @isset($tooltip)
        <x-form::tooltip :title="$tooltip"/>
    @endisset

    <select {{ $attributes->merge($inputAttributes)->class([config('laravel-helpers.component.select.class'), config('laravel-helpers.component.error.input_class') => $hasError($name)]) }}></select>

</x-form::input-group>

{{-- TODO: Hardcode --}}
@if(isset($wireModel) || isset($wireModelDefer))
    <script type="text/javascript">
        function formatResult(result, container, query) {
            if (query.term && result.text && !result.loading) {
                let term = query.term;
                let text = result.text;
                let pattern = new RegExp('(' + term + ')', 'gi');

                text = text.replace(pattern, '<b>$1</b>');
                return text;
            }

            return result.text;
        }

        settings = {
            multiple: {{ $multiple ? 'true' : 'false' }},
            theme: 'bootstrap-5',
            language: '{{ $locale }}',
            width: '100%',
            placeholder: '{{ $placeholder }}',
            allowClear: {{ !$multiple && !$required ? 'true' : 'false' }},
            templateResult: function(result) {
                let searchInput = $('#{{ $id }}').next('.select2').find('.select2-search__field');
                let params = searchInput.length ? searchInput.val() : '';
                return formatResult(result, null, {term: params});
            },
            escapeMarkup: function(markup) {
                return markup;
            }
        }

        @if($collection->isNotEmpty())
            @if(is_more_or_equal(config('laravel-helpers.select2.minimum_results_for_search'), count($collection)))
                settings.minimumResultsForSearch = Infinity;
            @endif
            settings.data = @json($collection);
        @elseif(!empty($api))
            settings.ajax = {
                url: '{{ $api }}',
                type: 'post',
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    return {
                        query: params.term,
                        page: params.page || 1,
                        _token: '{{ csrf_token() }}',
                    };
                },
                cache: true
            };
        @endif

        $('#{{ $id }}').select2(settings).val(null).trigger('change');

        $('#{{ $id }}').on('select2:opening', function(event) {
            var select2 = $(this);
            if (select2.val() == null) {
                var option = new Option('', '', true, true);
                select2.append(option).trigger('change');
            }
        });

        $('#{{ $id }}').on('select2:select', function(event) {
            var select2 = $(this);
            if (select2.val() == '') {
                select2.find('option[value=""]').remove().trigger('change');
            }
        });

        @if(!empty($selected) || (!is_array($selected) && cmprstr($selected, 0)) || $disabled)
            $('#{{ $id }}').prop('disabled', true);
            @if(!empty($selected) || (!is_array($selected) && cmprstr($selected, 0)))
                values = @json($selected);
                @if($collection->isNotEmpty())
                    $('#{{ $id }}').val(values).trigger('change').prop('disabled', false);
                @elseif(isset($api))
                    data = new FormData();
                    data.append('values', values);
                    data.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: '{{ $api }}',
                        type: 'post',
                        dataType: 'json',
                        data: data,
                        cache: false,
                        processData: false,
                        contentType: false,
                    }).then(function (data) {
                        data.forEach(function (item) {
                            $('#{{ $id }}').append(new Option(item.text, item.id, true, true));
                        });
                        $('#{{ $id }}').prop('disabled', false);
                    });
                @endif
            @endif
        @endif

        $(document).ready(function () {
            $('#{{ $id }}').on('change', function (e) {
                @this.set('{{ $convertBracketsToDots($name) }}', $('#{{ $id }}').select2("val"));
            });
        });
    </script>
@endif

@push('scripts')
    <script type="text/javascript">
        function formatResult(result, container, query) {
            if (query.term && result.text && !result.loading) {
                let term = query.term;
                let text = result.text;
                let pattern = new RegExp('(' + term + ')', 'gi');

                text = text.replace(pattern, '<b>$1</b>');
                return text;
            }

            return result.text;
        }

        settings = {
            multiple: {{ $multiple ? 'true' : 'false' }},
            theme: 'bootstrap-5',
            language: '{{ $locale }}',
            width: '100%',
            placeholder: '{{ $placeholder }}',
            allowClear: {{ !$multiple && !$required ? 'true' : 'false' }},
            templateResult: function(result) {
                let searchInput = $('#{{ $id }}').next('.select2').find('.select2-search__field');
                let params = searchInput.length ? searchInput.val() : '';
                return formatResult(result, null, {term: params});
            },
            escapeMarkup: function(markup) {
                return markup;
            }
        }

        @if($collection->isNotEmpty())
            @if(is_more_or_equal(config('laravel-helpers.select2.minimum_results_for_search'), count($collection)))
                settings.minimumResultsForSearch = Infinity;
            @endif
            settings.data = @json($collection);
        @elseif(!empty($api))
            settings.ajax = {
                url: '{{ $api }}',
                type: 'post',
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    return {
                        query: params.term,
                        page: params.page || 1,
                        _token: '{{ csrf_token() }}',
                    };
                },
                cache: true
            };
        @endif

        $('#{{ $id }}').select2(settings).val(null).trigger('change');

        $('#{{ $id }}').on('select2:opening', function(event) {
            var select2 = $(this);
            if (select2.val() == null) {
                var option = new Option('', '', true, true);
                select2.append(option).trigger('change');
            }
        });

        $('#{{ $id }}').on('select2:select', function(event) {
            var select2 = $(this);
            if (select2.val() == '') {
                select2.find('option[value=""]').remove().trigger('change');
            }
        });

        @if(!empty($selected) || (!is_array($selected) && cmprstr($selected, 0)) || $disabled)
            $('#{{ $id }}').prop('disabled', true);
            @if(!empty($selected) || (!is_array($selected) && cmprstr($selected, 0)))
                values = @json($selected);
                @if($collection->isNotEmpty())
                    $('#{{ $id }}').val(values).trigger('change').prop('disabled', false);
                @elseif(isset($api))
                    data = new FormData();
                    data.append('values', values);
                    data.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: '{{ $api }}',
                        type: 'post',
                        dataType: 'json',
                        data: data,
                        cache: false,
                        processData: false,
                        contentType: false,
                    }).then(function (data) {
                        data.forEach(function (item) {
                            $('#{{ $id }}').append(new Option(item.text, item.id, true, true));
                        });
                        $('#{{ $id }}').prop('disabled', false);
                    });
                @endif
            @endif
        @endif
    </script>
@endpush

@once
    @push('cdn-header')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    @endpush
    @push('cdn-footer')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/{{ $locale }}.js"></script>
    @endpush
@endonce
