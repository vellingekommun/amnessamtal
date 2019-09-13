<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookingService;
use App\Services\VisitorService;
use App\Jobs\SendConfirmationMailJob;
use App\Models\Event;

class BookController extends Controller
{

    private $visitorService;

    private $bookingService;

    public function __construct(BookingService $bookingService, VisitorService $visitorService)
    {
        $this->bookingService = $bookingService;
        $this->visitorService = $visitorService;

        $this->middleware('verifiedVisitor', ['except' => ['confirmation', 'edit', 'view', 'delete', 'confirmDelete']]);
    }

    public function index(Request $request)
    {
        $visitor_id = $request->session()->get('visitor');
        $visitor = $this->visitorService->get($visitor_id);
        $teachers = $this->bookingService->getAllTeachersByGrade($visitor->grade_id);
        $event = Event::find($visitor->event_id);
        return view('book', compact('visitor','event','teachers'));
    }

    public function save(Request $request)
    {
        $visitor_id = $request->session()->get('visitor');

        if($request->exists('slot')){
            $validated = $this->bookingService->save($visitor_id, $request->input("slot"));
            if($validated)
            {
                $this->dispatch(new SendConfirmationMailJob($visitor_id));
                $request->session()->forget('visitor');
                return redirect()->route('book.confirmation');
            }

        }

        $request->session()->flash('message.level', 'error');
        $request->session()->flash('message.content', 'Bokningen kunde inte sparas, var god försök igen.');
        return redirect()->route('book');
    }

    public function confirmation()
    {
        return view('confirmation');
    }

    public function edit(Request $request, $visitor_token)
    {
        $visitor = $this->visitorService->getByToken($visitor_token);
        $request->session()->put('visitor', $visitor->getKey());
        return redirect()->route('book');
    }

    public function view(Request $request, $visitor_token)
    {
        $visitor = $this->visitorService->getByToken($visitor_token);
        $slots = $visitor->slots()->booked()->orderBy('starts_at', 'asc')->get();
        $event = Event::find($visitor->event_id);
        return view('view', compact("event","slots"));
    }

    public function delete(Request $request, $slot_id, $visitor_token)
    {
        return view('delete', compact("slot_id", "visitor_token"));
    }

    public function confirmDelete(Request $request, $slot_id, $visitor_token)
    {
        if(!$this->bookingService->delete($slot_id, $visitor_token)){
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', 'Ett okänt fel har uppstått, din tid kunde inte avbokas, var god försök igen senare.');
            return redirect()->route('delete', compact("slot_id", "visitor_token"));
        }

        return view('delete_confirmation', compact("visitor_token"));
    }
}
