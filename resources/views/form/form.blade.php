<form action="{{ $action }}" method="{{ cmprstr($method, 'DELETE') || cmprstr($method, 'PUT') ? 'POST' : $method }}" enctype="multipart/form-data">
    @if(!cmprstr($method, 'GET'))
        @if(cmprstr($method, 'DELETE') || cmprstr($method, 'PUT'))
            @method($method)
        @endif
        @csrf
    @endif
    {{ $slot }}
</form>
