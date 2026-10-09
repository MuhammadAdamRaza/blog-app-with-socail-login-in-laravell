<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName ?? 'My Blog' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --dark: #0f172a;
            --dark-surface: #1e293b;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --border: #e2e8f0;
            --border-hover: #cbd5e1;
            --text: #0f172a;
            --text-muted: #64748b;
            --text-subtle: #94a3b8;
            --success: #059669;
            --success-bg: #ecfdf5;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.03);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            background: none;
            transition: var(--transition);
        }

        /* --- Header --- */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 1rem 0;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.3);
        }

        .container {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.035em;
            color: #ffffff;
            display: inline-block;
        }

        .logo:hover {
            color: #c7d2fe;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }

        .nav-links .btn {
            min-width: 0;
            height: 40px;
            padding: 0 0.8rem;
            font-size: 0.82rem;
        }

        .nav-links a.is-active {
            border-color: rgba(165, 180, 252, 0.75);
            color: #fff;
            background: rgba(99, 102, 241, 0.42);
        }

        .menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            min-height: 44px;
            padding: 0.55rem 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.24);
            border-radius: var(--radius-sm);
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .menu-toggle:hover,
        .menu-toggle:focus-visible {
            background: rgba(255, 255, 255, 0.16);
        }

        .menu-toggle:focus-visible,
        .nav-links a:focus-visible,
        .nav-links button:focus-visible {
            outline: 3px solid #a5b4fc;
            outline-offset: 3px;
        }

        .menu-toggle-icon {
            width: 1.15rem;
            height: 1.15rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            height: 44px;
            padding: 0 15px;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 2px 10px rgba(79, 70, 229, 0.4);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.5);
        }

        .btn-outline {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.16);
            border-color: rgba(255, 255, 255, 0.4);
            color: #ffffff;
        }

        .btn-danger {
            background-color: var(--danger);
            color: #ffffff;
            border: 1px solid var(--danger);
        }

        .btn-danger:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
            color: white;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.25rem 0.35rem 0.25rem 0.6rem;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.07);
        }

        .user-menu form .btn { min-width:0; height:40px; padding:0 .8rem; }

        .user-greeting {
            font-size: 0.875rem;
            color: #cbd5e1;
            font-weight: 600;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            border: 2px solid rgba(255, 255, 255, 0.15);
        }

        /* --- Notifications / Toasts --- */
        .toast-container {
            position: fixed;
            top: 4.5rem;
            right: 1.5rem;
            z-index: 200;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 380px;
        }

        .toast {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.9rem 1.15rem;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xl);
            font-size: 0.875rem;
            line-height: 1.5;
            background: var(--surface);
            border: 1px solid var(--border);
            animation: toastIn 0.35s ease forwards;
            transition: opacity 0.35s ease, transform 0.35s ease;
        }

        .toast.is-leaving {
            opacity: 0;
            transform: translateY(-8px);
            pointer-events: none;
        }

        .toast-dismiss {
            flex: 0 0 auto;
            margin-left: auto;
            padding: 0 0.2rem;
            color: inherit;
            font-size: 1.2rem;
            line-height: 1;
        }

        @keyframes toastIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .toast.success {
            border-left: 4px solid var(--success);
            background: #ffffff;
            color: var(--text);
        }

        .toast.error {
            border-left: 4px solid var(--danger);
            background: #ffffff;
            color: var(--danger);
        }

        /* --- Main Content Layout --- */
        main {
            flex: 1;
            padding: 3.5rem 0 5rem;
        }

        /* --- Guest Hero Section --- */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);
            border-radius: var(--radius-xl);
            padding: 5rem 2.5rem;
            color: white;
            text-align: center;
            margin-top: 1rem;
            margin-bottom: 3.5rem;
            box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.25);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -150px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -150px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(129, 140, 248, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-block;
            padding: 0.35rem 0.9rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #c7d2fe;
            margin-bottom: 1.25rem;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: clamp(2rem, 4.5vw, 3.25rem);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.035em;
            max-width: 720px;
            margin: 0 auto 1.25rem;
            position: relative;
            z-index: 1;
        }

        .hero p {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: #cbd5e1;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* --- Feature Highlights (Guest) --- */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 5rem;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem 1.75rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .feature-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .feature-num {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .feature-card h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.55;
        }

        /* --- Logged-In Layout --- */
        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2rem;
            align-items: start;
        }

        /* --- Latest Post Section --- */
        .spotlight-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            position: relative;
        }

        .spotlight-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), #818cf8);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .spotlight-tag {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .spotlight-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .spotlight-body {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .spotlight-meta {
            font-size: 0.8rem;
            color: var(--text-subtle);
            margin-top: 0.85rem;
        }

        /* --- Post Feed --- */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .section-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text);
        }

        .post-count-badge {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            background: var(--bg);
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            border: 1px solid var(--border);
        }

        .posts-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .post-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.6rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .post-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-md);
        }

        .post-top {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .author-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e0e7ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .author-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text);
        }

        .post-date {
            font-size: 0.8rem;
            color: var(--text-subtle);
        }

        .post-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.6rem;
            line-height: 1.35;
        }

        .post-body {
            font-size: 0.95rem;
            color: #334155;
            line-height: 1.65;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .post-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .edit-toggle summary {
            list-style: none;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            padding: 0.45rem 0.9rem;
            border-radius: var(--radius-sm);
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--primary);
            background: var(--primary-light);
            transition: var(--transition);
        }

        .edit-toggle summary::-webkit-details-marker {
            display: none;
        }

        .edit-toggle summary:hover {
            background: #e0e7ff;
        }

        .edit-form-box {
            margin-top: 1rem;
            padding: 1.25rem;
            background: var(--bg);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
        }

        /* --- Form Elements --- */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.4rem;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            color: var(--text);
            font-family: inherit;
            font-size: 0.9rem;
            transition: var(--transition);
            outline: none;
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .form-textarea {
            resize: vertical;
            min-height: 110px;
        }

        /* --- Logged-In Dashboard --- */
        .dashboard-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.25rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .dashboard-banner h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
        }

        .dashboard-banner p {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .dashboard-stats {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        /* --- Sidebar Form --- */
        .sidebar-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06);
            position: sticky;
            top: 6rem;
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 0.35rem;
            letter-spacing: -0.02em;
        }

        .sidebar-desc {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 1.35rem;
            line-height: 1.5;
        }

        /* --- Empty State --- */
        .empty-state {
            background: var(--surface);
            border: 1px dashed var(--border-hover);
            border-radius: var(--radius-lg);
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .empty-icon-box {
            width: 52px;
            height: 52px;
            margin: 0 auto 1.25rem;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .empty-icon-box i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .empty-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.4rem;
        }

        .empty-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            max-width: 360px;
            margin: 0 auto;
            line-height: 1.55;
        }

        /* --- Footer --- */
        footer {
            margin-top: 5rem;
            border-top: 1px solid var(--border);
            background: var(--surface);
            padding: 2.25rem 0;
            color: var(--text-subtle);
            font-size: 0.875rem;
            text-align: center;
        }

        /* --- Responsive Design --- */
        @media (max-width: 1024px) {
            .container {
                padding: 0 1.25rem;
            }

            .layout-grid {
                grid-template-columns: 1fr 310px;
                gap: 1.5rem;
            }
        }

        @media (max-width: 860px) {
            .header-content {
                flex-wrap: wrap;
                gap: 0.75rem;
            }

            .menu-toggle {
                display: inline-flex;
                margin-left: auto;
            }

            .nav-links {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 0.4rem;
                padding: 0.5rem 0 0.25rem;
            }

            .nav-links.is-open {
                display: flex;
            }

            .nav-links > a {
                width: 100%;
                min-height: 44px;
                justify-content: flex-start;
            }

            .user-menu {
                width: 100%;
                min-height: 48px;
                align-items: center;
                justify-content: flex-start;
                gap: 0.7rem;
                padding-top: 0.25rem;
            }

            .user-greeting {
                display: inline;
            }

            .user-menu form {
                margin-left: auto !important;
            }

            .user-menu form button {
                min-height: 44px;
            }

            .layout-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .sidebar-card {
                position: static;
                order: -1;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }

            .hero {
                padding: 3.5rem 2rem;
                margin-bottom: 2.5rem;
            }
        }

        @media (min-width: 861px) and (max-width: 1060px) {
            .header-content { flex-wrap: wrap; gap: 0.75rem; }
            .menu-toggle { display: inline-flex; margin-left: auto; }
            .nav-links { display: none; width: 100%; flex-direction: column; align-items: stretch; gap: 0.4rem; padding: 0.5rem 0 0.25rem; }
            .nav-links.is-open { display: flex; }
            .nav-links > a { width: 100%; min-height: 44px; justify-content: flex-start; }
            .user-menu { width: 100%; min-height: 48px; }
        }

        @media (max-width: 640px) {
            header {
                padding: 0.85rem 0;
            }

            .header-content {
                gap: 0.75rem;
            }

            .logo {
                font-size: 1.25rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.825rem;
            }

            main {
                padding: 2.25rem 0 3.5rem;
            }

            .hero {
                padding: 2.75rem 1.25rem;
                border-radius: var(--radius-lg);
                margin-top: 0.5rem;
                margin-bottom: 2rem;
            }

            .hero-badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.75rem;
            }

            .hero h1 {
                font-size: 1.85rem;
                margin-bottom: 1rem;
            }

            .hero p {
                font-size: 0.95rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .feature-card {
                padding: 1.5rem 1.25rem;
            }

            .spotlight-card {
                padding: 1.35rem 1.15rem;
                border-radius: var(--radius-md);
            }

            .spotlight-title {
                font-size: 1.15rem;
            }

            .post-card {
                padding: 1.35rem 1.15rem;
                border-radius: var(--radius-md);
            }

            .post-title {
                font-size: 1.1rem;
            }

            .post-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 0.6rem;
            }

            .post-actions form {
                width: 100%;
            }

            .post-actions form button {
                width: 100%;
            }

            .edit-toggle summary {
                width: 100%;
                justify-content: center;
            }

            .sidebar-card {
                padding: 1.35rem 1.15rem;
                border-radius: var(--radius-md);
            }

            .toast-container {
                top: 4.5rem;
                left: 1rem;
                right: 1rem;
                max-width: none;
            }

            .toast {
                width: 100%;
            }
        }

        @media (max-width: 420px) {
            .container {
                padding-right: 1rem;
                padding-left: 1rem;
            }

            .logo {
                max-width: calc(100% - 6.5rem);
                overflow-wrap: anywhere;
            }
        }

        /* Keep the dashboard header aligned with the management-page navbar. */
        header { padding: 0; }
        .header-content { min-height: 76px; gap: 18px; flex-wrap: nowrap; }
        .logo { flex-shrink: 0; font-size: 1.25rem; }
        .nav-links { justify-content: flex-end; gap: 6px; }
        .nav-links .btn,
        .user-menu form .btn {
            min-width: 0;
            min-height: 40px;
            height: 40px;
            padding: 7px 10px;
            border-radius: 9px;
            font-size: .825rem;
            font-weight: 600;
        }
        .user-menu { flex-shrink: 0; gap: 8px; padding: 4px; border-radius: 12px; }
        .user-menu form { margin: 0; }
        .nav-links form { margin: 0; }
        .nav-links form button { color: #fff; background: #ffffff0d; border: 1px solid #ffffff35; }
        .nav-links form button:hover { color: #fff; background: #ffffff24; }
        .app-user { padding: 0 4px; color: #fff; white-space: nowrap; }
        .menu-toggle { display: none; }
        @media (min-width: 901px) and (max-width: 1150px) {
            .container { padding-left: 16px; padding-right: 16px; }
            .header-content { gap: 10px; }
            .nav-links { gap: 4px; }
            .nav-links .btn, .user-menu form .btn { padding: 6px 7px; font-size: .75rem; }
            .user-greeting { display: none; }
            .app-user { display: none; }
        }
        @media (max-width: 900px) {
            header { padding: 0; }
            .header-content { min-height: 68px; flex-wrap: wrap; gap: 10px; padding-top: 10px; padding-bottom: 10px; }
            .menu-toggle { display: inline-flex; margin-left: auto; }
            .nav-links { display: none; width: 100%; align-items: stretch; flex-direction: column; gap: 6px; padding: 4px 0 8px; }
            .nav-links.is-open { display: flex; }
            .nav-links > a { width: 100%; min-height: 46px; justify-content: flex-start; }
            .user-menu { width: 100%; min-height: 48px; }
            .user-greeting { display: inline; }
            .user-menu form { margin-left: auto; }
            .user-menu form .btn { min-height: 44px; }
            .nav-links form { width: 100%; }
            .nav-links form button { width: 100%; min-height: 46px; justify-content: flex-start; }
        }
    </style>
</head>
<body>

    <header>
        <div class="container header-content">
            <a href="{{ route('home') }}" class="logo">My Blog</a>

            <button
                type="button"
                class="menu-toggle"
                aria-expanded="false"
                aria-controls="primary-navigation"
                aria-label="Open navigation menu"
            >
                <svg class="menu-toggle-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>Menu</span>
            </button>

            <nav class="nav-links" id="primary-navigation" aria-label="Main navigation">
                @auth
                    <a href="{{ route('products.manage') }}" class="btn btn-outline {{ request()->routeIs('products.manage') ? 'is-active' : '' }}">Products</a>
                    @can('viewAny', \App\Models\Project::class)
                        <a href="{{ route('projects.index') }}" class="btn btn-outline {{ request()->routeIs('projects.*') ? 'is-active' : '' }}">Projects</a>
                    @endcan

                    @can('viewAny', \App\Models\User::class)
                        <a href="{{ route('users.index') }}" class="btn btn-outline {{ request()->routeIs('users.*') ? 'is-active' : '' }}">Users</a>
                    @endcan

                    @can('roles.manage')
                        <a href="{{ route('roles.index') }}" class="btn btn-outline {{ request()->routeIs('roles.*') ? 'is-active' : '' }}">Roles</a>
                    @endcan

                    @can('permissions.manage')
                        <a href="{{ route('permissions.index') }}" class="btn btn-outline {{ request()->routeIs('permissions.*') ? 'is-active' : '' }}">Permissions</a>
                    @endcan

                    @can('viewAny', \App\Models\Post::class)
                        <a href="{{ route('posts.index') }}" class="btn btn-outline {{ request()->routeIs('posts.*') ? 'is-active' : '' }}">Posts</a>
                    @endcan

                    @can('reports.view')
                        <a href="{{ route('reports.index') }}" class="btn btn-outline {{ request()->routeIs('reports.*') ? 'is-active' : '' }}">Reports</a>
                    @endcan

                    @can('settings.manage')
                        <a href="{{ route('settings.index') }}" class="btn btn-outline {{ request()->routeIs('settings.*') ? 'is-active' : '' }}">Settings</a>
                    @endcan

                    <span class="app-user">{{ $currentUserName }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get started</a>
                @endauth
            </nav>
        </div>
    </header>

    <div class="toast-container">
        @if(session('status'))
            <div class="toast success" role="status" aria-live="polite" data-auto-dismiss>
                <div>{{ session('status') }}</div>
                <button type="button" class="toast-dismiss" aria-label="Dismiss notification">&times;</button>
            </div>
        @endif

        @if(session('success'))
            <div class="toast success">
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast error">
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="toast error">
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <main class="container">
        @auth
            <div class="dashboard-banner">
                <div>
                    <h1>Welcome back, {{ $currentUserName }}</h1>
                    <p>Manage your published stories and create new articles.</p>
                </div>
                <div class="dashboard-stats">
                    <span class="stat-pill">{{ $posts->count() }} {{ $posts->count() === 1 ? 'Article' : 'Articles' }}</span>
                </div>
            </div>

            @if(isset($latestPost) && $latestPost)
                <section class="spotlight-card">
                    <span class="spotlight-tag">Recent Post</span>
                    <h2 class="spotlight-title">{{ $latestPost->title }}</h2>
                    <p class="spotlight-body">{{ $latestPost->body }}</p>
                    <div class="spotlight-meta">
                        Published {{ $latestPost->created_at->diffForHumans() }}
                    </div>
                </section>
            @endif

            <div class="layout-grid">
                <section class="posts-section">
                    <div class="section-header">
                        <h2>Your Articles</h2>
                        <span class="post-count-badge">{{ $posts->count() }} {{ $posts->count() === 1 ? 'post' : 'posts' }}</span>
                    </div>

                    <div class="posts-list">
                        @forelse($posts as $post)
                            <article class="post-card">
                                <div class="post-top">
                                    <div class="author-avatar">{{ substr($post->user->name ?? 'A', 0, 1) }}</div>
                                    <div>
                                        <div class="author-name">{{ $post->user->name ?? 'Author' }}</div>
                                        <div class="post-date">{{ $post->created_at->format('M j, Y') }}</div>
                                    </div>
                                </div>

                                <h3 class="post-title">{{ $post->title }}</h3>
                                <div class="post-body">{{ $post->body }}</div>

                                @canany(['update', 'delete'], $post)
                                    <div class="post-actions">
                                        @can('update', $post)
                                        <details class="edit-toggle">
                                            <summary>Edit post</summary>
                                            <div class="edit-form-box">
                                                <form action="{{ route('posts.update', $post) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label class="form-label" for="edit-title-{{ $post->id }}">Title</label>
                                                        <input id="edit-title-{{ $post->id }}" type="text" name="title" class="form-input" value="{{ old('title', $post->title) }}" maxlength="255" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="edit-body-{{ $post->id }}">Content</label>
                                                        <textarea id="edit-body-{{ $post->id }}" name="body" class="form-textarea" required>{{ old('body', $post->body) }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </form>
                                            </div>
                                        </details>
                                        @endcan

                                        @can('delete', $post)
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="padding: 0.45rem 0.9rem; font-size: 0.825rem;">Delete</button>
                                        </form>
                                        @endcan
                                    </div>
                                @endcanany
                            </article>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon-box" aria-hidden="true">
                                    <i class="fa-regular fa-file-lines"></i>
                                </div>
                                <div class="empty-title">No posts published yet</div>
                                <p class="empty-desc">Create your first article using the form on the right to start your feed.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                @can('create', \App\Models\Post::class)
                <aside>
                    <div id="create-post" class="sidebar-card">
                        <h3 class="sidebar-title">Create an Article</h3>
                        <p class="sidebar-desc">Publish your thoughts directly to your blog.</p>

                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="new-post-title">Title</label>
                                <input id="new-post-title" type="text" name="title" class="form-input" placeholder="Article title" value="{{ old('title') }}" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="new-post-body">Content</label>
                                <textarea id="new-post-body" name="body" class="form-textarea" placeholder="Write your story..." required>{{ old('body') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Publish Article</button>
                        </form>
                    </div>
                </aside>
                @endcan
            </div>
        @else
            <section class="hero">
                <span class="hero-badge">Personal Publishing</span>
                <h1>Where great ideas find their voice.</h1>
                <p>A clean, focused space to write, publish, and share your thoughts with the world.</p>
            </section>

            <section class="features-grid">
                <article class="feature-card">
                    <span class="feature-num">01</span>
                    <h3>Write freely</h3>
                    <p>Express your ideas in a focused editor designed for simplicity and speed.</p>
                </article>

                <article class="feature-card">
                    <span class="feature-num">02</span>
                    <h3>Refine anytime</h3>
                    <p>Update, edit, or remove your published stories whenever inspiration strikes.</p>
                </article>

                <article class="feature-card">
                    <span class="feature-num">03</span>
                    <h3>Own your content</h3>
                    <p>Your articles are safely saved and tied exclusively to your account.</p>
                </article>
            </section>
        @endauth
    </main>

    <footer>
        <div class="container">
            &copy; {{ date('Y') }} {{ $siteName ?? 'My Blog' }}. All rights reserved.
        </div>
    </footer>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const primaryNavigation = document.querySelector('#primary-navigation');

        menuToggle?.addEventListener('click', () => {
            const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', String(!isOpen));
            menuToggle.setAttribute('aria-label', isOpen ? 'Open navigation menu' : 'Close navigation menu');
            primaryNavigation?.classList.toggle('is-open', !isOpen);
        });

        primaryNavigation?.addEventListener('click', (event) => {
            if (event.target.closest('a')) {
                menuToggle?.setAttribute('aria-expanded', 'false');
                menuToggle?.setAttribute('aria-label', 'Open navigation menu');
                primaryNavigation.classList.remove('is-open');
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && primaryNavigation?.classList.contains('is-open')) {
                menuToggle?.setAttribute('aria-expanded', 'false');
                menuToggle?.setAttribute('aria-label', 'Open navigation menu');
                primaryNavigation.classList.remove('is-open');
                menuToggle?.focus();
            }
        });

        document.querySelectorAll('[data-auto-dismiss]').forEach((toast) => {
            const dismiss = () => {
                toast.classList.add('is-leaving');
                window.setTimeout(() => toast.remove(), 400);
            };
            window.setTimeout(dismiss, 5000);
            toast.querySelector('.toast-dismiss')?.addEventListener('click', dismiss);
        });
    </script>
</body>
</html>
