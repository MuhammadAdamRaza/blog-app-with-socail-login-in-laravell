<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User as SocialiteUser;
use Throwable;

class SocialAuthController extends Controller
{
    /**
     * Get the configured Socialite driver instance.
     * In local development (e.g. Windows/XAMPP), bypass cURL SSL certificate verification.
     *
     * @param string $provider
     * @return AbstractProvider
     */
    protected function driver(string $provider): AbstractProvider
    {
        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);

        if (app()->environment('local')) {
            $driver->setHttpClient(new Client([
                'verify' => false,
                'timeout' => 15,
            ]));
        }

        return $driver;
    }

    public function redirectToGoogle()
    {
        return $this->driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            /** @var SocialiteUser $googleUser */
            $googleUser = $this->driver('google')->user();
        } catch (Throwable $exception) {
            Log::warning('Google OAuth callback failed.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('login')->withErrors([
                'social' => 'Google sign-in could not be completed. Please try again.',
            ]);
        }

        $account = SocialAccount::where('provider', 'google')
            ->where('provider_id', (string) $googleUser->getId())
            ->first();

        if ($account) {
            Auth::login($account->user);
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        $email = strtolower(trim((string) $googleUser->getEmail()));
        $profile = $googleUser->getRaw();
        $emailVerified = ($profile['email_verified'] ?? $profile['verified_email'] ?? false) === true;

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $emailVerified) {
            return redirect()->route('login')->withErrors([
                'social' => 'Google did not provide a verified email. Verify your email with Google and try again.',
            ]);
        }

        if (User::where('email', $email)->exists()) {
            return redirect()->route('login')->withErrors([
                'social' => 'This user already exists. Please sign in with your email and password.',
            ]);
        }

        $user = DB::transaction(function () use ($googleUser, $email) {
            $user = User::create([
                'name' => Str::limit(
                    $googleUser->getName() ?: Str::before($email, '@'),
                    255,
                    ''
                ),
                'email' => $email,
                'password' => Str::random(64),
                'email_verified_at' => now(),
            ]);

            $user->socialAccounts()->create([
                'provider' => 'google',
                'provider_id' => (string) $googleUser->getId(),
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function redirectToGithub()
    {
        return $this->driver('github')
            ->scopes(['user:email'])
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGithubCallback(Request $request)
    {
        try {
            /** @var SocialiteUser $githubUser */
            $githubUser = $this->driver('github')->user();
        } catch (Throwable $exception) {
            Log::warning('GitHub OAuth callback failed.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('login')->withErrors([
                'social' => 'GitHub sign-in could not be completed. Please try again.',
            ]);
        }

        $account = SocialAccount::where('provider', 'github')
            ->where('provider_id', (string) $githubUser->getId())
            ->first();

        if ($account) {
            Auth::login($account->user);
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        // The GitHub Socialite provider returns the primary verified email
        // when the user:email scope is granted.
        $email = strtolower(trim((string) $githubUser->getEmail()));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('login')->withErrors([
                'social' => 'GitHub did not provide a verified email. Add a verified email to GitHub and try again.',
            ]);
        }

        // GitHub's user:email scope returns the primary verified address. If
        // that address already belongs to a local account, link this GitHub
        // identity so future sign-ins go through the provider_id lookup above.
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            DB::transaction(function () use ($existingUser, $githubUser) {
                $existingUser->socialAccounts()->firstOrCreate([
                    'provider' => 'github',
                    'provider_id' => (string) $githubUser->getId(),
                ]);
            });

            Auth::login($existingUser);
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        $user = DB::transaction(function () use ($githubUser, $email) {
            $user = User::create([
                'name' => Str::limit(
                    $githubUser->getName() ?: $githubUser->getNickname() ?: Str::before($email, '@'),
                    255,
                    ''
                ),
                'email' => $email,
                'password' => Str::random(64),
                'email_verified_at' => now(),
            ]);

            $user->socialAccounts()->create([
                'provider' => 'github',
                'provider_id' => (string) $githubUser->getId(),
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function redirectToLinkedin()
    {
        return $this->driver('linkedin')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleLinkedinCallback(Request $request)
    {
        try {
            /** @var SocialiteUser $linkedinUser */
            $linkedinUser = $this->driver('linkedin')->user();
        } catch (Throwable $exception) {
            Log::warning('LinkedIn OAuth callback failed.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('login')->withErrors([
                'social' => 'LinkedIn sign-in could not be completed. Please try again.',
            ]);
        }

        $account = SocialAccount::where('provider', 'linkedin')
            ->where('provider_id', (string) $linkedinUser->getId())
            ->first();

        if ($account) {
            Auth::login($account->user);
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        $email = strtolower(trim((string) $linkedinUser->getEmail()));
        $profile = $linkedinUser->getRaw();
        $emailVerified = ($profile['email_verified'] ?? false) === true;

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $emailVerified) {
            return redirect()->route('login')->withErrors([
                'social' => 'LinkedIn did not provide a verified email. Verify your LinkedIn email and try again.',
            ]);
        }

        if (User::where('email', $email)->exists()) {
            return redirect()->route('login')->withErrors([
                'social' => 'This user already exists. Please sign in with your email and password.',
            ]);
        }

        $user = DB::transaction(function () use ($linkedinUser, $email) {
            $user = User::create([
                'name' => Str::limit(
                    $linkedinUser->getName() ?: Str::before($email, '@'),
                    255,
                    ''
                ),
                'email' => $email,
                'password' => Str::random(64),
                'email_verified_at' => now(),
            ]);

            $user->socialAccounts()->create([
                'provider' => 'linkedin',
                'provider_id' => (string) $linkedinUser->getId(),
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function redirectToFacebook()
    {
        return $this->driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        try {
            /** @var SocialiteUser $facebookUser */
            $facebookUser = $this->driver('facebook')->user();
        } catch (Throwable $exception) {
            Log::warning('Facebook OAuth callback failed.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('login')->withErrors([
                'social' => 'Facebook sign-in could not be completed. Please try again.',
            ]);
        }

        $account = SocialAccount::where('provider', 'facebook')
            ->where('provider_id', (string) $facebookUser->getId())
            ->first();

        if ($account) {
            Auth::login($account->user);
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        $email = strtolower(trim((string) $facebookUser->getEmail()));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('login')->withErrors([
                'social' => 'Facebook did not share an email address. Add an email to your Facebook account and grant the email permission.',
            ]);
        }

        if (User::where('email', $email)->exists()) {
            return redirect()->route('login')->withErrors([
                'social' => 'This user already exists. Please sign in with your email and password.',
            ]);
        }

        $user = DB::transaction(function () use ($facebookUser, $email) {
            $user = User::create([
                'name' => Str::limit(
                    $facebookUser->getName() ?: Str::before($email, '@'),
                    255,
                    ''
                ),
                'email' => $email,
                'password' => Str::random(64),
            ]);

            $user->socialAccounts()->create([
                'provider' => 'facebook',
                'provider_id' => (string) $facebookUser->getId(),
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
