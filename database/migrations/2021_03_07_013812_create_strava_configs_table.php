<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateStravaConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strava_configs', function (Blueprint $table) {
            $table->id();
            $table->string('config_name');
            $table->string('config_value');
            $table->timestamps();
        });
        $config = new \App\StravaConfig();
        $config->config_name = "strava_api_access_token";
        $config->config_value = "";
        $config->save();
        unset($config);

        $config = new \App\StravaConfig();
        $config->config_name = "strava_api_refresh_token";
        $config->config_value = env('STRAVA_TOKEN_REFRESH');
        $config->save();
        unset($config);

        $config = new \App\StravaConfig();
        $config->config_name = "strava_api_token_expires_at";
        $config->config_value = "0";
        $config->save();
        unset($config);
    }
    public function getConfigs()
    {
        return [
            'STRAVA_CLIENT_ID',
            'STRAVA_CLIENT_SECRET',
            'STRAVA_ACCESS_TOKEN',
            'STRAVA_TOKEN_REFRESH',
            'STRAVA_15_MIN_LIMIT',
            'STRAVA_DAILY_LIMIT'
        ];
    }
    public function validateConfigs()
    {
        $configs = $this->getConfigs();

        foreach ($configs as $config) {
            if (!env($config)) {
                echo "Please set ".$config." on .env to continue.";
                return 0;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strava_configs');
    }
}
