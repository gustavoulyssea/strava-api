<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'strava:updatetoken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Strava Api Token';

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
        $api = new \App\Http\Controllers\StravaApi();
        $token = $api->getToken(true);
    }
}
