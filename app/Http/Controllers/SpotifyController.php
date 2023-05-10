<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{

    private string $accessToken;

    public function __construct()
    {
        $this->accessToken = env('SPOTIFY_ACCESS_TOKEN');
    }

    public function getToken(){

        $client = new Client();
        $response = $client->request("POST", "https://accounts.spotify.com/api/token", [
            "headers" => [
                "Content-Type" => "application/x-www-form-urlencoded",
            ],
            "query" => [
                "grant_type" => "client_credentials",
                "client_id" => env("SPOTIFY_CLIENT_ID"),
                "client_secret" => env("SPOTIFY_CLIENT_SECRET")
            ]

        ]);

        $result = json_decode($response->getBody());

        $this->accessToken = $result->access_token;

        return $result;
        
    }

    public function getArtist($idArtist){


        $client = new Client();
        $response = $client->request("GET", "https://api.spotify.com/v1/artists/$idArtist", [
            "headers" => [
                "Authorization" => "Bearer ".$this->accessToken,
            ]

        ]);

        $result = json_decode($response->getBody());

        return $result;

    }

}
