<form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data">
    @if(!cmprstr($method, 'GET'))
        @if(cmprstr($method, 'DELETE') || cmprstr($method, 'PUT'))
            @method($method)
        @endif
        @csrf
    @endif
    {{ $slot }}
</form>
