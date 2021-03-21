<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StravaConfig extends Model
{
    protected $table = 'strava_configs';
    protected $fillable = array('config_name', 'config_value');
    protected $guarded = array('id');
}
