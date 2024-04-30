<form
    method="{{ $method == 'GET' ? 'GET' : 'POST' }}"
    action="{{ $action }}"
>
    @csrf
    @method($method)
    {{ $content }}
    <div class="col-md-8 offset-md-4">
        <button class="btn btn-primary" type="submit"> {{ $buttonLabel }} </button>
    </div>
</form>
