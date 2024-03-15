<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        //
        $user = User::create($request->getData());

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('api_restful_laravel')->planTextToken
        ], Response::HTTP_CREATED);
    }
}
