@extends("layouts.public")
@section('bodyClasses', 'page-delete narrow-layout')
@section("content")

<div class="row">
    <div class="col-12">
        <div class="group">
            <h3>Ta bort bokad tid</h3>
            <p>
            Är du säker på att du vill ta bort din bokade tid?
            </p>
            <form action="{{ route("confirm.delete", [$slot_id, $visitor_token]) }}" method="post">
                {{ csrf_field() }}
                <fieldset>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Ja, ta bort min bokning</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

@endsection
