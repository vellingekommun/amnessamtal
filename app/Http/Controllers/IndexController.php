<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateVisitor;
use App\Services\VisitorService;

use App\Notifications\VerificationCode;

use App\Models\Grade;
use App\Models\Event;
use App\Models\Visitor;

class IndexController extends Controller
{

    private $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function index()
    {
        $grades = Grade::orderBy('name', 'asc')->get();
        $events = Event::bookable()->orderBy('starts_at', 'asc')->get();
        return view('index', compact('grades', 'events'));
    }

    public function create(CreateVisitor $request)
    {
        $validated = $request->validated();
        if($validated)
        {
            $visitor = $this->visitorService->create($request->all());
            if($visitor)
            {
                $request->session()->put('verify_visitor', $visitor->getKey());
                $visitor->notify(new VerificationCode());
                return redirect()->route('verify');  
            }

            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', 'Ett okänt fel uppstod, var god försök igen.');
        }
        return redirect()->route('create');
    }

    public function getVerify(Request $request)
    {
        return view('verify');
    }

    public function postVerify(Request $request)
    {
        $validated = $this->visitorService->verify($request->session()->get('verify_visitor'), $request->input("code"));
        if($validated)
        {
            $request->session()->put('visitor', $request->session()->get('verify_visitor'));
            $request->session()->forget('verify_visitor');
            return redirect()->route('book');
        }
        $request->session()->flash('message.level', 'error');
        $request->session()->flash('message.content', 'Koden kunde inte verifieras, var god försök igen.');
        return redirect()->route('verify');
    }
}
