<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mark Foundation') — Transforming Lives</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #1e7c3f;
            --green-dk: #155a2c;
            --green-lt: #eaf5ee;
            --green-xlt: #f3faf5;
            --yellow: #f5c518;
            --yellow-dk: #d4aa0f;
            --yellow-lt: #fffbe6;
            --black: #0d1109;
            --ink: #1a2016;
            --ink-2: #3b4835;
            --ink-3: #6a7a62;
            --cream: #f5f6f2;
            --white: #ffffff;
            --border: #dce8d5;
            --border-dk: #bfd3b5;
            --radius: 7px;
            --radius-lg: 14px;
            --radius-xl: 20px;
            --shadow-sm: 0 1px 4px rgba(0, 0, 0, .06);
            --shadow: 0 3px 12px rgba(30, 124, 63, .09), 0 1px 4px rgba(0, 0, 0, .05);
            --shadow-lg: 0 12px 48px rgba(30, 124, 63, .15), 0 4px 16px rgba(0, 0, 0, .06);
            --font-head: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'Plus Jakarta Sans', -apple-system, sans-serif;
            --max-w: 1160px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            font-size: 15.5px;
            color: var(--ink);
            background: var(--cream);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-head);
            line-height: 1.18;
            letter-spacing: -.01em;
        }

        a {
            transition: color .2s;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .wrap {
            max-width: var(--max-w);
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--black);
            padding: .5rem 0;
            font-size: .775rem;
            color: rgba(255, 255, 255, .45);
        }

        .topbar__inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .topbar a {
            color: var(--yellow);
            text-decoration: none;
        }

        .topbar a:hover {
            text-decoration: underline;
        }

        /* ── NAV ── */
        .nav {
            background: var(--white);
            border-bottom: 2.5px solid var(--green);
            position: sticky;
            top: 0;
            z-index: 400;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .07);
        }

        .nav__inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
            gap: 1rem;
        }

        .nav__logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nav__logo-mark {
            width: 42px;
            height: 42px;
            background: var(--green);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(30, 124, 63, .3);
        }

        .nav__logo-text strong {
            display: block;
            font-family: var(--font-head);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--green-dk);
            line-height: 1.1;
        }

        .nav__logo-text span {
            font-size: .68rem;
            color: var(--ink-3);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .nav__links {
            display: flex;
            align-items: center;
            gap: .15rem;
        }

        .nav__links a {
            font-size: .84rem;
            font-weight: 500;
            color: var(--ink-2);
            text-decoration: none;
            padding: .42rem .82rem;
            border-radius: var(--radius);
            white-space: nowrap;
        }

        .nav__links a:hover {
            background: var(--green-xlt);
            color: var(--green-dk);
        }

        .nav__links a.active {
            color: var(--green);
            font-weight: 600;
        }

        .nav__donate {
            background: var(--yellow) !important;
            color: var(--black) !important;
            font-weight: 700 !important;
            border-radius: var(--radius) !important;
            padding: .42rem 1rem !important;
        }

        .nav__donate:hover {
            background: var(--yellow-dk) !important;
        }

        .nav__toggle {
            display: none;
            background: none;
            border: 1.5px solid var(--border-dk);
            border-radius: var(--radius);
            padding: .4rem .55rem;
            cursor: pointer;
            color: var(--ink-2);
        }

        @media(max-width:820px) {
            .nav__toggle {
                display: flex;
                align-items: center;
            }

            .nav__links {
                display: none;
                position: absolute;
                top: 72px;
                left: 0;
                right: 0;
                background: var(--white);
                border-bottom: 2px solid var(--border);
                flex-direction: column;
                align-items: stretch;
                padding: .75rem 1.5rem 1.25rem;
                gap: .2rem;
                box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
            }

            .nav__links.open {
                display: flex;
            }

            .nav__links a {
                padding: .7rem 1rem;
            }
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .7rem 1.5rem;
            font-family: var(--font-body);
            font-size: .88rem;
            font-weight: 600;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            line-height: 1;
            white-space: nowrap;
        }

        .btn-green {
            background: var(--green);
            color: #fff;
        }

        .btn-green:hover {
            background: var(--green-dk);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(30, 124, 63, .3);
        }

        .btn-yellow {
            background: var(--yellow);
            color: var(--black);
        }

        .btn-yellow:hover {
            background: var(--yellow-dk);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--green);
            color: var(--green);
        }

        .btn-outline:hover {
            background: var(--green);
            color: #fff;
        }

        .btn-ghost {
            background: rgba(255, 255, 255, .14);
            color: #fff;
            border: 1.5px solid rgba(255, 255, 255, .35);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, .24);
        }

        .btn-sm {
            padding: .45rem .95rem;
            font-size: .8rem;
        }

        /* ── ALERTS ── */
        .alert {
            padding: .9rem 1.2rem;
            border-radius: var(--radius);
            font-size: .88rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: .6rem;
        }

        .alert-success {
            background: var(--green-lt);
            color: var(--green-dk);
            border: 1px solid #a8d5b5;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* ── EYEBROW ── */
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .11em;
            text-transform: uppercase;
            color: var(--green);
            margin-bottom: .625rem;
        }

        .eyebrow::before,
        .eyebrow::after {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--yellow);
            flex-shrink: 0;
        }

        /* ── PILL ── */
        .pill {
            display: inline-flex;
            align-items: center;
            font-size: .77rem;
            font-weight: 600;
            padding: .22rem .7rem;
            border-radius: 99px;
            background: var(--green-lt);
            border: 1px solid var(--border-dk);
            color: var(--green-dk);
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--black);
            color: rgba(255, 255, 255, .6);
            padding: 4rem 0 1.75rem;
            margin-top: 6rem;
        }

        .footer__grid {
            display: grid;
            grid-template-columns: 2.2fr 1fr 1fr 1.2fr;
            gap: 2.5rem;
            margin-bottom: 3rem;
        }

        @media(max-width:900px) {
            .footer__grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:540px) {
            .footer__grid {
                grid-template-columns: 1fr;
            }
        }

        .footer h4 {
            font-family: var(--font-head);
            font-size: 1.05rem;
            color: var(--yellow);
            margin-bottom: 1rem;
        }

        .footer p {
            font-size: .85rem;
            line-height: 1.85;
        }

        .footer a {
            color: rgba(255, 255, 255, .5);
            text-decoration: none;
            font-size: .85rem;
            display: block;
            margin-bottom: .45rem;
            transition: color .2s;
        }

        .footer a:hover {
            color: var(--yellow);
        }

        .footer__social {
            display: flex;
            gap: .5rem;
            margin-top: 1.1rem;
            flex-wrap: wrap;
        }

        .footer__social a {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .35rem .75rem;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, .07);
            font-size: .78rem;
            margin: 0;
            transition: background .2s;
        }

        .footer__social a:hover {
            background: var(--green);
        }

        .footer__bottom {
            border-top: 1px solid rgba(255, 255, 255, .08);
            padding-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
            font-size: .78rem;
            color: rgba(255, 255, 255, .25);
        }

        .footer__logo {
            font-family: var(--font-head);
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .footer__logo em {
            font-style: normal;
            color: var(--yellow);
        }

        /* ── NEWSLETTER FORM ── */
        .nl-form {
            display: flex;
            flex-direction: column;
            gap: .5rem;
            margin-top: .75rem;
        }

        .nl-form input {
            padding: .6rem .875rem;
            border-radius: var(--radius);
            border: 1px solid rgba(255, 255, 255, .14);
            background: rgba(255, 255, 255, .07);
            color: #fff;
            font-family: var(--font-body);
            font-size: .84rem;
            outline: none;
        }

        .nl-form input::placeholder {
            color: rgba(255, 255, 255, .3);
        }

        .nl-form input:focus {
            border-color: var(--green);
        }

        .nl-form button {
            padding: .6rem;
            background: var(--green);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-family: var(--font-body);
            font-size: .84rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .nl-form button:hover {
            background: var(--green-dk);
        }

        main {
            min-height: 60vh;
        }

        .sec {
            padding: 5rem 0;
        }

        .sec-alt {
            background: var(--white);
        }

        .sec-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .sec-title h2 {
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            margin-bottom: .5rem;
        }

        .sec-title p {
            color: var(--ink-3);
            max-width: 580px;
            margin: 0 auto;
        }

        .sec-hd {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .sec-hd h2 {
            font-size: clamp(1.5rem, 3vw, 2.1rem);
        }

        .sec-hd p {
            color: var(--ink-3);
            font-size: .875rem;
            margin-top: .2rem;
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="topbar">
        <div class="wrap topbar__inner">
            <span>📍 Katesh, Hanang' District, Manyara, Tanzania</span>
            <span>
                📞 <a href="tel:+255787242434">+255 787 242 434</a>
                &nbsp;·&nbsp;
                ✉ <a href="mailto:markfoundation87@gmail.com">markfoundation87@gmail.com</a>
            </span>
        </div>
    </div>

    <header class="nav">
        <div class="wrap nav__inner">
            <a href="{{ route('home') }}" class="nav__logo">

                <img src="{{ asset('images/logo.png') }}" alt="Mark Foundation Logo" class="nav__logo-img"
                    style="width:150px;height:150px;object-fit:contain;">

            </a>
            <button class="nav__toggle" id="navToggle" aria-label="Toggle menu">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M3 12h18M3 6h18M3 18h18" />
                </svg>
            </button>
            <nav class="nav__links" id="navLinks">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('home') }}#about">About</a>
                <a href="{{ route('home') }}#programs">Programs</a>
                <a href="{{ route('events.index') }}"
                    class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a>
                <a href="{{ route('gallery.index') }}"
                    class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">Gallery</a>
                <a href="{{ route('jobs.index') }}"
                    class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">Careers</a>
                <a href="{{ route('home') }}#contact">Contact</a>
                <a href="{{ route('home') }}#get-involved" class="nav__donate">Donate</a>
            </nav>
        </div>
    </header>

    <main>
        @if (session('success'))
            <div class="wrap" style="padding-top:1.25rem;">
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="wrap" style="padding-top:1.25rem;">
                <div class="alert alert-error">⚠ {{ session('error') }}</div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="footer" id="contact">
        <div class="wrap">
            <div class="footer__grid">
                <div>
                    <div class="footer__logo"></div>
                    <p>Empowering vulnerable families, supporting education, and advancing healthcare across Tanzania.
                    </p>
                    <p style="margin-top:.75rem;font-size:.78rem;color:rgba(255,255,255,.22);">NGO Registration No:
                        [Insert Number]</p>
                    <div class="footer__social">
                        <a href="#" target="_blank">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>

                        <a href="#" target="_blank">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>

                        <a href="#" target="_blank">
                            <i class="fab fa-youtube"></i> YouTube
                        </a>

                        <a href="#" target="_blank">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>
                    </div>
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <a href="{{ route('home') }}#about">About Us</a>
                    <a href="{{ route('home') }}#programs">What We Do</a>
                    <a href="{{ route('events.index') }}">Events</a>
                    <a href="{{ route('gallery.index') }}">Gallery</a>
                    <a href="{{ route('jobs.index') }}">Careers</a>
                    <a href="{{ route('home') }}#get-involved">Get Involved</a>
                </div>
                <div>
                    <h4>Contact Us</h4>
                    <p style="margin-bottom:.625rem;">Mark Foundation Headquarters<br>Katesh, Hanang'
                        District<br>Manyara, Tanzania</p>
                    <a href="tel:+255787242434">📞 +255 787 242 434</a>
                    <a href="mailto:markfoundation87@gmail.com">✉ markfoundation87@gmail.com</a>
                </div>
                <div>
                    <h4>Newsletter</h4>
                    <p style="font-size:.83rem;margin-bottom:.875rem;">Get quarterly updates, impact stories, and
                        opportunities to engage.</p>
                    <form class="nl-form" onsubmit="return false;">
                        <input type="email" placeholder="Your email address">
                        <button type="submit">Subscribe →</button>
                    </form>
                </div>
            </div>
            <div class="footer__bottom">
                <span>© {{ date('Y') }} Mark Foundation. All Rights Reserved.</span>
                <span>Designed with purpose for community impact.</span>
                <a href="{{ route('admin.login') }}" style="color:rgba(255,255,255,.12);">Admin</a>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('open');
        });
    </script>
</body>

</html>
