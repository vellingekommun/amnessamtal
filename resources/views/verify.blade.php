@extends("layouts.public")
@section('bodyClasses', 'page-verify narrow-layout')
@section("content")
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="row">
        <form action="{{ route("verify") }}" method="post">
            {{ csrf_field() }}
            <div class="group">
                <fieldset>
                    <legend>Bekräftelsekod</legend>
                    <p>Ett sms med din kod har skickats till dig, fyll i koden nedan för att fortsätta.</p>
                    <div class="form-group">
                        <input type="number" class="form-control" id="verify-code" name="code" placeholder="XXXX"  maxlength="4" required />
                    </div>
                </fieldset>
            </div>
            <button type="submit" class="btn btn-primary btn-lg float-right">Fortsätt</button>
        </form>
    </div>

@endsection
