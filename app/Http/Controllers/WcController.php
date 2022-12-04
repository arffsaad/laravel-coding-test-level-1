<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WcController extends Controller
{
    public function updateToken()
    {
        $client = new Client();
        $response = $client->post('http://api.cup2022.ir/api/v1/user/login', [
            'json' => [
                'email' => 'testing.ariff@gmail.com',
                'password' => 'Testing123'
            ]
        ]);
        // get response as json
        $response = json_decode($response->getBody()->getContents());
        $newToken = $response->data->token;
        Cache::forever('wcapitoken', $newToken);
    }

    public function getTeams(){
        $client = new Client();
        $token = Cache::get('wcapitoken');
        $response = $client->get('http://api.cup2022.ir/api/v1/team', [
            'headers' => [ 'Authorization' => 'Bearer ' . $token ]
        ]);
        $response = json_decode($response->getBody()->getContents());
        // return with code 200
        return response()->json($response->data, 200);
    }

    public function teamInfo(Request $request){
        $team = $request->input('id');
        $client = new Client();
        $token = Cache::get('wcapitoken');

        // First call to get team data
        $response = $client->get('http://api.cup2022.ir/api/v1/team/' . $team, [
            'headers' => [ 'Authorization' => 'Bearer ' . $token ]
        ]);
        $response1 = json_decode($response->getBody()->getContents());

        // another call to get standings
        $response = $client->get('http://api.cup2022.ir/api/v1/standings/'. $response1->data[0]->groups, [
            'headers' => [ 'Authorization' => 'Bearer ' . $token ]
        ]);
        $response2 = json_decode($response->getBody()->getContents());
        $ptsValues = array();
        foreach ($response2->data[0]->teams as $key) {
            // push as assoc array
            array_push($ptsValues, array('id' => $key->team_id, 'pts' => $key->pts));
        }
        usort($ptsValues, function($a, $b) {
            return $a['pts'] <=> $b['pts'];
        });
        $index = array_search($team, array_column($ptsValues, 'id'));
        if($index == 2 || $index == 3){
            array_push($response1->data, array('qualify' => 'YES'));
        }else{
            array_push($response1->data, array('qualify' => 'NO'));
        }
        return response()->json($response1->data, 200);
    }
}
