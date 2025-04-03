<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        event(new UserRegistered($user));

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request){
        $validatedData = $request->validated();
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ];

        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'error' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);

            }

        } catch (JWTException) {
            return response()->json([
                'error' => 'No se pudo generar el token',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondwithToken($token);
    }

    protected function respondwithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
        ]);
    }

    public function who(){
        $user = auth()->user();
        return response()->json($user);
    }

    public function logout(){
        try{
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
            return response()->json([
                'message' => 'Sesion cerrada correctamente',
            ], Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'No se pudo cerrar la sesion, el token no es valido',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh(){
        try{
            $token = JWTAuth::getToken();
            $newToken = JWTAuth::refresh($token);
            JWTAuth::invalidate($token);
            JWTAuth::setToken($newToken)->toUser();
            return $this->respondwithToken($newToken);
        } catch (JWTException $e) {
            return response()->json([ 
                'error' => 'No se pudo refrescar el token',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
