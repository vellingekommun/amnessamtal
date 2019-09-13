@extends("layouts.app")

@section("content")
    <div class="page">
        <div class="row">
            <div class="col-12">
                <h1>Redigera {{ $user->name }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ action('Admin\UserController@update', ['user' => $user]) }}" method="POST">
                    @method('PUT')
                    @csrf

                     <div class="form-group">
                        <label for="name">Namn</label>
                        <input type="text" name="name" title="Namn" placeholder="Namn" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', $user->name) }}" required>
                         @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email">E-postadress</label>
                        <input id="email" type="email"name="email" placeholder="E-post" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', $user->email) }}" required >
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Lösenord</label>
                        <input type="password" name="password" placeholder="Nytt lösenord" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
                    </div>

                    <div class="form-group">
                        <input id="password-confirm" name="password_confirmation" type="password" placeholder="Upprepa nytt lösenord" class="form-control">
                         @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Spara</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


