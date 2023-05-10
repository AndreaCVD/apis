<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;

class SpotifyController extends Controller
{

    private string $accessToken;

    public function __construct()
    {
        $this->accessToken = env('SPOTIFY_ACCESS_TOKEN');
    }

    public function getToken(){

        $client = new Client();

        //peticion para obtener el token con el que mas adelante haremos las peticiones
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

        //guardamos el resultado en formato json
        $result = json_decode($response->getBody());

        //y guardamos este token en la variable
        $this->accessToken = $result->access_token;

        return $result;
        
    }

    //endpoint para obtener la informacion de un artista segun el id que se envia por la ruta
    public function getArtist($idArtist){

        $client = new Client();

        //como el token de spotify caduca a la hora, tendremos que hacer comprobar si aun es valido, y si no
        //volver a generarlo

        try {
            
            $response = $client->request("GET", "https://api.spotify.com/v1/artists/$idArtist", [
                "headers" => [
                    "Authorization" => "Bearer ".$this->accessToken,
                ]
    
            ]);

        } catch (RequestException $exception) {
            //si salta un error por el token, lo volvemos a generar y lanzamos la peticion otra vez

            $this->getToken();

            $response = $client->request("GET", "https://api.spotify.com/v1/artists/$idArtist", [
                "headers" => [
                    "Authorization" => "Bearer ".$this->accessToken,
                ]
    
            ]);

        }

        //recogemos el resultado de la peticion y lo pasamos como json
        $result = json_decode($response->getBody());

        return $result;

    }


    //endpoint para obtener una cancion segun el id que se envia por la ruta
    public function getTrack($idTrack){

        $client = new Client();

        //como el token de spotify caduca a la hora, tendremos que hacer comprobar si aun es valido, y si no
        //volver a generarlo

        try {
            
            $response = $client->request("GET", "https://api.spotify.com/v1/tracks/$idTrack", [
                "headers" => [
                    "Authorization" => "Bearer ".$this->accessToken,
                ]
    
            ]);

        } catch (RequestException $exception) {
            //si salta un error por el token, lo volvemos a generar y lanzamos la peticion otra vez

            $this->getToken();

            $response = $client->request("GET", "https://api.spotify.com/v1/tracks/$idTrack", [
                "headers" => [
                    "Authorization" => "Bearer ".$this->accessToken,
                ]
    
            ]);

        }

        //recogemos el resultado de la peticion y lo pasamos como json
        $result = json_decode($response->getBody());

        return $result;

    }

}
