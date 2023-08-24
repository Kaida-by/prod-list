<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public bool $loginAfterSignUp = true;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = '';

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $this->create($request->all());

        if ($this->loginAfterSignUp) {
            $token = auth()->attempt($request->only('phone', 'password'));

            return response()->json([
                'status' => true,
                'data' => $request->user(),
                'token' => $token,
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $user,
            'token' => auth()->attempt($request->only('phone', 'password')),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'color_palette_id' => 1,
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
