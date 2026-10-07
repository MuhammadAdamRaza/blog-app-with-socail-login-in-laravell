<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            Password::sendResetLink($request->only('email'));
        } catch (Throwable $exception) {
            Log::error('Password reset email could not be sent.', [
                'exception' => $exception::class,
            ]);

            return redirect()->route('password.request')->withErrors([
                'email' => 'We could not send the reset email. Please check the mail settings and try again.',
            ]);
        }

        return redirect()->route('password.request')->with(
            'status',
            'If an account exists for that email, a password reset link has been sent.'
        );
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $credentials = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $resetUser = null;

        $status = Password::reset($credentials, function (User $user, string $password) use (&$resetUser) {
            $resetUser = $user;

            $user->forceFill([
                'password' => $password,
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET || ! $resetUser) {
            return back()->withErrors([
                'email' => 'This password reset link is invalid or expired.',
            ])->withInput($request->only('email'));
        }

        Auth::login($resetUser);
        $request->session()->regenerate();

        return redirect()->route('home')->with(
            'status',
            'Your password has been reset.'
        );
    }
}
