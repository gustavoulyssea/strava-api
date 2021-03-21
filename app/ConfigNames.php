<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigNames extends Model
{
    const ACCESS_TOKEN = 'strava_api_access_token';
    const REFRESH_TOKEN = 'strava_api_refresh_token';
    const TOKEN_EXPIRES_AT = 'strava_api_token_expires_at';
    const CLIENT_ID = 'STRAVA_CLIENT_ID';
    const CLIENT_SECRET = 'STRAVA_CLIENT_SECRET';
}
