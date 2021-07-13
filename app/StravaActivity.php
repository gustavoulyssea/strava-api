<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StravaActivity extends Model
{
    protected $table = 'strava_activities';
    protected $fillable = array('activity_json');
    protected $guarded = array('id');
}
