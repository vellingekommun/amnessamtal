<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookingService;
use Validator;
use Log;

class SlotController extends Controller
{

    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function reserve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $visitor_id = $request->session()->get('visitor');
        $result = $this->bookingService->reserveSlot($visitor_id, $request->input('slot_id'));
        if($result === "time_conflict") {
            return response(null, 409);
        }
        else if($result) {
            return response(null, 200);
        }
        else {
             return response()->json(null, 403);
        }
    }

    public function release(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $visitor_id = $request->session()->get('visitor');
        if($this->bookingService->releaseSlot($visitor_id, $request->input('slot_id'))) {
            return response(null, 200);
        }

        return response()->json($validator->errors(), 400);
    }
}
