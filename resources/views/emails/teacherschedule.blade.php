@component('mail::message')
# Hej

Nedan ser du dina bokade tider för ämnessamtal.

Dina samtal kommer äga rum i sal {{ $teacher->room }}

Den som bokat en tid kan enbart avboka sin tid via en länk i sin bokningsbekräftelse, önskar de boka ny tid hänvisas dom att kontakta dig direkt via mail.

@component('mail::table')
| Tid | Målsman | E-post | Telefon | Elev |
| -------- | -------- | -------- | -------- | -------- |
@foreach($slots as $slot)
| **{{ $slot->starts_at->format("H:i") }}** | {{ $slot->visitor ? $slot->visitor->name : null }} | {{ $slot->visitor ? $slot->visitor->email : null }} | {{ $slot->visitor ? $slot->visitor->phone : null }} || {{ $slot->visitor ? $slot->visitor->student_name : null }} |
@endforeach
@endcomponent

@endcomponent
