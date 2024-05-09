<form method="{{ $method == 'GET' ? 'GET' : 'POST' }}" action="{{ $action }}" enctype="{{ $encrypt }}">
    @csrf
    @method($method)
    {{ $content }}
    @if (!$noAction)
        <div class="col-md-8 offset-md-4">
            <button class="btn btn-primary" type="submit"> {{ $buttonLabel }} </button>
        </div>
    @endif
</form>
