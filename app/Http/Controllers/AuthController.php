<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
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
}
