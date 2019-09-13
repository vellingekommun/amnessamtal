@extends("layouts.app")

@section("content")

    <h1>Boka {{ $teacher->value('name') }} - {{ $slot->starts_at }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.slot.store') }}" method="post">
        @csrf

        <div class="group">
            <fieldset>
                <legend>Målsman</legend>
                <div class="form-group">
                    <label for="signup-name">Namn</label>
                    <input type="text" class="form-control" id="signup-name" name="name" value="{{ old('name') }}" required />
                </div>
                <div class="form-group">
                    <label for="signup-email">E-postadress</label>
                    <input type="email" class="form-control" id="signup-email" name="email" value="{{ old('email') }}" required />
                </div>
                <div class="form-group">
                    <label for="signup-email-secondary">E-postadress till annan målsman (Valfritt)</label>
                    <input type="email" class="form-control" id="signup-email-secondary" name="email-secondary" value="{{ old('email-secondary') }}" />
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="signup-country">Landskod</label>
                        <select class="form-control" id="signup-country" name="country" required>
                        <option value="45" {{ old("country") == "45" ? "selected":"" }}>+45 Danmark</option>
                        <option value="46" {{ (old("country") == "46" || old("country") == "")  ? "selected":"" }}>+46 Sverige</option>
                        </select>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="signup-phone">Mobiltelefon</label>
                        <input type="tel" class="form-control" id="signup-phone" name="phone" value="{{ old('phone') }}" placeholder="07XX-XX XX XX"  required />
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="group">
            <fieldset>
                <legend>Elev</legend>
                <div class="form-group">
                    <label for="signup-student">Namn</label>
                    <input type="text" class="form-control" id="signup-student" name="student" value="{{ old('student') }}" required />
                </div>
                <div class="form-group">
                    <label for="signup-grade">Klass</label>
                    <select class="form-control" id="signup-grade" name="grade" required>
                        <option value="">Välj klass</option>

                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                        @endforeach
                    </select>
                </div>
            </fieldset>
        </div>

        <input name="slot" type="hidden" value="{{ $slot->id }}">
        <input name="event" type="hidden" value="{{ $event->id }}">

        <button type="submit" class="btn btn-lg btn-primary float-right">Boka</button>
    </form>

@endsection
