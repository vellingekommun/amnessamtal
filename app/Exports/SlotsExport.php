<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\Slot;

class SlotsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    private $data;

    public function __construct($data) 
    {
        $this->data = $data;
    }
 
    public function collection()
    {
        $slots = new Slot();

        if(isset($this->data ['event']) && $this->data ['event']) {
            $event_id = $this->data ['event'];
            $slots = $slots->whereHas('teacher', function ($query) use ($event_id) {
                $query->where('event_id', $event_id);
            });
        }

        if(isset($this->data ['teacher']) && $this->data ['teacher']) {
            $slots = $slots->where('teacher_id', $this->data ['teacher']);
        }

        if(isset($this->data ['visitor']) && $this->data ['visitor']) {
            $slots = $slots->where('visitor_id', $this->data ['visitor']);
        }

        if(isset($this->data ['student']) && $this->data ['student']) {
            $slots = $slots->where('visitor_id', $this->data ['student']);
        }

        return $slots->get();
    }

    public function headings(): array
    {
        return [
            'Lärare',
            'Sal',
            'Tid',
            'Målsman',
            'E-post',
            'Telefon',
            'Elev',
        ];
    }

    public function map($slot): array
    {
        return [
            $slot->teacher->name,
            $slot->teacher->room,
            $slot->starts_at->format("H:i"),
            ($slot->visitor ? $slot->visitor->name:null),
            ($slot->visitor ? $slot->visitor->email:null),
            ($slot->visitor ? "+".$slot->visitor->phone:null),
            ($slot->visitor ? $slot->visitor->student_name:null),
        ];
    }
}