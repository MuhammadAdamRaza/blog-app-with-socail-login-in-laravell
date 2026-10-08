<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ $siteName ?? 'My Blog' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { color-scheme: light; --primary:#4f46e5; --primary-hover:#4338ca; --ink:#0f172a; --muted:#64748b; --bg:#f1f5f9; --surface:#fff; --border:#e2e8f0; --danger:#dc2626; --radius:14px; }
        *,*::before,*::after { box-sizing:border-box; }
        body { display:flex; flex-direction:column; margin:0; min-height:100vh; background:var(--bg); color:var(--ink); font:400 15px/1.6 Inter,ui-sans-serif,system-ui,sans-serif; }
        a { color:var(--primary); text-decoration:none; }
        a:hover { color:var(--primary-hover); }
        button,input,textarea,select { font:inherit; }
        button { cursor:pointer; }
        .app-header { position:sticky; top:0; z-index:20; color:#fff; background:linear-gradient(135deg,#0f172a,#1e1b4b); box-shadow:0 4px 18px #0f172a22; }
        .app-header-inner,.app-main,.app-footer-inner { width:min(1180px,100%); margin:auto; padding-left:24px; padding-right:24px; }
        .app-header-inner { min-height:76px; display:flex; align-items:center; justify-content:space-between; gap:18px; }
        .app-brand { flex-shrink:0; color:#fff; font-size:1.25rem; font-weight:800; letter-spacing:-.035em; }
        .app-brand:hover { color:#c7d2fe; }
        .app-menu-toggle { display:none; min-height:44px; padding:8px 12px; align-items:center; gap:8px; border:1px solid #ffffff40; border-radius:9px; color:#fff; background:#ffffff12; font-weight:600; }
        .app-nav { display:flex; align-items:center; justify-content:flex-end; gap:6px; }
        .app-nav a,.app-nav button { min-height:40px; display:inline-flex; align-items:center; justify-content:center; padding:7px 10px; border:1px solid #ffffff35; border-radius:9px; color:#fff; background:#ffffff0d; font-size:.825rem; font-weight:600; }
        .app-nav a:hover,.app-nav button:hover { color:#fff; background:#ffffff24; }
        .app-nav a[aria-current="page"] { border-color:#a5b4fc; background:#4f46e566; }
        .app-nav form { margin:0; }
        .app-nav .app-user { padding:0 4px; border:0; background:transparent; }
        .app-header button:focus-visible,.app-header a:focus-visible { outline:3px solid #a5b4fc; outline-offset:3px; }
        .app-main { flex:1; padding-top:34px; padding-bottom:56px; }
        .page-heading { margin:0 0 20px; font-size:clamp(1.7rem,4vw,2.2rem); line-height:1.2; letter-spacing:-.04em; }
        .page-subheading { margin:-10px 0 22px; color:var(--muted); }
        .page-title-row { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:20px; }
        .page-title-row .page-heading { margin:0 0 6px; }
        .page-title-row .page-subheading { margin:0; }
        .page-card { margin:0 0 18px; padding:24px; border:1px solid var(--border); border-radius:var(--radius); background:var(--surface); box-shadow:0 5px 16px #0f172a08; }
        .page-card h2,.page-card h3 { margin:0 0 12px; line-height:1.3; }
        .page-card article,.record-card { min-width:0; }
        .record-list { display:grid; gap:14px; }
        .record-card { padding:18px; border:1px solid var(--border); border-radius:12px; background:#fff; overflow-wrap:anywhere; }
        .record-card h2 { margin:0 0 8px; font-size:1.1rem; }
        .record-card p { margin:6px 0; color:#334155; }
        .record-card > form { margin-top:12px; }
        .user-summary { display:flex; align-items:center; gap:14px; margin-bottom:22px; padding-bottom:18px; border-bottom:1px solid var(--border); }
        .user-avatar { width:48px; height:48px; display:grid; flex:0 0 auto; place-items:center; border-radius:50%; color:#fff; background:linear-gradient(135deg,#4f46e5,#7c3aed); font-size:1.15rem; font-weight:800; }
        .user-summary-name { display:block; font-size:1rem; font-weight:700; }
        .user-summary-email { color:var(--muted); font-size:.875rem; overflow-wrap:anywhere; }
        .user-edit-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
        .field-group { min-width:0; }
        .permission-list { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
        .permission-option { display:flex; min-height:48px; align-items:center; gap:10px; margin:0; padding:11px 13px; border:1px solid var(--border); border-radius:10px; background:#f8fafc; }
        .permission-option:hover { border-color:#c7d2fe; background:#eef2ff; }
        .permission-option input[type=checkbox] { flex:0 0 auto; margin:0; }
        form.form-card,form.page-card,.page-card form { display:grid; gap:14px; }
        label { display:block; margin-bottom:5px; color:#334155; font-size:.9rem; font-weight:600; }
        input:not([type=checkbox]):not([type=radio]),textarea,select { width:100%; min-height:44px; padding:10px 12px; border:1px solid #cbd5e1; border-radius:9px; color:var(--ink); background:#fff; }
        textarea { min-height:130px; resize:vertical; }
        input:focus,textarea:focus,select:focus { border-color:var(--primary); outline:3px solid #4f46e522; }
        input[type=checkbox],input[type=radio] { width:18px; height:18px; vertical-align:middle; accent-color:var(--primary); }
        .page-card form label:has(input[type=checkbox]) { display:flex; align-items:center; gap:9px; }
        .btn,.page-card button[type=submit],.record-card button[type=submit],.page-card a.action-link { height:44px; min-width:120px; display:inline-flex; align-items:center; justify-content:center; width:fit-content; padding:0 15px; border:0; border-radius:9px; color:white; background:var(--primary); font-size:.9rem; font-weight:700; line-height:1; }
        .btn:hover,.page-card button[type=submit]:hover,.record-card button[type=submit]:hover,.page-card a.action-link:hover { color:#fff; background:var(--primary-hover); }
        .btn-secondary { border:1px solid var(--border)!important; color:var(--ink)!important; background:#fff!important; }
        .btn-danger,.page-card button.danger,.record-card button.btn-danger { color:#fff; background:var(--danger); }
        .btn-danger:hover,.page-card button.danger:hover,.record-card button.btn-danger:hover { color:#fff; background:#b91c1c; }
        .action-row { display:flex; flex-wrap:wrap; align-items:center; gap:12px; margin-top:14px; }
        .action-row form { display:inline-flex!important; width:auto; margin:0; }
        .user-actions { display:flex; align-items:center; gap:12px; margin-top:14px; }
        .record-actions { display:flex; align-items:center; gap:12px; margin-top:14px; }
        .record-actions > .btn,.record-actions > form { flex:0 0 120px; }
        .record-actions > form { margin:0; }
        .record-actions > form .btn { width:100%; }
        .user-action-item { flex:0 0 120px; }
        .user-action-item .btn { width:100%; }
        .user-action-item form { display:block; width:100%; margin:0; }
        .form-error { margin:4px 0 0; color:#b91c1c; font-size:.875rem; }
        .flash-message { position:relative; margin:0 0 18px; padding:13px 44px 13px 16px; border:1px solid #a7f3d0; border-radius:11px; color:#065f46; background:#ecfdf5; transition:opacity .35s ease,transform .35s ease; }
        .flash-message.is-leaving { opacity:0; transform:translateY(-6px); }
        .flash-close { position:absolute; top:5px; right:8px; width:34px; height:34px; border:0; border-radius:8px; color:inherit; background:transparent; font-size:1.25rem; }
        .confirm-modal { position:fixed; z-index:1000; width:min(320px,calc(100vw - 32px)); padding:0; }
        .confirm-modal[hidden] { display:none; }
        .confirm-dialog { padding:16px; border:1px solid var(--border); border-radius:12px; background:#fff; box-shadow:0 12px 32px #0f172a33; animation:confirm-in .14s ease-out; }
        .confirm-dialog h2 { margin:0 0 5px; font-size:1rem; }
        .confirm-dialog p { margin:0; color:var(--muted); font-size:.9rem; }
        .confirm-actions { display:flex; justify-content:flex-start; gap:8px; margin-top:14px; }
        .confirm-actions .btn { height:38px; min-width:92px; }
        @keyframes confirm-in { from { opacity:0; transform:translateY(5px); } to { opacity:1; transform:translateY(0); } }
        .empty-state { padding:20px; border:1px dashed #cbd5e1; border-radius:12px; color:var(--muted); text-align:center; }
        .app-footer { margin-top:5rem; border-top:1px solid var(--border); color:#94a3b8; background:#fff; font-size:.875rem; text-align:center; }
        .app-footer-inner { padding-top:2.25rem; padding-bottom:2.25rem; }
        nav[role=navigation] { margin-top:20px; }
        nav[role=navigation] a,nav[role=navigation] span { display:inline-flex; min-width:38px; min-height:38px; align-items:center; justify-content:center; margin:2px; padding:6px 10px; border:1px solid var(--border); border-radius:8px; background:#fff; }
        @media(max-width:900px) {
            .app-header-inner { min-height:68px; flex-wrap:wrap; padding-top:10px; padding-bottom:10px; }
            .app-menu-toggle { display:inline-flex; margin-left:auto; }
            .app-nav { display:none; width:100%; align-items:stretch; flex-direction:column; gap:6px; padding:4px 0 8px; }
            .app-nav.is-open { display:flex; }
            .app-nav a,.app-nav button { width:100%; min-height:46px; justify-content:flex-start; }
            .app-nav form { width:100%; }
            .app-nav .app-user { display:none; }
        }
        @media(max-width:520px) {
            .app-header-inner,.app-main,.app-footer-inner { padding-left:16px; padding-right:16px; }
            .app-main { padding-top:24px; }
            .page-card { padding:17px; }
            .record-card { padding:15px; }
            .page-title-row { align-items:flex-start; flex-direction:column; }
            .user-edit-grid { grid-template-columns:1fr; gap:12px; }
            .permission-list { grid-template-columns:1fr; }
            .user-actions { gap:10px; }
        }
    </style>
</head>
<body>
    <header class="app-header">
        <div class="app-header-inner">
            <a class="app-brand" href="{{ route('home') }}">{{ $siteName ?? 'My Blog' }}</a>
            <button class="app-menu-toggle" type="button" aria-expanded="false" aria-controls="app-navigation" aria-label="Open navigation menu">
                <span aria-hidden="true">☰</span><span>Menu</span>
            </button>
            <nav class="app-nav" id="app-navigation" aria-label="Main navigation">
                @can('viewAny', \App\Models\Project::class)<a href="{{ route('projects.index') }}" @if(request()->routeIs('projects.*')) aria-current="page" @endif>Projects</a>@endcan
                @can('viewAny', \App\Models\User::class)<a href="{{ route('users.index') }}" @if(request()->routeIs('users.*')) aria-current="page" @endif>Users</a>@endcan
                @can('roles.manage')<a href="{{ route('roles.index') }}" @if(request()->routeIs('roles.*')) aria-current="page" @endif>Roles</a>@endcan
                @can('permissions.manage')<a href="{{ route('permissions.index') }}" @if(request()->routeIs('permissions.*')) aria-current="page" @endif>Permissions</a>@endcan
                @can('viewAny', \App\Models\Post::class)<a href="{{ route('posts.index') }}" @if(request()->routeIs('posts.*')) aria-current="page" @endif>Posts</a>@endcan
                @can('reports.view')<a href="{{ route('reports.index') }}" @if(request()->routeIs('reports.*')) aria-current="page" @endif>Reports</a>@endcan
                @can('settings.manage')<a href="{{ route('settings.index') }}" @if(request()->routeIs('settings.*')) aria-current="page" @endif>Settings</a>@endcan
                @auth
                    <span class="app-user">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit">Log out</button></form>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                @endauth
            </nav>
        </div>
    </header>
    <main class="app-main">
        @if (session('status'))
            <div class="flash-message" role="status" aria-live="polite" data-auto-dismiss>
                {{ session('status') }}
                <button type="button" class="flash-close" aria-label="Dismiss notification">&times;</button>
            </div>
        @endif
        @if ($errors->any())
            <div class="flash-message" role="alert" style="border-color:#fecaca;color:#991b1b;background:#fef2f2">
                <strong>Please correct the highlighted fields.</strong>
            </div>
        @endif
        @yield('content')
    </main>
    <footer class="app-footer"><div class="app-footer-inner">&copy; {{ date('Y') }} {{ $siteName ?? 'My Blog' }}. All rights reserved.</div></footer>
    <div class="confirm-modal" id="confirm-modal" hidden>
        <section class="confirm-dialog" role="dialog" aria-modal="false" aria-labelledby="confirm-title" aria-describedby="confirm-message">
            <h2 id="confirm-title">Please confirm</h2>
            <p id="confirm-message">Are you sure you want to continue?</p>
            <div class="confirm-actions">
                <button type="button" class="btn btn-secondary" data-confirm-cancel>Cancel</button>
                <button type="button" class="btn btn-danger" data-confirm-accept>Confirm</button>
            </div>
        </section>
    </div>
    <script>
        const appMenuToggle = document.querySelector('.app-menu-toggle');
        const appNavigation = document.querySelector('#app-navigation');
        appMenuToggle?.addEventListener('click', () => {
            const open = appMenuToggle.getAttribute('aria-expanded') === 'true';
            appMenuToggle.setAttribute('aria-expanded', String(!open));
            appMenuToggle.setAttribute('aria-label', open ? 'Open navigation menu' : 'Close navigation menu');
            appNavigation?.classList.toggle('is-open', !open);
        });
        appNavigation?.addEventListener('click', event => {
            if (event.target.closest('a')) {
                appMenuToggle?.setAttribute('aria-expanded', 'false');
                appMenuToggle?.setAttribute('aria-label', 'Open navigation menu');
                appNavigation.classList.remove('is-open');
            }
        });
        document.querySelectorAll('[data-auto-dismiss]').forEach(message => {
            const dismiss = () => {
                message.classList.add('is-leaving');
                window.setTimeout(() => message.remove(), 400);
            };
            window.setTimeout(dismiss, 5000);
            message.querySelector('.flash-close')?.addEventListener('click', dismiss);
        });

        const confirmationModal = document.querySelector('#confirm-modal');
        const confirmationMessage = document.querySelector('#confirm-message');
        const confirmCancel = confirmationModal?.querySelector('[data-confirm-cancel]');
        const confirmAccept = confirmationModal?.querySelector('[data-confirm-accept]');
        let pendingConfirmation = null;
        let confirmationTrigger = null;

        const showConfirmation = (trigger, message, action) => {
            confirmationTrigger = trigger;
            pendingConfirmation = action;
            confirmationMessage.textContent = message;
            confirmationModal.hidden = false;
            const triggerRect = trigger.getBoundingClientRect();
            const popupWidth = confirmationModal.getBoundingClientRect().width;
            const left = Math.max(16, Math.min(triggerRect.left, window.innerWidth - popupWidth - 16));
            confirmationModal.style.left = `${left}px`;
            confirmationModal.style.top = '0px';
            const popupHeight = confirmationModal.getBoundingClientRect().height;
            const top = triggerRect.top >= popupHeight + 12
                ? triggerRect.top - popupHeight - 10
                : triggerRect.bottom + 10;
            confirmationModal.style.top = `${Math.max(8, Math.min(top, window.innerHeight - popupHeight - 8))}px`;
            confirmCancel.focus();
        };

        const closeConfirmation = () => {
            confirmationModal.hidden = true;
            confirmationModal.style.left = '';
            confirmationModal.style.top = '';
            pendingConfirmation = null;
            confirmationTrigger?.focus();
        };

        document.addEventListener('click', event => {
            const link = event.target.closest('a[data-confirm]');
            if (!link) return;
            event.preventDefault();
            showConfirmation(link, link.dataset.confirm, () => window.location.assign(link.href));
        });

        document.addEventListener('submit', event => {
            const form = event.target.closest('form[data-confirm]');
            if (!form) return;
            event.preventDefault();
            const submitter = event.submitter || form.querySelector('button[type="submit"]');
            showConfirmation(submitter || form, form.dataset.confirm, () => {
                form.removeAttribute('data-confirm');
                if (submitter?.name) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = submitter.name;
                    hidden.value = submitter.value;
                    form.append(hidden);
                }
                form.submit();
            });
        });

        confirmCancel?.addEventListener('click', closeConfirmation);
        confirmAccept?.addEventListener('click', () => {
            const action = pendingConfirmation;
            closeConfirmation();
            action?.();
        });
        confirmationModal?.addEventListener('click', event => {
            if (event.target === confirmationModal) closeConfirmation();
        });
        document.addEventListener('click', event => {
            if (confirmationModal && !confirmationModal.hidden && !confirmationModal.contains(event.target) && event.target !== confirmationTrigger) {
                closeConfirmation();
            }
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && confirmationModal && !confirmationModal.hidden) {
                closeConfirmation();
            }
        });
    </script>
</body>
</html>
