<?php
namespace App\Repositories;

use App\Models\Visitor;
use Illuminate\Support\Facades\Hash;

class VisitorRepository
{
    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }

    public function create($data)
    {
        $phone = "+".$data['country'].ltrim(str_replace("-", "", str_replace(" ", "", $data['phone'])),"0");

        $visitor = $this->visitor->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_secondary' => $data['email-secondary'],
            'phone' => $phone,
            'student_name' => $data['student'],
            'grade_id' => $data['grade'],
            'verification_code' => random_int(1000, 9999),
            'token' => str_random(32),
            'event_id' => $data['event'],
        ]);
        $visitor->save();
        return $visitor;
    }

    public function verify($visitor_id, $code)
    {
        return $this->visitor->where("id", $visitor_id)->where("verification_code", $code)->count();
    }

    public function get($visitor_id)
    {
        return $this->visitor->find($visitor_id);
    }

    public function getByToken($visitor_token)
    {
        return $this->visitor->where("token", $visitor_token)->first();
    }

}
