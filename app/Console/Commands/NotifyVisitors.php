<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class NotifyVisitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:visitors-email {event}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mail to all visitors about their booked slots';

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
        $this->notificationService->sendNotificationAboutEventToVisitors($this->argument('event'));
    }
}
