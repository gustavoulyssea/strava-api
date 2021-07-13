<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\StravaActivityController;

class ImportClubActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'strava:importgroupactivities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import group activities';

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
        $this->line('Start importing...');
        $controller = new StravaActivityController;
        $controller->importGroupActivities(830751);
        $this->line('Finished.');
        return 0;
    }
}
