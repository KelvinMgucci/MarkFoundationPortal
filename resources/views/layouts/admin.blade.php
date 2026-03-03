<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · Mark Foundation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --sidebar-w: 240px;
            --green:     #1a7a3c; --green-dk: #145e2e; --green-lt: #e8f5ed;
            --yellow:    #f0c030; --yellow-dk:#d4a820;
            --black:     #111810; --ink: #1c2419; --ink-2: #3d4a38; --ink-3: #6b7a63;
            --cream:     #f7f8f5; --white: #ffffff;
            --border:    #dde8d8; --border-dk: #c4d4bc;
            --sidebar-bg:#13200e; --sidebar-tx:#8faa85;
            --danger:#b91c1c; --danger-bg:#fef2f2; --danger-bd:#fecaca;
            --radius:6px;
            --font-head:'Playfair Display',Georgia,serif;
            --font-body:'DM Sans',-apple-system,sans-serif;
        }
        html,body { height:100%; }
        body { font-family:var(--font-body);font-size:15px;color:var(--ink);background:var(--cream);display:flex;-webkit-font-smoothing:antialiased; }
        h1,h2,h3 { font-family:var(--font-head);letter-spacing:-.02em; }

        /* Sidebar */
        .sidebar { width:var(--sidebar-w);min-height:100vh;background:var(--sidebar-bg);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0; }
        .sidebar__brand { padding:1.375rem;border-bottom:1px solid rgba(255,255,255,.06); }
        .sidebar__brand-name { font-family:var(--font-head);font-size:1rem;font-weight:800;color:var(--white);text-decoration:none;display:flex;align-items:center;gap:.4rem; }
        .sidebar__brand-name em { font-style:normal;width:8px;height:8px;background:var(--yellow);border-radius:50%;display:inline-block; }
        .sidebar__brand-sub { font-size:.68rem;color:var(--sidebar-tx);margin-top:.2rem;letter-spacing:.05em;text-transform:uppercase; }
        .sidebar__nav { padding:.5rem 0;flex:1; }
        .sidebar__section { padding:.75rem 1.375rem .2rem;font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.2); }
        .sidebar__link { display:flex;align-items:center;gap:.575rem;padding:.575rem 1.375rem;font-size:.84rem;font-weight:500;color:var(--sidebar-tx);text-decoration:none;border-left:2px solid transparent;transition:all .18s; }
        .sidebar__link:hover,.sidebar__link.active { color:var(--white);background:rgba(255,255,255,.05);border-left-color:var(--yellow); }
        .sidebar__link svg { opacity:.55;flex-shrink:0; }
        .sidebar__link:hover svg,.sidebar__link.active svg { opacity:1; }
        .sidebar__footer { padding:1rem 1.375rem;border-top:1px solid rgba(255,255,255,.06); }
        .sidebar__user { font-size:.78rem;color:var(--sidebar-tx);margin-bottom:.625rem; }
        .sidebar__user strong { display:block;color:var(--white);font-weight:500;font-size:.8rem; }
        .sidebar__logout { width:100%;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:var(--sidebar-tx);padding:.45rem;border-radius:var(--radius);font-family:var(--font-body);font-size:.78rem;font-weight:500;cursor:pointer;transition:all .2s; }
        .sidebar__logout:hover { background:rgba(255,255,255,.12);color:var(--white); }

        /* Main */
        .main { margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh; }
        .topbar { background:var(--white);border-bottom:1px solid var(--border);padding:0 2rem;height:54px;display:flex;align-items:center;justify-content:space-between; }
        .topbar__breadcrumb { font-size:.78rem;color:var(--ink-3);display:flex;align-items:center;gap:.45rem; }
        .topbar__breadcrumb a { color:var(--ink-3);text-decoration:none; }
        .topbar__breadcrumb a:hover { color:var(--green); }
        .topbar__breadcrumb .sep { color:var(--border-dk); }
        .content { padding:2rem;flex:1; }

        /* Page header */
        .page-hd { display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:2rem; }
        .page-hd h1 { font-size:1.55rem;color:var(--ink); }
        .page-hd p  { color:var(--ink-3);font-size:.875rem;margin-top:.2rem; }

        /* Card */
        .card { background:var(--white);border:1px solid var(--border);border-radius:var(--radius); }
        .card-body { padding:1.5rem; }

        /* Stats */
        .stats { display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2.5rem; }
        @media(max-width:900px){.stats{grid-template-columns:repeat(2,1fr);}}
        .stat-card { background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1.375rem; }
        .stat-card__label { font-size:.7rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-3);margin-bottom:.4rem; }
        .stat-card__value { font-family:var(--font-head);font-size:2.25rem;line-height:1;color:var(--ink); }
        .stat-card__sub { font-size:.75rem;color:var(--ink-3);margin-top:.3rem; }
        .stat-card--green .stat-card__value { color:var(--green); }
        .stat-card--yellow .stat-card__value { color:var(--yellow-dk); }

        /* Table */
        .table-wrap { overflow-x:auto; }
        table { width:100%;border-collapse:collapse;font-size:.875rem; }
        thead th { text-align:left;padding:.7rem 1.125rem;font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-3);background:var(--cream);border-bottom:1px solid var(--border);white-space:nowrap; }
        tbody td { padding:.875rem 1.125rem;border-bottom:1px solid var(--border);vertical-align:middle;color:var(--ink-2); }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover td { background:#f9faf7; }

        /* Badges */
        .badge { display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .65rem;border-radius:99px;font-size:.73rem;font-weight:600;white-space:nowrap; }
        .badge::before { content:'';width:5px;height:5px;border-radius:50%;background:currentColor;opacity:.6; }
        .badge-active     { background:#dcfce7;color:#15803d; }
        .badge-inactive   { background:var(--cream);color:var(--ink-3);border:1px solid var(--border-dk); }
        .badge-photo      { background:var(--green-lt);color:var(--green-dk); }
        .badge-video      { background:#eff6ff;color:#1e40af; }
        .badge-visible    { background:#dcfce7;color:#15803d; }
        .badge-hidden     { background:var(--cream);color:var(--ink-3);border:1px solid var(--border-dk); }
        .badge-published  { background:#dcfce7;color:#15803d; }
        .badge-draft      { background:#fef9c3;color:#854d0e; }
        .badge-upcoming   { background:#eff6ff;color:#1e40af; }
        .badge-past       { background:var(--cream);color:var(--ink-3); }
        .badge-new        { background:#dbeafe;color:#1e40af; }
        .badge-reviewed   { background:#fef9c3;color:#854d0e; }
        .badge-shortlisted{ background:#dcfce7;color:#15803d; }
        .badge-rejected   { background:var(--danger-bg);color:var(--danger); }

        /* Forms */
        .form-row { display:grid;grid-template-columns:1fr 1fr;gap:1.25rem; }
        @media(max-width:640px){.form-row{grid-template-columns:1fr;}}
        .form-group { margin-bottom:1.125rem; }
        .form-label { display:block;font-size:.82rem;font-weight:600;color:var(--ink-2);margin-bottom:.35rem; }
        .form-label .req { color:var(--green); }
        .form-control { width:100%;padding:.6rem .875rem;border:1.5px solid var(--border-dk);border-radius:var(--radius);font-family:var(--font-body);font-size:.9rem;color:var(--ink);background:var(--white);transition:border-color .2s,box-shadow .2s; }
        .form-control:focus { outline:none;border-color:var(--green);box-shadow:0 0 0 3px rgba(26,122,60,.12); }
        .form-control.is-invalid { border-color:var(--danger); }
        .form-error { font-size:.78rem;color:var(--danger);margin-top:.3rem; }
        .form-hint  { font-size:.75rem;color:var(--ink-3);margin-top:.3rem; }
        textarea.form-control { resize:vertical;line-height:1.6; }

        /* Alerts */
        .alert { padding:.875rem 1.125rem;border-radius:var(--radius);font-size:.875rem;font-weight:500;margin-bottom:1.5rem;display:flex;align-items:flex-start;gap:.6rem; }
        .alert-success { background:var(--green-lt);color:var(--green-dk);border:1px solid #a8d8b8; }
        .alert-error   { background:var(--danger-bg);color:var(--danger);border:1px solid var(--danger-bd); }

        /* Buttons */
        .btn { display:inline-flex;align-items:center;gap:.35rem;padding:.6rem 1.25rem;font-family:var(--font-body);font-size:.84rem;font-weight:600;border-radius:var(--radius);border:none;cursor:pointer;text-decoration:none;white-space:nowrap;transition:all .18s;line-height:1; }
        .btn-green  { background:var(--green);color:var(--white); }
        .btn-green:hover { background:var(--green-dk); }
        .btn-yellow { background:var(--yellow);color:var(--black); }
        .btn-yellow:hover { background:var(--yellow-dk); }
        .btn-ghost  { background:var(--cream);border:1px solid var(--border-dk);color:var(--ink-2); }
        .btn-ghost:hover { background:var(--border); }
        .btn-danger { background:var(--danger-bg);color:var(--danger);border:1px solid var(--danger-bd); }
        .btn-danger:hover { background:var(--danger-bd); }
        .btn-sm { padding:.375rem .875rem;font-size:.78rem; }
        .btn-xs { padding:.25rem .6rem;font-size:.73rem; }

        /* Actions */
        .actions { display:flex;gap:.375rem;align-items:center;flex-wrap:wrap; }

        /* Empty state */
        .empty { text-align:center;padding:4rem 2rem;color:var(--ink-3); }
        .empty__icon { font-size:2.5rem;margin-bottom:1rem; }
        .empty h3 { font-size:1rem;font-family:var(--font-head);color:var(--ink-2);margin-bottom:.35rem; }
        .empty p  { font-size:.875rem;margin-bottom:1.25rem; }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar__brand">
        <a href="{{ route('admin.dashboard') }}" class="sidebar__brand-name">
            🌿 Mark<em></em>Foundation
        </a>
        <p class="sidebar__brand-sub">Admin Panel</p>
    </div>
    <nav class="sidebar__nav">
        <p class="sidebar__section">Main</p>
        <a href="{{ route('admin.dashboard') }}" class="sidebar__link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <p class="sidebar__section">Content</p>
        <a href="{{ route('admin.events.index') }}" class="sidebar__link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Events
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="sidebar__link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
            Gallery
        </a>
        <a href="{{ route('admin.jobs.index') }}" class="sidebar__link {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            Job Postings
        </a>
    </nav>
    <div class="sidebar__footer">
        <div class="sidebar__user">
            Signed in as
            <strong>{{ auth('recruiter')->user()->name }}</strong>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar__logout">Sign out</button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar__breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
            @hasSection('breadcrumb')
                <span class="sep">/</span>@yield('breadcrumb')
            @endif
        </div>
        <a href="{{ route('home') }}" class="topbar__breadcrumb" target="_blank" style="font-weight:500;">
            View public site ↗
        </a>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">⚠ {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>
