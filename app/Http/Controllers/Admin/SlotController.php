<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\AdminService;
use App\Services\BookingService;
use App\Services\VisitorService;

use App\Http\Requests\CreateVisitor;

use App\Models\Event;
use App\Models\Grade;
use App\Models\Slot;
use App\Models\Teacher;

class SlotController extends Controller
{
    protected $service;
    protected $visitorService;
    protected $bookingService;

    public function __construct(AdminService $service, VisitorService $visitorService, BookingService $bookingService)
    {
        $this->service = $service;
        $this->visitorService = $visitorService;
        $this->bookingService = $bookingService;
    }

    public function delete(Request $request)
    {
        if ($this->service->deleteSlot(request()->input('slot_id'))) {
            $request->session()->flash('message.level', 'success');
            $request->session()
                ->flash('message.content', 'Bokningen är borttagen.');
        }
        else {
            $request->session()->flash('message.level', 'error');
            $request->session()
                ->flash('message.content', 'Ett okänt fel har uppstått, var god försök igen senare.');
        }
        return redirect()->back();
    }

    public function block(Request $request)
    {
        if ($this->service->blockSlot(request()->input('slot_id'))) {
            $request->session()->flash('message.level', 'success');
            $request->session()
                ->flash('message.content', 'Bokningen är blockerad och går ej att bokas.');
        }
        else {
            $request->session()->flash('message.level', 'error');
            $request->session()
                ->flash('message.content', 'Ett okänt fel har uppstått, var god försök igen senare.');
        }
        return redirect()->back();
    }

    public function create(Slot $slot)
    {
        $teacher = Teacher::find($slot->teacher_id);
        $event = Event::find($teacher->event_id);
        $grades = Grade::query()
            ->where('event_id', '=', $event->id)
            ->orderBy('name', 'asc')
            ->get()
            ->getIterator();

        if ($slot->isBlocked() || $slot->isBooked()) {
            return redirect()->route('events.show', [
                'event' => $event,
            ]);
        }
        else {
            return view('admin.booking.form', [
                'teacher' => $teacher,
                'grades' => $grades,
                'event' => $event,
                'slot' => $slot,
            ]);
        }
    }

    public function store(CreateVisitor $request)
    {
        $values = $request->all();

        if ($request->validated()) {
            if ($visitor = $this->visitorService->create($values)) {
                if($this->bookingService->save($visitor->id, [0 => [$values['slot'],],])){
                    flash('Bokningen skapades.')->success();
                } else {
                flash('Ett okänt fel har uppstått, bokningen kunde inte skapas.')->error();
                }
            } else {
                flash('Ett okänt fel har uppstått, besökaren kunde inte skapas.')->error();
            }
        } else {
            flash('Ett okänt fel har uppstått, var god kontrollera uppgifterna.')->error();
        }

        return redirect()->route('events.show', [
            'event' => $values['event']
        ]);
    }

}
