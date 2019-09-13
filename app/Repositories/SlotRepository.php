<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Slot;
use Carbon\Carbon;

class SlotRepository
{

    public function __construct(Slot $slot)
    {
        $this->slot = $slot;
    }

    public function getAllEventSlots(Event $event, $data, $sort, $order, $paginate)
    {
        $slots = $this->slot
            ->with('teacher', 'visitor')
            ->select('slots.*')
            ->join('teachers', 'slots.teacher_id', '=', 'teachers.id', 'left outer')
            ->join('visitors', 'slots.visitor_id', '=', 'visitors.id', 'left outer')
            ->join('events', 'teachers.event_id', '=', 'events.id')
            ->where('events.id', '=', $event->id)
            ->orderByRaw($sort . ' IS NOT NULL desc')
            ->orderBy($sort, $order)
            ->orderBy('starts_at', 'asc');

        if (isset($data['teacher'])) {
            $slots = $slots->where('slots.teacher_id', $data['teacher']);
        }

        if (isset($data['visitor'])) {
            $slots = $slots->where('slots.visitor_id', $data['visitor']);
        }

        if (isset($data['student'])) {
            $slots = $slots->where('slots.visitor_id', $data['student']);
        }

        return $slots->paginate($paginate);
    }

    public function reserve($visitor_id, $slot_id)
    {
        $slot = $this->slot->find($slot_id);

        $notBookedSameTime = $this->slot->where('starts_at', $slot->starts_at)
            ->where('id', '!=', $slot_id)
            ->reservedBy($visitor_id)
            ->count();

        if (!$notBookedSameTime) {
            $reserve = $this->slot
                ->where('id', $slot_id)
                ->bookableBy($visitor_id)
                ->update([
                    'reserved_at' => Carbon::now(),
                    'visitor_id' => $visitor_id,
                ]);

            if ($reserve) {
                $this->slot
                    ->where('id', '!=', $slot_id)
                    ->where('teacher_id', $slot->teacher_id)
                    ->where('visitor_id', $visitor_id)
                    ->whereNull('booked_at')
                    ->update([
                        'reserved_at' => NULL,
                        'visitor_id' => NULL,
                    ]);
            }

            return $reserve;
        }
        return "time_conflict";
    }

    public function release($visitor_id, $slot_id)
    {
        return $this->slot->where('id', $slot_id)
            ->bookableBy($visitor_id)
            ->update(['reserved_at' => NULL]);
    }

    public function save($visitor_id, $data)
    {
        $previouslyBooked = Slot::bookedBy($visitor_id)
            ->get()
            ->pluck('id')
            ->toArray();

        foreach ($data as $teacher) {
            foreach ($teacher as $slot) {
                $save = Slot::where('id', $slot)
                    ->bookableBy($visitor_id)
                    ->update([
                        'booked_at' => Carbon::now(),
                        'visitor_id' => $visitor_id,
                    ]);

                $previouslyBooked = array_diff($previouslyBooked, [$slot]);

                if (!$save) {
                    return FALSE;
                }
            }
        }

        $this->slot->whereIn('id', $previouslyBooked)
            ->where('visitor_id', $visitor_id)
            ->update([
                'booked_at' => NULL,
                'reserved_at' => NULL,
                'visitor_id' => NULL,
            ]);

        return TRUE;
    }

    public function delete($slot_id, $visitor_id)
    {
        return $this->slot->where('id', $slot_id)
            ->where('visitor_id', $visitor_id)
            ->update([
                'booked_at' => NULL,
                'reserved_at' => NULL,
                'visitor_id' => NULL,
            ]);
    }

    public function block($slot_id)
    {
        return $this->slot->where('id', $slot_id)
            ->update(['booked_at' => Carbon::now(), 'visitor_id' => 0]);
    }

}
