@extends('layouts.clean')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">{{ __('Återställ lösenord') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{-- Vi har mailat din återställningslänk --}}
                            {{ session('status') }}

                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-12">
                                <input placeholder="E-post" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Skicka återställningslänk') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
