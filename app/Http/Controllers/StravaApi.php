<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\StravaConfig;
use App\ConfigNames;

class StravaApi extends Controller
{
    protected $options;
    protected $url;

    public function __construct()
    {
        $this->url = "https://www.strava.com/api/v3";
    }


    /*
     * Pagination
Requests that return multiple items will be paginated to 30 items by default.
    The page parameter can be used to specify further pages or offsets.
    The per_page may also be used for custom page sizes up to 200.
    Note that in certain cases, the number of items returned in the response may be lower than the requested page size,
    even when that page is not the last. If you need to fully go through the full set of results,
    prefer iterating until an empty page is returned.


     */

    public function apiRequest($url, $method = "GET", $json = "")
    {
//        $this->_mlogger->info("ameRequest starting...");
        $_token = $this->getToken();
        if (!$_token) return false;
        $method = strtoupper($method);
        $url = $this->url . $url;
//        $this->_mlogger->info("ameRequest URL:" . $url);
//        $this->_mlogger->info("ameRequest METHOD:" . $method);
        if ($json) {
//            $this->_mlogger->info("ameRequest JSON:" . $json);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $_token));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        if ($method == "POST" || $method == "PUT") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
//        $this->_mlogger->info("ameRequest OUTPUT:" . $result);
//        $this->_logger->log(curl_getinfo($ch, CURLINFO_HTTP_CODE), "header", $url, $json);
//        $this->_logger->log($result, "info", $url, $json);
        curl_close($ch);
        return $result;
    }

    public function getToken($forceUpdate = false)
    {
        if(!$forceUpdate
            && time()<=StravaConfig::where('config_name',ConfigNames::TOKEN_EXPIRES_AT)->first()->config_value-3600)
            return StravaConfig::where('config_name',ConfigNames::ACCESS_TOKEN)->first()->config_value;

        $post = array(
            'client_id' =>  env('STRAVA_CLIENT_ID'),
            'client_secret' => env('STRAVA_CLIENT_SECRET'),
            'grant_type' => 'refresh_token',
            'refresh_token' => StravaConfig::where('config_name',ConfigNames::REFRESH_TOKEN)->first()->config_value
        );

        $url = $this->url . "/oauth/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
        ));
        $result = curl_exec($ch);
        $json_array = json_decode($result,true);

        if(json_last_error()) return false;

        StravaConfig::where('config_name',ConfigNames::ACCESS_TOKEN)
            ->update(['config_value' => $json_array['access_token']]);
        StravaConfig::where('config_name',ConfigNames::TOKEN_EXPIRES_AT)
            ->update(['config_value' => time() + $json_array['expires_in']]);
        StravaConfig::where('config_name',ConfigNames::REFRESH_TOKEN)
            ->update(['config_value' => $json_array['refresh_token']]);

        return $json_array['access_token'];
    }
}
