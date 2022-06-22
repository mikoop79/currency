<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $requestData['password'] = Hash::make($requestData['password']);

        User::create($requestData);

        return response(['status' => true, 'message' => 'User successfully register.'], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Check your Login credentials'], 422);
        }

        $accessToken = Auth::user()->createToken('apitoken')->accessToken;

        $request->session()->regenerate();


        return response()->json(['user' => auth()->user(), 'access_token' => $accessToken], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->guard('web')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user()
    {
        return Auth::check() ? Auth::user() : [];
    }
}
