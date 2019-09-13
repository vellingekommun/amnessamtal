<!DOCTYPE html>
<html lang="sv">
@include('admin.partials.head')
<body class="admin">
    <div id="app">
            @include('admin.partials.header')
            <div class="container">
            
            <main class="py-4">
                @include('flash::message')
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
