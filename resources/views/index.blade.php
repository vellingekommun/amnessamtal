@extends("layouts.public")
@section('bodyClasses', 'page-index narrow-layout')
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
        @if($events->count())
        <form action="{{ route("create") }}" method="post">
            {{ csrf_field() }}
            <div class="group">
                <fieldset>
                    <legend>Samtalstillfälle</legend>
                    <div class="form-group">
                        <events :events='{!! $events->toJson() !!}'></events>
                    </div>
                </fieldset>
            </div>
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
                            <select class="form-control" id="signup-country" name="country" required />
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
                        <grades :grades='{!! $grades->toJson() !!}'></grades>
                    </div>
                </fieldset>
            </div>
            <div class="group">
                <fieldset>
                    <legend>Samtycke om personuppgiftsbehandling</legend>
                    <div class="form-terms">
                        <p>Jag samtycker till att Vellinge kommun samlar in och lagrar mina samt mitt barns personuppgifter som jag lämnar genom denna tjänst; bokningen av ämneslärarsamtal (behandling som sker är insamling, hantering, lagring, överföring och radering).</p>
                        <p>De personuppgifter som behandlas för detta ändamål är: namn, telefonnummer och e-post.</p>
                        <p>De personuppgifter som behandlas sker med stöd av samtycke och jag är medveten om att jag när som helst kan återkalla mitt samtycke och jag har även rätt att begära att mina personuppgifter raderas.</p>
                        <p>Dina personuppgifter kommer att lagras i vårt bokningssystem samt vklass och kommer att hanteras av Sundsgymnasiets personal samt leverantören av bokningssystemet (OAWA).</p>
                        <p>Vellinge kommun hanterar dina personuppgifter i enlighet med Dataskyddsförordningen och behåller inte personuppgifter du har lämnat längre än nödvändigt. Personuppgiftsansvarig för denna behandling är utbildningsnämnden som kan kontaktas på <a href="mailto:vellinge.kommun@vellinge.se">vellinge.kommun@vellinge.se</a>. Dina personuppgifter gallras ifrån bokningstjänsten inom 30 dagar efter att ämnessamtalen genomförts.</p>
                        <p>Mer information om hur vi behandlar personuppgifter, om dina rättigheter och om Dataskyddsförordningen finns på <a href="http://www.vellinge.se/personuppgifter">www.vellinge.se/personuppgifter</a>. Dataskyddsombudet för Vellinges kommun nås på <a href="mailto:dataskyddsombud@vellinge.se">dataskyddsombud@vellinge.se</a> eller 040-42 50 00.</p>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="signup-terms" required>
                            <label class="form-check-label" for="signup-terms">Jag samtycker till personuppgiftsbehandling enligt ovan.</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <button type="submit" class="btn btn-lg btn-primary float-right">Fortsätt</button>
        </form>
        @else
            <div class="group">
                <h3>Bokningen är nu stängd</h3>
                <p>För frågor kring genomförd bokning eller behov av att boka samtalstid vänligen kontakta aktuell lärare via Vklass.</p>
                <p>För övriga frågor besök <a href="http://www.sundsgymnasiet.se">www.sundsgymnasiet.se</a> eller Vklass där du hittar våra kontaktuppgifter.</p>
            </div>
        @endif
    </div>
@endsection
