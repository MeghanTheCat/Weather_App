<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\WeatherService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizeRequests;

class AuthController extends Controller
{
    public function token(Request $request) : JsonResponse {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessage([
                'email' => ['The provided credentials are incorrects.'],
            ]);
        }

        $user->tokens()->where('name', $request->device_name)->delete();

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }

    public function disconnect(Request $request) : JsonResponse {
        $request->user()->currentAccessToken()->delete();
        return reponse()->json(['message' => 'User sucessfully disconnected']);
    }
}
