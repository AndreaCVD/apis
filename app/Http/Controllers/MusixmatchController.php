<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class MusixmatchController extends Controller
{


    public function auth_token($token){

        // Decodificar token JWT y validar firma
        try {

            $payload = JWT::decode($token, new Key(env('JWT_SECRET'),'HS512'));

            return true;

        } catch (Exception $e) {
            
            return false;
        }
        
    }

    public function getChartArtist(Request $request){

        $page = request()->query("page");
        $page_size = request()->query("page_size");
        $country = request()->query("country");

        $client = new Client();

        // Obtener token JWT del encabezado de autorización
        $token = $request->bearerToken();

        $auth = $this->auth_token($token);


        if ($auth) {

            $response = $client->request("GET", "https://api.musixmatch.com/ws/1.1/chart.artists.get", [
                "query" => [
                    "page"   => $page,
                    "papage_sizege"   => $page_size,
                    "country"   => $country,
                    "apikey" => env('MUSIXMATCH_API_KEY')
                ]

            ]);

            //recogemos el resultado de la peticion y lo pasamos como json
            $result = json_decode($response->getBody());

            return $result;

        } else {

            return "Token invalido";
        }     


    }

    public function getTracksArtist(Request $request){

        $page = request()->query("page");
        $page_size = request()->query("page_size");
        $country = request()->query("country");
        $chart_name = request()->query("chart_name");

        $client = new Client();

        // Obtener token JWT del encabezado de autorización
        $token = $request->bearerToken();

        $auth = $this->auth_token($token);


        if ($auth) {

            $response = $client->request("GET", "https://api.musixmatch.com/ws/1.1/chart.tracks.get", [
                "query" => [
                    "page"   => $page,
                    "papage_sizege"   => $page_size,
                    "country"   => $country,
                    "chart_name" => $chart_name,
                    "apikey" => env('MUSIXMATCH_API_KEY')
                ]

            ]);

            //recogemos el resultado de la peticion y lo pasamos como json
            $result = json_decode($response->getBody());

            return $result;

        } else {

            return "Token invalido";
        }     


    }

    public function getGenresArtist(Request $request){

        $page = request()->query("page");
        $page_size = request()->query("page_size");
        $country = request()->query("country");

        $client = new Client();

        // Obtener token JWT del encabezado de autorización
        $token = $request->bearerToken();

        $auth = $this->auth_token($token);


        if ($auth) {

            $response = $client->request("GET", "https://api.musixmatch.com/ws/1.1/music.genres.get", [
                "query" => [
                    "apikey" => env('MUSIXMATCH_API_KEY')
                ]

            ]);

            //recogemos el resultado de la peticion y lo pasamos como json
            $result = json_decode($response->getBody());

            return $result;

        } else {

            return "Token invalido";
        }     


    }

}
