<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateVisitor;
use App\Services\BookingService;
use App\Models\Event;
use App\Models\Teacher;

use App\Imports\TeachersImport;
use Maatwebsite\Excel\Facades\Excel;
use File;

use App\Http\Requests\ImportRequest;

class ImportController extends Controller
{
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Event $event)
    {
        return view('admin.import', compact('event'));
    }

    public function store(ImportRequest $request, Event $event) {

        $import = Teacher::max('import') + 1;
        $extension = File::extension($request->file->getClientOriginalName());
        $path = $request->file('file')->store('teachers');

        Excel::import(new TeachersImport($event->getKey(), $import), $path);

        $this->bookingService->generateSlotsForEvent($event->getKey(), $import);
        flash('Importen lyckades.')->success();
        return back();
    }
}
