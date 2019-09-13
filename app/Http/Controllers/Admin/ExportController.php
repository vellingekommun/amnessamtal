<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exports\SlotsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Event;

class ExportController extends Controller
{

    public function slots(Event $event, Request $request)
    {
        return Excel::download(new SlotsExport(array_merge(["event"=>$event->id], $request->only(['visitor','teacher','student']))), 'slots.xlsx');
    }

}
