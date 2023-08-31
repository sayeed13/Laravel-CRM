<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Lead;
use App\Models\Remineder;
use App\Models\User;
use Illuminate\Console\Command;
use App\Notifications\FloatingNotification;
use Illuminate\Support\Facades\Notification;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
    }

    
}
