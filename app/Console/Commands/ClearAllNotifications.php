<?php

namespace App\Console\Commands;

use App\Models\DatabaseNotification;
use Illuminate\Console\Command;

class ClearAllNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:clear-all-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears all notifications for all users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DatabaseNotification::truncate();
    }
}
