<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Teacher;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Facades\Validator;

use Misd\Linkify\Linkify;

class TeachersImport implements ToCollection, WithHeadingRow
{
    private $event_id;

    public function __construct(int $event_id, int $import) 
    {
        
        $this->event_id = $event_id;
        $this->import = $import;
   }

    public function collection(Collection $rows)
    {
        $linkify = new Linkify();

        Validator::make($rows->toArray(), [
             '*.grade' => 'required',
             '*.name' => 'required',
             '*.email' => 'required|email'
         ])->validate();

        //Delete previous relations to existing teachers in import
        foreach ($rows as $row)
        {
            $teacher = Teacher::where("email", $row['email'])->where("event_id", $this->event_id)->get()->first();
            if($teacher) {
                $teacher->grades()->detach();
                $teacher->slots()->delete();
                $teacher->delete();
            }
        }

        foreach ($rows as $row) 
        {
            $teacher = Teacher::firstOrCreate(["email"=>$row['email']], ["name"=>$row['name'], "room"=>$row['room'], "break_time"=>$row['break'], "message"=>$linkify->process($row['message']), "bookable"=>($row['notbookable']?0:1), "event_id"=>$this->event_id, "import"=>$this->import]);
            $grade = Grade::firstOrCreate(["name"=>$row['grade']], ["event_id"=>$this->event_id, "import"=>$this->import]);
            $teacher->grades()->syncWithoutDetaching($grade->getKey());
        }
    }
}