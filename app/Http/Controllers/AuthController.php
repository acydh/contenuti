<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Logs in a user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $credentials['email'] = $request->input('email');
        $credentials['password'] = $request->input('password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => 401, 'message' => 'Unauthorized']);
        }

        $user = User::where('email', $credentials['email'])->first();

        if (!Hash::check($credentials['password'], $user->password, [])) {
            throw new \Exception('Exception in login');
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json(['status' => 200, 'access_token' => $tokenResult, 'token_type' => 'Bearer',]);
    }

    /**
     * Logs out a user
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 200,]);
    }
}
