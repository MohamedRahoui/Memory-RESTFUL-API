<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['logout', 'getMe']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|max:100',
            'occupation' => 'required|max:255',
            'email' => 'required|max:255|unique:users|email',
            'password' => 'required|between:6,25',
        ]);
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->api_token = str_random(60);
        $user->save();
        return response()->json($user);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)
            ->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // generate new api token
            $user->api_token = str_random(60);
            $user->save();
            return response()
                ->json($user);
        }
        return response()
            ->json([
                "errors" => ["email" => ["Try again :-)"]]
            ], 422);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->api_token = null;
        $user->save();
        return response()
            ->json([
                'done' => true
            ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMe()
    {
        return response()
            ->json(Auth::user());
    }

}

