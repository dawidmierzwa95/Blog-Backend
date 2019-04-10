<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login user
     *
     * @param  Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $request->validate([
                            'email' => 'required|string|email',
                            'password' => 'required|string',
                        ]);

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials))
        {
            $user = $request->user();
            $user->createApiToken();

            return ['user' => $user->makeVisible(['email', 'api_token'])];
        }

        return [];
    }
}
