<!DOCTYPE html>
<html lang="sv">
    @include('partials.head')

    <body>
        <div id="app" class="public">
            <div class="container">
                @if(session()->has('message.level'))
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-{{ session('message.level') }}">
                            {!! session('message.content') !!}
                            </div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
        @yield('before-scripts')
        @include('partials.scripts')
        @yield('after-scripts')
    </body>
</html>
