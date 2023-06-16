<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

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

    protected $auth;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return \response()->json([
                'success' => false,
                'errors' => [
                    'You\'ve been locked out'
                ],
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        //attempt login with token
        if ($request->input('token')) {
            $this->auth->setToken($request->input('token'));

            $user = $this->auth->authenticate();

            if ($user) {
                return \response()->json([
                    'success' => true,
                    'data' => $request->user(),
                    'token' => $request->input('token'),
                ], 200);
            }
        }

        try {
            if (!$token = $this->auth->attempt($request->only('phone', 'password'))) {
                return \response()->json([
                    'success' => false,
                    'errors' => [
                        'text' => [
                            'Invalid phone or password'
                        ]
                    ]
                ], 422);
            }
        } catch (JWTException $exception) {
            return \response()->json([
                'success' => false,
                'errors' => [
                    'text' => [
                        'Invalid phone or password'
                    ]
                ]
            ], 422);
        }

        return \response()->json([
            'success' => true,
            'data' => $request->user(),
            'token' => $token,
        ], 200);
    }
}
