<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\StravaConfig;
use App\ConfigNames;
use App\Http\Controllers\StravaApi;
use App\StravaActivity;


class StravaActivityController extends Controller
{
    protected $options;
    protected $url;

    public function __construct()
    {
        $this->url = "https://www.strava.com/api/v3";
    }
    public function importGroupActivities($groupId)
    {
        $api = new \App\Http\Controllers\StravaApi();
        for ($page=1;$page<=10;$page++) {
            $json = $api->getClubActivities($groupId, $page);
            $activities = json_decode($json, true);
            foreach ($activities as $activity) {
                $this->insertActivity(json_encode($activity, JSON_PRETTY_PRINT));
            }
        }
    }
    public function insertActivity($json)
    {
        if (StravaActivity::where('activity_json', $json)->count()) {
            return;
        }
        $activity = new StravaActivity;
        $activity->activity_json = $json;
        $activity->save();
    }
}
