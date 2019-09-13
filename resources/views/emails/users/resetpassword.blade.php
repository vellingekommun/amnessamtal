@component('mail::message')
# Hej {{ $name }}
Du får detta mail för att du har begärt en återställning av ditt lösenord.
@component('mail::button', ['url' => $url])
Återställ lösenord
@endcomponent
Hälsningar,<br>
{{ config('app.name') }}
@component('mail::subcopy', ['url' => $url])
Om du har problem att klicka på "Återställ lösenord" knappen, öpnna annars här: [{{ $url}}]({{ $url}})
@endcomponent
@endcomponent
