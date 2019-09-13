@extends("layouts.public")
@section('bodyClasses', 'page-book')
@section("content")
<form action="{{ route("book.save") }}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-12">
            <h3>{{ $event->title }}</h3>
            <div class="booking-information">
                {!! $event->booking_information !!}
            </div>
            <div class="group">
                <div class="booking-legend">
                    <span class="reserved circle"></span> <span class="title">Reserverad</span>
                    <span class="bookable circle"></span> <span class="title">Bokningsbar</span>
                    <span class="disabled circle"></span> <span class="title">Ej bokningsbar</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-4 order-2">
            <div id="cart" class="sticky-top">
                <cart :teachers='{!! $teachers->keyBy('id')->toJson() !!}'></cart>
                <button type="submit" class="btn btn-lg btn-primary float-right">Boka</button>
            </div>
        </div>
        <div class="booking col-xs-8 col-lg-8 order-1">
            @foreach($teachers as $teacher)
                <div class="group">
                    <h5>{{ $teacher->name }} @if($teacher->room )<span>({{ $teacher->room }})</span>@endif
                        @if($teacher->bookable && !$teacher->slots()->bookableBy($visitor->getKey())->count())
                            <span class="tag">Fullbokad</span>
                        @endif
                    </h5>
                    @if($teacher->message)
                        <p>{!! $teacher->message !!}</p>
                    @endif
                    <fieldset>
                        <slots :visitor_id='{!! $visitor->getKey() !!}' :slots='{!! $teacher->slots->toJson() !!}' :reserved_slot='{!! $teacher->slots()->reservedBy($visitor->getKey())->orderBy('booked_at', 'desc')->get()->toJson() !!}'></slots>
                    </fieldset>
                </div>
            @endforeach
        </div>
    </div>
</form>
@endsection
