@extends("emails.master")

@section("content")
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hej,</p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Snart är det dags för ämnessamtal. Nedan finner ni en lista med de tider ni bokat {{ $starts_at->format('Y-m-d') }}.</p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
    {!! nl2br(e($information_message)) !!}
    </p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Detta mail går inte att svara på.</p>
    
    @foreach($slots as $slot)
        @include('emails.partials.slot', $slot)
    @endforeach
@endsection
