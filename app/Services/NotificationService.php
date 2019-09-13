<?php

namespace App\Services;

use App\Mail\ReminderMail;
use App\Mail\TeacherScheduleMail;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Visitor;
use App\Notifications\ReminderTextMessage;

class NotificationService
{

    public function sendTextMessageAboutEventToVisitors($event_id)
    {
        $visitors = Visitor::has('slots')->where("event_id", $event_id)->get();

        foreach ($visitors as $visitor) {
            $slots = $visitor->slots()
                ->booked()
                ->orderBy('starts_at', 'asc')
                ->get();

            if ($slots->count()) {
                $visitor->notify(new ReminderTextMessage());
            }
        }
    }

    public function sendNotificationAboutEventToVisitors($event_id)
    {
        $visitors = Visitor::has('slots')->where("event_id", $event_id)->get();

        foreach ($visitors as $visitor) {
            $slots = $visitor->slots()
                ->booked()
                ->orderBy('starts_at', 'asc')
                ->get();
            $event = Event::find($visitor->event_id);
            $mail = \Mail::to($visitor->email);

            if ($visitor->email_secondary) {
                $mail->cc($visitor->email_secondary);
            }

            if ($slots->count()) {
                $mail->send(new ReminderMail(
                    $slots,
                    $event->starts_at,
                    $event->email_reminder,
                    $visitor->token, $visitor->student_name
                ));
            }
        }
    }

    public function sendNotificationAboutEventToTeachers($event_id)
    {
        $teachers = Teacher::where("event_id", $event_id)->get();

        foreach($teachers as $teacher) {
            \Mail::to($teacher->email)->send(new TeacherScheduleMail($teacher));
        }
    }

}
