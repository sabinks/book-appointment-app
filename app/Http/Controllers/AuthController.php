<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|lowercase|max:255',
            'password' => 'required|min:8|confirmed',
            'profile_image' =>  'file|max:2048'
        ]);

        $fields = $request->only(['name', 'email', 'password']);
        if ($request->hasFile('profile_image')) {
            $profileImage = new ProfileImageController();
            $fields = $profileImage->formProfileImageStore($request, $fields);
        }
        $role = Role::whereName('Member')->first();
        $user = User::create($fields);
        $user->assignRole($role->name);

        // Auth::login($user);

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|lowercase',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|lowercase|regex:/^\S*$/u',
            ]);
            $status = Password::sendResetLink(
                $request->only('email')
            );
            session()->flush();
            if ($status == 'passwords.sent') {
                return redirect('/login')
                    ->with('message', 'Password reset link sent, please check your email address for password reset link!');
                // return Inertia::render('ForgotPassword', [
                //     'message' => 'Password reset link sent, please check your email address for password reset link!'
                // ]);
            } else {
                return redirect('/login')->with('message', 'Password Forgot: Error occured!');
                // return Inertia::render('ForgotPassword', [
                //     'message' => 'Password Forgot: Error occured!'
                // ]);
            }
        } catch (\Throwable $th) {
            // throw $th;
            Log::info(json_encode($th));
        }
    }
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required|email|lowercase|regex:/^\S*$/u',
                'password' => 'required|min:8'
            ]);
            if ($validator->fails()) {

                return response($validator->errors(), 422);
            }
            $status = Password::reset(
                $request->only('email', 'password', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));
                }
            );
            if ($status == 'passwords.reset') {
                return redirect('/login')->with('message', 'Password reset completed, please login using new credentials!');
            } else {
                return redirect('/login')->with('message', 'Password Reset: Error occured!');
            }
        } catch (\Throwable $th) {
            // throw $th;
            Log::info(json_encode($th));
        }
    }
}
