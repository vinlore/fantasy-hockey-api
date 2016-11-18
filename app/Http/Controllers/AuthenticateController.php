<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response;

use App\Models\User;
use JWTAuth;

class AuthenticateController extends Controller
{
    public function register(RegisterRequest $request) {
        $credentials = [
            'username' => $request->get('username'),
            'password' => bcrypt($request->get('password'))
        ];

        try {
            $user = User::create($credentials);
        } catch (Exception $e) {
            return response()->json(['error' => 'failed_to_create_user'], 500);
        }

        try {
            $token = JWTAuth::fromUser($user);
            if (!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function login(Request $request) {
        $credentials = $request->only('username', 'password');
        
        try {
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
}
