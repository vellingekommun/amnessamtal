@extends("layouts.app")

@section("content")
@include('admin.events.actions')
<div class="page">
        <div class="row">
            <div class="col-12">
                <header>
                    <h1>Redigera</h1>
                    <div class="actions">
                        <form method="post"class=" float-right" action="{{ route('events.destroy', ['event' => $event]) }}" onsubmit="return confirm('Är du säker på att du vill radera tillfället och alla data permanent?')">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-primary btn-danger" type="submit">Ta bort tillfället</button>
                        </form>
                        <a class="btn btn-primary float-right" href="{{ route('events.close', ['event' => $event]) }}">Stäng bokningen</a>
                    </div>
                </header>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ route('events.update', ['event' => $event]) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @include('admin.events.form')

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Spara</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
