<?php

namespace App\Jobs;

use App\Mail\ConfirmationMail;
use App\Models\Visitor;
use App\Models\Slot;
use App\Models\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendConfirmationMailJob implements ShouldQueue
{
    protected $visitor_id;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($visitor_id)
    {
        $this->visitor_id = $visitor_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->process();
    }

    private function process()
    {
        $visitor = Visitor::find($this->visitor_id);
        $event = Event::find($visitor->event_id);
        $slots = $visitor->slots()->booked()->orderBy('starts_at', 'asc')->get();

        $mail = \Mail::to($visitor->email);
        if($visitor->email_secondary){
            $mail->cc($visitor->email_secondary);
        }   
        $mail->queue(new ConfirmationMail($slots, $event->starts_at, $event->email_confirmation, $visitor->token, $visitor->student_name));
    }

}
