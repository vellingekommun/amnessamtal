<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\NotificationService;

class NotificationController extends Controller
{

    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendNotificationAboutEventToTeachers(Event $event)
    {
        $this->notificationService->sendNotificationAboutEventToTeachers($event->id);
        flash('Påminnelsen har skickat till alla lärare.')->success();
        return redirect()->back();
    }

    public function sendNotificationAboutEventToVisitors(Event $event)
    {
        $this->notificationService->sendNotificationAboutEventToVisitors($event->id);
        flash('Påminnelsen har skickat till alla besökare.')->success();
        return redirect()->back();
    }

    public function sendTextMessageAboutEventToVisitors(Event $event)
    {
        $this->notificationService->sendTextMessageAboutEventToVisitors($event->id);
        flash('Påminnelsen har skickat till alla besökare.')->success();
        return redirect()->back();
    }

}
