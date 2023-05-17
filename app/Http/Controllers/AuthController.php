<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function signin(Request $request){

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = new User();

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');

        $user->save();
        
    }

    public function login(Request $request){

        $name = $request->get('name');
        $password = $request->get('password');

        $user = User::where('name', $name)->first();


        if($user == null){
            dd("No existe ese usuario");
        } else {
            if($user->password != $password){
                dd("password not correct");
            } else {

                // Generar token JWT con la información del usuario
                $payload = [
                    'sub' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'iat' => time(),
                    'exp' => time() + (60 * 120) // Token expira en 2 horas
                ];

                $token = JWT::encode($payload, env('JWT_SECRET'), 'HS512');

                // $user->remember_token = $token;
                // $user->save();

                // Devolvemos el token JWT al cliente
                return response()->json(['token' => $token]);
            }            
        }




    }

    public function logout(){

        //Cambio el token y no se lo devuelvo al usuario, de esta forma invalido el token anterior y si el usuario quiere hacer alguna peticion
        // deberá iniciar sesion de nuevo      

        $payload = [
            'sub' => 0,
            'name' => "unknow",
            'email' => "unknow",
            'iat' => time(),
            'exp' => time() + (60 * 120) // Token expira en 2 horas
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS512');

        return response()->json(['token' => $token]);

    }


//     Signin – Registro del usuario. Insertará el usuario 
//     en la BBDD.
//      Login - Validará el token y lo emitirá al usuario.
//     o Extra: Permitir que el usuario pueda loguearse 
//     a través de OAuth2.0 con Laravel/Socialite.
//      Logout – Revocará el token al usuario
}
