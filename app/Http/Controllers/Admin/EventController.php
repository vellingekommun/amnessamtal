<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Visitor;
use App\Services\AdminService;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;

class EventController extends controller
{

    protected $adminService;

    public function __construct(AdminService $service)
    {
        $this->adminService = $service;
    }

    public function index()
    {
        return view('admin.events.index', [
            'events' => Event::all(),
        ]);
    }

    public function create()
    {
        return view('admin.events.create', [
            'title' => old('title'),
            'session_length' => old('session_length'),
            'break_length' => old('break_length'),
            'booking_information' => old('booking_information'),
            'email_confirmation' => old('email_confirmation'),
            'email_reminder' => old('email_reminder'),
            'sms_reminder' => old('sms_reminder')?old('sms_reminder'):"Hej, glöm inte dina inbokade ämnessamtal {datum}. Se dina bokade samtal på {länk}.",
            'readonly' => '',
            'dates' => [
                'booking_starts_at' => old('booking_starts_at'),
                'booking_ends_at' => old('booking_ends_at'),
                'starts_at' => old('starts_at'),
                'ends_at' => old('ends_at'),
            ],
        ]);
    }

    public function store(EventRequest $request)
    {
        $event = new Event($request->only(['title', 'session_length', 'break_length', 'starts_at', 'ends_at', 'booking_starts_at','booking_ends_at','booking_information','email_confirmation','email_reminder','sms_reminder']));

        if($event->save()) {
            flash('Ämnestillfället är nu skapat.')->success();
        }else {
            flash('Ett okänt fel har uppstått, ämnestillfället kunde inte skapas.')->error();
        }

        return redirect()->route('events.index');
    }

    public function show(Request $request, Event $event)
    {
        if (request()->exists('sort')) {
            $slots = $this->adminService->getEventSlots($event, request()->only([
                'teacher',
                'visitor',
                'student',
            ]), request()->get('sort'), request()->get('order'));
        }
        else {
            $slots = $this->adminService->getEventSlots($event, request()->only([
                'teacher',
                'visitor',
                'student',
            ]));
        }

        $query = "?" . http_build_query($request->only([
                'teacher',
                'visitor',
                'student',
            ]));

        $teachers = Teacher::where('event_id', $event->getKey())->orderBy("name")->get();
        $visitors = Visitor::where('event_id', $event->getKey())->orderBy("name")->get();
        $visitors_students = Visitor::where('event_id', $event->getKey())->orderBy("student_name")->get();
        $route = url()->current();

        return view('admin.events.show', compact('event', 'slots', 'teachers', 'visitors', 'visitors_students', 'query', 'route'));
    }

    public function edit(Event $event)
    {
        $dateFormat = config('app.datetime_input_format');
        $dates = [];

        foreach ($event->getDates() as $date) {
            $dates[$date] = old($date, $event->{$date}->format($dateFormat));
        }

        return view('admin.events.edit', [
            'event' => $event,
            'dates' => $dates,
            'title' => old('title', $event->title),
            'break_length' => old('session_length', $event->break_length),
            'session_length' => old('session_length', $event->session_length),
            'booking_information' => old('booking_information', $event->booking_information),
            'email_confirmation' => old('email_confirmation', $event->email_confirmation),
            'email_reminder' => old('email_reminder', $event->email_reminder),
            'sms_reminder' => old('sms_reminder', $event->sms_reminder),
            'readonly' => 'readonly',
        ]);
    }

    public function update(EventRequest $request, Event $event)
    {
        if($event->update($request->only(['title', 'booking_starts_at','booking_ends_at','booking_information','email_confirmation','email_reminder','sms_reminder']))) {
            flash('Dina ändringar är sparade.')->success();
        } else {
            flash('Ett okänt fel har uppstått, dina ändringar kunde inte sparas.')->error();
        }
        return redirect()->route('events.edit', ['event' => $event]);
    }

    public function destroy(Event $event)
    {
        foreach($event->teachers as $teacher)
        {
            $teacher->grades()->detach();
            $teacher->slots()->delete();
        }

        $event->teachers()->delete();
        $event->grades()->delete();
        $event->visitors()->delete();

        $event->delete();
        flash('Ämnestillfället och all data är nu borttaget.')->success();
        return redirect()->route('events.index');
    }

    public function close(Event $event)
    {
        $event->update(array('booking_ends_at'=>now()));
        flash('Bokningen är nu stängd')->success();
        return redirect()->route('events.show', ['event' => $event]);
    }
}
