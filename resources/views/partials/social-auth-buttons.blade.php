<div class="social-divider"><span>{{ $prompt ?? 'Or continue with' }}</span></div>
<div class="social-login">
    <a class="social-button" href="{{ rtrim(config('services.google.base_url') ?: url('/'), '/') . '/auth/google/redirect' }}">
        <svg viewBox="0 0 48 48" aria-hidden="true" focusable="false">
            <path fill="#4285F4" d="M43.6 24.5c0-1.4-.1-2.8-.4-4.1H24v7.8h11c-.5 2.5-1.9 4.7-4.1 6.1v5.1h6.6c3.9-3.6 6.1-8.8 6.1-14.9z"/>
            <path fill="#34A853" d="M24 44c5.5 0 10.1-1.8 13.5-4.8l-6.6-5.1c-1.8 1.2-4.1 2-6.9 2-5.3 0-9.8-3.6-11.4-8.4H5.8v5.3C9.1 39.5 15.9 44 24 44z"/>
            <path fill="#FBBC05" d="M12.6 27.7c-.4-1.2-.7-2.4-.7-3.7s.2-2.5.7-3.7v-5.3H5.8a20 20 0 000 18l6.8-5.3z"/>
            <path fill="#EA4335" d="M24 12c3 0 5.7 1 7.9 3l5.9-5.9C34.1 5.8 29.5 4 24 4 15.9 4 9.1 8.5 5.8 15l6.8 5.3c1.6-4.8 6.1-8.3 11.4-8.3z"/>
        </svg>
        <span>Google</span>
    </a>
    <a class="social-button" href="{{ rtrim(config('services.github.base_url') ?: url('/'), '/') . '/auth/github/redirect' }}">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M12 .7a11.3 11.3 0 0 0-3.57 22.02c.57.1.77-.25.77-.55v-2.1c-3.15.69-3.82-1.34-3.82-1.34-.52-1.32-1.26-1.67-1.26-1.67-1.03-.7.08-.69.08-.69 1.14.08 1.74 1.17 1.74 1.17 1.02 1.74 2.67 1.24 3.32.95.1-.74.4-1.24.72-1.53-2.51-.29-5.15-1.26-5.15-5.6 0-1.24.44-2.25 1.17-3.04-.12-.29-.51-1.44.11-3 0 0 .95-.3 3.11 1.16a10.8 10.8 0 0 1 5.66 0c2.16-1.46 3.1-1.16 3.1-1.16.63 1.56.24 2.71.12 3 .73.79 1.16 1.8 1.16 3.04 0 4.35-2.64 5.3-5.16 5.59.41.36.77 1.04.77 2.1v3.12c0 .3.2.65.78.54A11.3 11.3 0 0 0 12 .7z"/>
        </svg>
        <span>GitHub</span>
    </a>
    <a class="social-button" href="{{ rtrim(config('services.linkedin.base_url') ?: url('/'), '/') . '/auth/linkedin/redirect' }}">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <rect width="24" height="24" rx="4" fill="#0A66C2"/>
            <path fill="#fff" d="M7.1 9.1a1.35 1.35 0 1 0 0-2.7 1.35 1.35 0 0 0 0 2.7ZM5.95 10.1h2.3v7.95h-2.3V10.1Zm3.75 0h2.2v1.08h.03c.31-.59 1.08-1.21 2.22-1.21 2.37 0 2.81 1.56 2.81 3.59v4.49h-2.3v-3.98c0-.95-.02-2.17-1.32-2.17-1.32 0-1.52 1.03-1.52 2.1v4.05H9.7V10.1Z"/>
        </svg>
        <span>LinkedIn</span>
    </a>
    <a class="social-button" href="{{ rtrim(config('services.facebook.base_url') ?: url('/'), '/') . '/auth/facebook/redirect' }}">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <rect width="24" height="24" rx="5" fill="#1877F2"/>
            <path fill="#fff" d="M13.3 20v-7.3h2.45l.37-2.85H13.3V8.03c0-.83.23-1.4 1.42-1.4h1.51V4.08A20 20 0 0 0 14.03 4c-2.18 0-3.67 1.33-3.67 3.78v2.07H7.9v2.85h2.46V20h2.94Z"/>
        </svg>
        <span>Facebook</span>
    </a>
</div>
