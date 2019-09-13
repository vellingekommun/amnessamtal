@extends("layouts.app")

@section("content")
    @include('admin.events.actions')
    <div class="page">
        <div class="row">
            <div class="col-12">
                <header>
                    <h1>Bokningar</h1>
                    <div class="actions"><a class="btn btn-primary " href="{{ route('events.export', ['event' => $event]) . $query}}">Exportera</a></div>
                </header>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form method="get">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <select class="form-control" id="filter-teacher" name="teacher" />
                            <option value="">Välj lärare</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ Request::get("teacher") == $teacher->id ? "selected":"" }}>{{ $teacher->name }}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" id="filter-student" name="student" />
                            <option value="">Välj student</option>
                            @foreach($visitors_students as $visitor)
                                <option value="{{ $visitor->id }}" {{ Request::get("student") == $visitor->id ? "selected":"" }}>{{ $visitor->student_name }}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control" id="filter-visitor" name="visitor" />
                            <option value="">Välj målsman</option>
                            @foreach($visitors as $visitor)
                                <option value="{{ $visitor->id }}" {{ Request::get("visitor") == $visitor->id ? "selected":"" }}>{{ $visitor->name }}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-secondary">Filtrera</button>
                            <a href="{{ route('events.show', ['event' => $event]) }}" class="btn">Återställ</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover slots-table">
                        <thead>
                        <tr>
                            <th scope="col"><a href="{{$route . $query}}&sort=teacher&order={{(Request::get('sort') == "teacher" ? (Request::get('order') === 'asc' ? 'desc' : 'asc') : 'asc') }}">Lärare {!! (Request::get('sort') == "teacher" ? (Request::get('order') === 'asc' ? '&uarr;' : '&darr;') : null) !!}</a></th>
                            <th scope="col">Tid</th>
                            <th scope="col"><a href="{{$route . $query}}&sort=student&order={{(Request::get('sort') == "student" ? (Request::get('order') === 'asc' ? 'desc' : 'asc') : 'asc') }}">Elev {!! (Request::get('sort') == "student" ? (Request::get('order') === 'asc' ? '&uarr;' : '&darr;') : null) !!}</a></th>
                            <th scope="col"><a href="{{$route . $query}}&sort=name&order={{(Request::get('sort') == "name" ? (Request::get('order') === 'asc' ? 'desc' : 'asc') : 'asc') }}">Målsman {!! (Request::get('sort') == "name" ? (Request::get('order') === 'asc' ? '&uarr;' : '&darr;') : null) !!}</a></th>
                            <th scope="col">Telefon</th>
                            <th scope="col">E-post</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($slots as $slot)
                            <tr class="{{ ($slot->isBooked() ? 'table-primary' : ($slot->isBlocked() ? 'table-danger' : '')) }}">
                                <td scope="row">{{ $slot->teacher->name }}</td>
                                <td scope="row">{{ $slot->starts_at->format('H:i') }}</td>
                                <td scope="row">@if(!empty($slot->visitor) && $slot->isBooked()) {{ $slot->visitor->student_name }} @endif</td>
                                <td scope="row">@if(!empty($slot->visitor) && $slot->isBooked()) {{ $slot->visitor->name }} @endif</td>
                                <td scope="row">@if(!empty($slot->visitor) && $slot->isBooked()) {{ $slot->visitor->phone }} @endif</td>
                                <td scope="row">@if(!empty($slot->visitor) && $slot->isBooked()) {{ $slot->visitor->email }} @endif</td>
                                <td scope="row" class="buttons">
                                    @if($slot->isBooked() || $slot->isBlocked())
                                        <form method="post" action="{{ route('admin.slot.delete') }}" onsubmit="return confirm('Är du säker på att du vill ta bort bokningen?')">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="slot_id" value="{{ $slot->getKey() }}" />
                                            <button class="btn btn-danger btn-sm float-right" type="submit">Ta bort</button>
                                        </form>
                                    @else
                                        <a class="btn btn-secondary btn-sm float-right" href="{{ route('admin.slot.create', ['slot' => $slot]) }}">Boka</a>
                                        <form method="post" action="{{ route('admin.slot.block') }}" class="float-right">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="slot_id" value="{{ $slot->getKey() }}" />
                                            <button class="btn btn-secondary btn-sm" type="submit">Blockera</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $slots->appends(Request::except('page'))->render() !!}

            </div>

        </div>
    </div>
@endsection
