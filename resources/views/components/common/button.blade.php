@if ($post)
    <form method="POST" action="{{ $ref }}">
        @csrf
        @foreach ($postParams as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
@endif
@if (!$post)
    <a href="{{ $ref }}">
@endif
<button @if ($post) type="submit" @endif class="btn btn-primary">{{ $label }}</button></a>
@if ($post)
    </form>
@endif
