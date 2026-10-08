<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'Account | My Blog')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        :root {
            color-scheme: light;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --dark: #0f172a; e
            --bg-surface: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--text-main);
            background: var(--bg-surface);
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: var(--primary); }

        .split-layout {
            display: flex;
            min-height: 100vh;
        }

        .left-panel {
            display: none;
            flex: 1;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            position: relative;
            overflow: hidden;
            color: white;
            padding: 64px 56px;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            min-height: 100vh;
        }

        @media (min-width: 900px) {
            .left-panel {
                display: flex;
            }
        }

        .left-panel::before, .left-panel::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.02);
        }

        .left-panel::before {
            width: 800px;
            height: 800px;
            top: -300px;
            left: -300px;
            box-shadow: 0 0 120px rgba(79, 70, 229, 0.3) inset;
        }

        .left-panel::after {
            width: 600px;
            height: 600px;
            bottom: -200px;
            right: -200px;
            background: radial-gradient(circle, rgba(79,70,229,0.15) 0%, transparent 70%);
        }

        .floating-dots {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 400px;
            transform: translate(-50%, -50%);
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 2px, transparent 2px);
            background-size: 32px 32px;
            z-index: 1;
        }

        .brand-large {
            position: relative;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            color: white;
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: -0.035em;
            margin-bottom: 56px;
        }

        .tagline {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            margin: 0;
            text-align: left;
        }
        .tagline h2 {
            font-size: 38px;
            line-height: 1.2;
            margin: 0 0 16px;
            letter-spacing: -0.035em;
            font-weight: 800;
        }
        .tagline p {
            font-size: 17px;
            color: #cbd5e1;
            line-height: 1.65;
            margin: 0;
        }

        .right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 64px 20px;
            max-width: 100%;
            min-height: 100vh;
        }
        @media (min-width: 900px) {
            .right-panel {
                max-width: 50%;
                padding: 64px 48px;
            }
        }

        .auth-shell {
            width: 100%;
            max-width: 440px;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-mobile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 auto 24px;
            color: var(--text-main);
            font-size: 20px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: -0.03em;
            width: fit-content;
        }

        .brand-mobile .brand-mark {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 10px;
            background: linear-gradient(145deg, #6366f1, #4f46e5);
            color: white;
            font-size: 20px;
        }

        @media (min-width: 900px) {
            .brand-mobile {
                display: none;
            }
        }

        .auth-card {
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.5);
        }

        .eyebrow {
            margin: 0 0 10px;
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        h1 { margin: 0; color: var(--dark); font-size: 30px; line-height: 1.2; letter-spacing: -0.04em; font-weight: 800; }
        .auth-description { margin: 10px 0 30px; color: var(--text-muted); font-size: 15px; line-height: 1.6; }

        .form-stack { display: grid; gap: 20px; }
        .form-field { display: grid; gap: 8px; }
        .form-field label { color: #334155; font-size: 14px; font-weight: 600; }
        .field-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .field-label-row label {
            margin: 0;
        }
        .field-label-row a {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }
        .field-label-row a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }
        .form-field input {
            width: 100%;
            min-height: 52px;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            background: white;
            color: var(--text-main);
            font: inherit;
            font-size: 15px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-field input::placeholder { color: #94a3b8; }
        .form-field input:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15); 
        }

        .primary-button {
            display: flex;
            width: 100%;
            min-height: 52px;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(145deg, #6366f1, #4f46e5);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
            color: white;
            cursor: pointer;
            font: inherit;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .primary-button:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.35);
        }
        .primary-button:active { transform: translateY(0); }

        .social-divider { display: flex; align-items: center; gap: 12px; margin: 26px 0 18px; color: #94a3b8; font-size: 13px; font-weight: 500;}
        .social-divider::before, .social-divider::after { content: ""; flex: 1; height: 1px; background: var(--border-color); }
        .social-login { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .social-button {
            display: flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: white;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .social-button:hover { 
            border-color: #cbd5e1; 
            background: #f8fafc; 
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05); 
        }
        .social-button svg { width: 20px; height: 20px; flex: 0 0 20px; }
        
        .auth-links { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 24px; color: var(--text-muted); font-size: 14px; }
        .auth-links a, .center-link a { font-weight: 600; text-decoration: none; color: var(--primary); transition: color 0.2s; }
        .auth-links a:hover, .center-link a:hover { color: var(--primary-hover); text-decoration: underline; }
        .center-link { margin: 24px 0 0; color: var(--text-muted); font-size: 14px; text-align: center; }

        .notice, .error-list { margin: 0 0 20px; padding: 14px 16px; border-radius: 10px; font-size: 14px; line-height: 1.5; }
        .notice { position: relative; padding-right: 42px; border: 1px solid #86efac; background: #f0fdf4; color: #166534; transition: opacity .35s ease, transform .35s ease; }
        .notice.is-leaving { opacity: 0; transform: translateY(-6px); }
        .notice-dismiss { position: absolute; top: 5px; right: 7px; width: 32px; height: 32px; border: 0; border-radius: 7px; color: inherit; background: transparent; font-size: 20px; cursor: pointer; }
        .error-list { padding-left: 36px; border: 1px solid #fca5a5; background: #fef2f2; color: #991b1b; }

        .page-bottom { margin: 24px 0 0; color: #94a3b8; font-size: 14px; text-align: center; font-weight: 500; }
        .page-bottom a { color: inherit; text-decoration: none; transition: color 0.2s; }
        .page-bottom a:hover { color: var(--text-main); }

        @media (max-width: 520px) {
            .auth-card { padding: 32px 24px; border-radius: 16px; }
            h1 { font-size: 26px; }
        }
        @media (max-width: 360px) {
            .social-login { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <!-- Left Panel: Hidden on mobile, visible on desktop -->
        <div class="left-panel">
            <div class="floating-dots"></div>
            
            <a class="brand-large" href="{{ route('home') }}">
                <span>My Blog</span>
            </a>

            <div class="tagline">
                <h2>Welcome to your creative space.</h2>
                <p>Join our community, share your ideas, and connect with readers from around the world.</p>
            </div>
        </div>

        <!-- Right Panel: The form -->
        <div class="right-panel">
            <div class="auth-shell">
                <!-- Mobile brand (visible only on mobile) -->
                <a class="brand-mobile" href="{{ route('home') }}">
                    <span>My Blog</span>
                </a>

                <main class="auth-card">
                    <p class="eyebrow">Your account</p>
                    <h1>@yield('heading')</h1>
                    <p class="auth-description">@yield('description')</p>

                    @if (session('status'))
                        <div class="notice" role="status" aria-live="polite" data-auto-dismiss>
                            {{ session('status') }}
                            <button type="button" class="notice-dismiss" aria-label="Dismiss notification">&times;</button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <ul class="error-list" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @yield('content')
                </main>

                <p class="page-bottom"><a href="{{ route('home') }}">Back to blog</a></p>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('[data-auto-dismiss]').forEach((notice) => {
            const dismiss = () => {
                notice.classList.add('is-leaving');
                window.setTimeout(() => notice.remove(), 400);
            };
            window.setTimeout(dismiss, 5000);
            notice.querySelector('.notice-dismiss')?.addEventListener('click', dismiss);
        });
    </script>
</body>
</html>
