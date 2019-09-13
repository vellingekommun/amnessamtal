@extends("emails.master")

@section("content")
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hej,</p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Tack för din bokning avseende ämnessamtal!</p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Bokningen gjordes {{ Carbon\Carbon::now()->format('Y-m-d H:i:s') }}.</p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
    {!! nl2br(e($information_message)) !!}
    </p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Detta mail går inte att svara på.</p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Nedan finner ni en lista med de tider ni bokat till {{ $starts_at->format('Y-m-d') }}</p>

    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><a href="{{ route('edit',[$token]) }}">Ändra min bokning</a></p>

    @foreach($slots as $slot)
        @include('emails.partials.slot', $slot)
    @endforeach
@endsection
