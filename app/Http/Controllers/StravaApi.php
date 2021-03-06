<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StravaApi extends Controller
{
    protected $options;

    /*
     * Pagination
Requests that return multiple items will be paginated to 30 items by default.
    The page parameter can be used to specify further pages or offsets.
    The per_page may also be used for custom page sizes up to 200.
    Note that in certain cases, the number of items returned in the response may be lower than the requested page size,
    even when that page is not the last. If you need to fully go through the full set of results,
    prefer iterating until an empty page is returned.


     */

    public function apiRequest()
    {
        try {
            $adapter = new \GuzzleHttp\Client(['base_uri' => 'https://www.strava.com/api/v3/']);
            $service = new \Strava\API\Service\REST($this->getToken(), $adapter);  // Define your user token here.
            $client = new \Strava\API\Client($service);

            $athlete = $client->getAthlete();
            print_r($athlete);

            $activities = $client->getAthleteActivities();
            print_r($activities);

            $club = $client->getClub(9729);
            print_r($club);
        } catch (\Strava\API\Exception $e) {
            print $e->getMessage();
        }
    }

    public function getToken()
    {
        $token = "f182fecfacc0792ab8a0febf5b1e444cb4de593c";
        $refreshToken = "5c7b72e7f5193759be7308fd5271f3bd345f7155";
        $isso = "curl -X POST https://www.strava.com/api/v3/oauth/token \
  -d client_id=ReplaceWithClientID \
  -d client_secret=ReplaceWithClientSecret \
  -d grant_type=refresh_token \
  -d refresh_token=ReplaceWithRefreshToken";

        try {
            $options = [
                'clientId'     => 62663,
                'clientSecret' => '565dafda1e29ff94f7f29ab8dd47a0e7d20c013e',
                'redirectUri'  => 'http://my-app/callback.php'
            ];
            $oauth = new \Strava\API\OAuth($options);

            if (!isset($_GET['code'])) {
                print '<a href="'.$oauth->getAuthorizationUrl([
                        // Uncomment required scopes.
                        'scope' => [
                            'public',
                            // 'write',
                            // 'view_private',
                        ]
                    ]).'">Connect</a>';
            } else {
                $token = $oauth->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
                print $token->getToken();
            }
        } catch(\Strava\API\Exception $e) {
            print $e->getMessage();
        }
    }
}
