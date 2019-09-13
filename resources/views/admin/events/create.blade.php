@extends("layouts.app")

@section("content")
<div class="page">
        <div class="row">
            <div class="col-12">
                <h1>Skapa ämnessamtalstillfälle</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ route('events.store') }}" method="POST">
                    {{ csrf_field() }}

                    @include('admin.events.form')

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Skapa</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
