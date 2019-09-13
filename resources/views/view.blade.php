@extends("layouts.public")
@section('bodyClasses', 'page-delete narrow-layout')
@section("content")

<div class="row">
    <div class="col-12">
        <div class="group">
            <h3>Dina bokade ämnessamtal</h3>
            <p><strong>Datum:</strong> {{ $event->starts_at->format('Y-m-d') }}</p>
            @foreach($slots as $slot)
                @include('partials.slot', $slot)
            @endforeach
        </div>
    </div>
</div>
@endsection
