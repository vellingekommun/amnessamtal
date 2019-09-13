@extends("layouts.app")

@section("content")
    <div class="page">
        <h1>Ämnessamtal<a href="{{ route('events.create') }}" class="btn btn-primary float-right">Skapa tillfälle</a></h1>

        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover slots-table">
                        <thead>
                            <tr>
                                <th scope="col">Titel</th>
                                <th scope="col">Tillfället börjar</th>
                                <th scope="col">Tillfället slutar</th>
                                <th scope="col">Bokning börjar</th>
                                <th scope="col">Bokning slutar</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr class="table">
                                <td scope="row">{{ $event->title }}</td>
                                <td scope="row">{{ $event->starts_at }}</td>
                                <td scope="row">{{ $event->ends_at }}</td>
                                <td scope="row">{{ $event->booking_starts_at }}</td>
                                <td scope="row">{{ $event->booking_ends_at }}</td>
                                <td scope="row">
                                    <a href="{{ route('events.show', ['event' => $event]) }}" class="btn btn-primary btn-sm float-right">Visa</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
