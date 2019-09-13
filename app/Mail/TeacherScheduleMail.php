<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Teacher;

class TeacherScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $slots = $this->teacher->slots()->booked()->get();
        return $this->subject("Bokade tider för ämnessamtal")->markdown('emails.teacherschedule')->with(['slots' => $slots, 'teacher'=> $this->teacher]);
    }
}
