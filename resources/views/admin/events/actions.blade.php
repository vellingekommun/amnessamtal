<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">{{ $event->title }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="{{ route('events.show', ['event' => $event])}}">Bokningar</a>
      <a class="nav-item nav-link" href="{{ route('events.edit', ['event' => $event])}}">Redigera</a>
      <a class="nav-item nav-link" href="{{ route('events.import', ['event' => $event])}}">Importera</a>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Notifieringar
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <form method="post" action="{{ route('admin.notification.event.teachers', ['event' => $event]) }}" onsubmit="return confirm('Är du säker på att du vill skicka påminnelser?')">
                @csrf
                <button class="dropdown-item" type="submit">Skicka påminnelse till lärarna</button>
            </form>

            <form method="post" action="{{ route('admin.notification.event.visitors', ['event' => $event]) }}" onsubmit="return confirm('Är du säker på att du vill skicka påminnelser?')">
                @csrf
                <button class="dropdown-item" type="submit">Skicka påminnelse till besökarna</button>
            </form>

            <form method="post" action="{{ route('admin.notification.text_message.event.teachers', ['event' => $event]) }}" onsubmit="return confirm('Är du säker på att du vill skicka SMS-påminnelser?')">
                @csrf
                <button class="dropdown-item" type="submit">Skicka SMS-påminnelse till besökarna</button>
            </form>
        </div>
      </li>
    </div>
  </div>
</nav>