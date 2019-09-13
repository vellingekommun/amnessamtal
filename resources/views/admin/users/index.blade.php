@extends("layouts.app")

@section("content")
    <div class="page">
        <div class="row">
            <div class="col-12">
                <h1>
                    <span>Användare</span>
                    <a href="{{ route('users.create') }}" class="btn btn-primary float-right">Skapa användare</a>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover slots-table">
                        <thead>
                            <tr>
                                <th scope="col">Namn</th>
                                <th scope="col">Email</th>
                                <th scope="col">Skapad</th>
                                <th scope="col">Senast uppdaterad</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td class="buttons">
                                        @if($user->id != Auth::user()->getKey())
                                            <form method="post" action="{{ route('users.destroy', ['user' => $user]) }}" onsubmit="return confirm('Är du säker på att du vill radera användaren?')"  class="float-right">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger btn-sm" type="submit">Ta bort</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-primary btn-sm float-right">Redigera</a>
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
