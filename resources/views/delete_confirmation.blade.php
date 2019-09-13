@extends("layouts.public")
@section('bodyClasses', 'page-delete-confirmation narrow-layout')
@section("content")

<div class="row">
    <div class="col-12">
        <div class="group">
            <h3>Din bokning är nu borttagen</h3>
            <p>
            Din bokning har nu tagits bort, för att boka en ny tid <a href="{{ route('edit',[$visitor_token]) }}">redigera din bokning</a>.
            </p>
        </div>
    </div>
</div>

@endsection
