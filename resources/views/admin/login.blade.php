<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In · Mark Foundation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        :root{
            --green:#1a7a3c;--green-dk:#145e2e;--yellow:#f0c030;--yellow-dk:#d4a820;
            --black:#111810;--border-dk:#c4d4bc;--radius:8px;
            --font-head:'Playfair Display',Georgia,serif;
            --font-body:'DM Sans',-apple-system,sans-serif;
        }
        body{font-family:var(--font-body);background:var(--black);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem;-webkit-font-smoothing:antialiased;position:relative;overflow:hidden;}
        body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 55% 80% at 10% 90%,rgba(26,122,60,.2) 0%,transparent 60%),radial-gradient(ellipse 60% 60% at 90% 10%,rgba(26,122,60,.1) 0%,transparent 55%);}
        .card{background:#fff;border-radius:16px;width:100%;max-width:420px;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.5);position:relative;z-index:1;}
        .card__top{background:var(--black);padding:2rem;text-align:center;border-bottom:1px solid rgba(255,255,255,.07);position:relative;}
        .card__top::after{content:'';position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:60px;height:3px;background:var(--yellow);border-radius:99px;}
        .brand{font-family:var(--font-head);font-size:1.5rem;font-weight:800;color:#fff;display:inline-flex;align-items:center;gap:.5rem;margin-bottom:.4rem;}
        .brand em{font-style:normal;width:9px;height:9px;background:var(--yellow);border-radius:50%;display:inline-block;}
        .card__top p{font-size:.75rem;color:rgba(255,255,255,.4);letter-spacing:.07em;text-transform:uppercase;}
        .card__body{padding:2rem;}
        .alert{padding:.75rem 1rem;border-radius:6px;font-size:.84rem;font-weight:500;margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;}
        .alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;}
        .alert-error{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;}
        .form-group{margin-bottom:1rem;}
        label{display:block;font-size:.82rem;font-weight:600;color:#3d4a38;margin-bottom:.35rem;}
        input[type=email],input[type=password]{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border-dk);border-radius:var(--radius);font-family:var(--font-body);font-size:.9rem;color:#1c2419;transition:border-color .2s,box-shadow .2s;}
        input:focus{outline:none;border-color:var(--green);box-shadow:0 0 0 3px rgba(26,122,60,.12);}
        input.is-invalid{border-color:#b91c1c;}
        .error-msg{font-size:.78rem;color:#b91c1c;margin-top:.3rem;}
        .remember{display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem;}
        .remember input[type=checkbox]{width:15px;height:15px;accent-color:var(--green);}
        .remember label{font-size:.82rem;font-weight:400;color:#6b7a63;margin:0;cursor:pointer;}
        .btn-submit{width:100%;padding:.8rem;background:var(--green);color:#fff;border:none;border-radius:var(--radius);font-family:var(--font-body);font-size:.95rem;font-weight:700;cursor:pointer;transition:background .2s;}
        .btn-submit:hover{background:var(--green-dk);}
        .back{display:block;text-align:center;margin-top:1.25rem;font-size:.8rem;color:#9ca3af;text-decoration:none;}
        .back:hover{color:var(--green);}
    </style>
</head>
<body>
<div class="card">
    <div class="card__top">
        <div class="brand">🌿 Mark<em></em>Foundation</div>
        <p>Recruitment Admin Panel</p>
    </div>
    <div class="card__body">
        @if(session('success'))<div class="alert alert-success">✓ {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">⚠ {{ session('error') }}</div>@endif

        <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input id="email" name="email" type="email"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email') }}" placeholder="recruiter@markfoundation.or.tz"
                    autocomplete="email" autofocus>
                @error('email')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="••••••••" autocomplete="current-password">
                @error('password')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Keep me signed in</label>
            </div>
            <button type="submit" class="btn-submit">Sign in →</button>
        </form>
        <a href="{{ route('home') }}" class="back">← Back to public site</a>
    </div>
</div>
</body>
</html>
