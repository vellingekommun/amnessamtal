<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\SlotRepository;

use App\Models\Slot;

class AdminService
{

    protected $slotRepository;

    public function __construct(SlotRepository $slotRepository)
    {
        $this->slotRepository = $slotRepository;
    }


    public function getEventSlots(Event $event, $data, $sort = 'teacher', $order = 'asc', $paginate = 100)
    {
        switch($sort) {
            case "teacher":
                $sort = "teachers.name";
                break;
            case "name":
                $sort = "visitors.name";
                break;
            case "student":
                $sort = "visitors.student_name";
                break;
        }
        return $this->slotRepository->getAllEventSlots($event, $data, $sort, $order, $paginate);
    }

    public function blockSlot($slot_id)
    {
        return $this->slotRepository->block($slot_id);
    }   

    public function deleteSlot($slot_id)
    {
        return $this->slotRepository->delete($slot_id, Slot::find($slot_id)->visitor_id);
    }        
}
