<?php
namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherRepository
{
    public function __construct(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    public function getAllByClass($class_id)
    {
        $teachers = $this->teacher->where("grade_id", $class_id)->get();
        return $teachers;    
    }


}
