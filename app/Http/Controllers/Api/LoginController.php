<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Modules\Base\Models\Activity;
use App\Modules\Base\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LoginController extends ApiController
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        Activity::create([
            'action' => 'Register',
            'description' => 'A user was registered into the system',
            'data' => $user->makeHidden(['roles', 'userRoleLabel', 'verifiedStatusBadge', 'verifiedStatus'])
        ]);

        return $this->response(['user' => $user, 'access_token' => $token], 'register success');
    }

    public function login(Request $request)
    {

        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', $loginUserData['email'])->first();

        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return $this->response([], 'invalid credentials', 400);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        Activity::create([
            'action' => 'Login',
            'description' => 'A user has logged into the system',
            'data' => $user->makeHidden(['roles', 'userRoleLabel', 'verifiedStatusBadge', 'verifiedStatus'])
        ]);

        return $this->response([
            'access_token' => $token,
            'user' => $user
        ], 'login success');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? $this->response([], __($status))
            : $this->response([], __($status), 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        $user = User::where('email', $request->email)->first();

        Activity::create([
            'action' => 'Reset Password',
            'description' => 'A user ',
            'data' => $user->makeHidden(['roles', 'userRoleLabel', 'verifiedStatusBadge', 'verifiedStatus'])
        ]);

        return $this->response([], __($status), $status === Password::PASSWORD_RESET ? 200 : 400);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        Activity::create([
            'action' => 'Logout',
            'description' => 'A user has logged out from the system',
            'data' => auth()->user()->makeHidden(['roles', 'userRoleLabel', 'verifiedStatusBadge', 'verifiedStatus'])
        ]);

        return $this->response([], 'logout success');
    }
}
