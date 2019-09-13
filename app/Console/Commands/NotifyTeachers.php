<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class NotifyTeachers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:teachers {event}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all teachers about the booked schedule';

    /**
     * The notification service.
     *
     * @var \App\Services\NotificationService
     */
    private $notificationService;

    /**
     * Create a new command instance.
     *
     * @param \App\Services\NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->notificationService->sendNotificationAboutEventToTeachers($this->argument('event'));
    }
}
