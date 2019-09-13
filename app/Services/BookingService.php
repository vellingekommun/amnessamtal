<?php

namespace App\Services;

use App\Models\Visitor;
use App\Models\Teacher;
use App\Models\Slot;
use App\Models\Event;

use App\Repositories\SlotRepository;
use App\Repositories\GradeRepository;
use App\Repositories\TeacherRepository;

use Carbon\Carbon;
use Log;

class BookingService
{

    private $gradeRepository;

    private $repository;

    public function __construct(SlotRepository $repository, GradeRepository $gradeRepository)
    {
        $this->repository = $repository;
        $this->gradeRepository = $gradeRepository;
    }

    public function getAllTeachersByGrade($grade_id)
    {
        return $this->gradeRepository->getAllTeachers($grade_id);
    }

    public function generateSlotsForEvent($event_id, $import)
    {
        $teachers = Teacher::where("import", $import)->where("bookable", 1)->get();
        $event = Event::find($event_id);
        $break_length = $event->break_length;
        $session_length = $event->session_length;
        foreach($teachers as $teacher) {
            $time = $event->starts_at;
            $end = $event->ends_at;
            if($teacher->break_time) {
                $break_time_start = $event->starts_at;
                $break_time_start->hour = substr($teacher->break_time,0,2);
                $break_time_start->minute = substr($teacher->break_time,-2);
                $break_time_end = $break_time_start->copy()->addMinutes($break_length);
            }

            while($time < $end) {
                $time_end = $time->copy()->addMinutes($session_length);
                if(!$teacher->break_time || ($time_end->lessThanOrEqualTo($break_time_start) || $time->greaterThanOrEqualTo($break_time_end))) {
                    $slot = Slot::create(["starts_at"=>$time, "teacher_id"=>($teacher->getKey())]);
                }
                $time = $time_end;
            }
        }
    }

    public function reserveSlot($visitor_id, $slot_id)
    {
        Log::channel('actions')->info('Reservation', ["visitor"=>$visitor_id, "slot"=>(int)$slot_id]);
        return $this->repository->reserve($visitor_id, $slot_id);
    }

    public function releaseSlot($visitor_id, $slot_id)
    {
        Log::channel('actions')->info('Release', ["visitor"=>$visitor_id, "slot"=>(int)$slot_id]);
        return $this->repository->release($visitor_id, $slot_id);
    }

    public function save($visitor_id, $data)
    {
        Log::channel('actions')->info('Book', ["visitor"=>$visitor_id, "booking"=>$data]);
        return $this->repository->save($visitor_id, $data);
    }

    public function delete($slot_id, $visitor_token)
    {
        $visitor = Visitor::where('token',$visitor_token)->firstOrFail();
        Log::channel('actions')->info('Delete', ["visitor"=>$visitor->getKey(), "slot"=>(int)$slot_id]);
        return $this->repository->delete($slot_id, $visitor->getKey());
    }

}
