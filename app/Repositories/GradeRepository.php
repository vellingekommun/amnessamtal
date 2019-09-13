<?php
namespace App\Repositories;

use App\Models\Grade;
use Illuminate\Support\Facades\Hash;

class GradeRepository
{
    public function __construct(Grade $grade)
    {
        $this->grade = $grade;
    }

    public function getAllTeachers($grade_id)
    {
        $teachers = $this->grade->find($grade_id)->teachers;
        return $teachers;
    }


}
