<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            return redirect()->back()->with('error', 'Invalid credentials!');
        }

        $request->session()->regenerate();

        return redirect('/')->with('success', 'Welcome ' . auth()->user()->name);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed'],
        ]);

        // Hash password
        $credentials['password'] = bcrypt($credentials['password']);

        // Create new user
        $user = User::create($credentials);

        // Log in user
        auth()->login($user);

        return redirect('/')->with('success', 'Account created successfully.');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }

    public function showPasswordReset()
    {
        return view('auth.forgot-password');
    }

    public function passwordResetPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email does not exist!'])->onlyInput('email');
        }

        $token = Str::random(length: 64);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Mail::send("emails.password-reset", ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Password');
        });

        return redirect('/forgot-password')->with('success', 'We have sent you an email to reset your password.');
    }

    public function resetPassword($token)
    {
        return view('auth.new-password', compact('token'));
    }

    public function resetPasswordPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
            'token' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email does not exist!'])->withInput($request->only('email'));
        }

        $checkToken = DB::table('password_reset_tokens')->where([
            'email' => $user->email,
            'token' => $request->token,
        ])->first();

        if (!$checkToken) {
            return redirect()->back()->withErrors(['token' => 'Invalid token!'])->withInput($request->only('email'));
        }

        $user->update(["password" => bcrypt($credentials['password'])]);

        // Delete the token only after the password has been successfully updated
        DB::table('password_reset_tokens')->where([
            'email' => $user->email
        ])->delete();

        return redirect('/login')->with('success', 'Password updated successfully!');
    }
}
