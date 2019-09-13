<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $slots;
    public $starts_at;
    public $information_message;
    public $token;
    public $student_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $slots, Carbon $starts_at, string $information_message, string $token, string $student_name)
    {
        $this->slots = $slots;
        $this->starts_at = $starts_at;
        $this->information_message = $information_message;
        $this->token = $token;
        $this->student_name = $student_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Påminnelse: Dina bokningar för " . $this->student_name)->view('emails.remind')->with(['slots' => $this->slots, 'starts_at' => $this->starts_at, 'information_message' => $this->information_message, 'token' => $this->token]);
    }
}
