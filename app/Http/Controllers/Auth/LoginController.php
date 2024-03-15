<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        
        $validated = $request->validated();
        $user = User::where('email', $validated->email)->first();
        if(!$user || !Hash::check($validated->password, $user->password)){
            throw ValidationException::withMessages([
                'message' => 'The credentials are not correct'
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('api_restful_laravel')->plainTextToken
        ], Response::HTTP_ACCEPTED);
    }
}
