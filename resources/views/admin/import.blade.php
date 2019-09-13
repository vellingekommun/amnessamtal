@extends("layouts.app")

@section("content")
@include('admin.events.actions')
<div class="page">
    <div class="row">
        <div class="col-12">
            <h1>Importera bokningar</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12"> 
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
    </div>
    <div class="row">
        <div class="col-12"> 
            <h3>Ladda upp</h3>
            <form action="{{ route('events.import.store', ['event' => $event]) }}" method="post" enctype="multipart/form-data" id="import-form">
                @csrf
                <div class="form-group">
                    <label for="file">Excel-fil (csv, xls, xlsx)</label>
                    <input type="file" name="file" id="file" class="form-control-file" />
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Importera</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"> 
            <h3>Instruktioner</h3>
            <p>Laddar upp en excel-fil som specificerar vilka lärare som ska gå att boka för vilka klasser. Importen kommer automatiskt generera bokningsbara tider för de speciferade lärarna under den tid och den längd som tillfället är inställt att äga rum under. Det går även att ange ej bokningsbara lärare (visar bara ett textmeddelande istället). Varje lärare kan även ha en angiven paus som anges i excel-filen. Pausens längd specificeras under tillfällets inställningar.</p>
            <h3>Uppdateringar</h3>
            <p>Om flera filer laddas upp eftervarandra kommer alla nya lärare att läggas till, om en lärare med samma e-postadress som redan är inlagd importeras kommer den läraren tas bort helt och ersättas av den nya samt kopplas till de nya klasserna som angetts i den senaste filen, de tidigare kopplingarna tioll klasser kommer tas bort. Eventuella existerande bokningar med läraren kommer tas bort.</p>
            <h3>Exempel</h3>
            <p><a href="{{ asset("download/example.xlsx") }}">Ladda ner en exempel-fil</a> som med tillgängliga kolumner och exempelvärden.</p>
        </div>
        <div class="col-md-6"> 
            <h3>Fält (kolumnnamn)</h3>
            <h6>Klass (grade)</h6>
            <p>
            Vilken klass som ska kunna boka läraren. Om en lärare ska vara tillgänglig för flera klasser så skapa flera rader.
            </p>
            <h6>Namn (name)</h6>
            <p>
            Lärarens namn
            </p>
            <h6>E-postadress (email)</h6>
            <p>
            Lärarens e-postadress, det skapas en unik lärare för varje unik e-postaress, så var noga med att ange samma e-postadress på alla rader med samma lärare.
            </p>
            <h6>Plats/Rum (room)</h6>
            <p>
            Rummet som samtal kommer ta plats i.
            </p>
            <h6>Meddelande (message)</h6>
            <p>
            Meddelande som ska visas under lärarens namn när besökarna väljer tider. Tänk på att inte skiva för långa meddelande.
            </p>
            <h6>Paus (break)</h6>
            <p>
            Klockslag som läraren kommer ha paus. Anges i formatet HHMM t ex 1630.
            </p>
            <h6>Ej bokningsbar (notbookable)</h6>
            <p>
            Ange en 1:a i denna kolumnen om läraren inte ska gå att boka utan endast meddelandet ska synas. (Anges under message)
            </p>
        </div>
    </div>
</div>
@endsection
