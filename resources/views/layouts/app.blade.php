<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetería · @yield('title', 'Bienvenido')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --granate: #990000;
            --granate-d: #6b0000;
            --granate-l: #c41a1a;
            --crema: #FFFBF2;
            --tinta: #1A1A1A;
            --tinta-s: #4a4a4a;
            --borde: #e8e0d0;
            --fondo-t: #f5efe3;
            --radius: 12px;
            --radius-lg: 20px;
            --sombra: 0 2px 16px rgba(26, 26, 26, .08);
            --sombra-h: 0 8px 32px rgba(153, 0, 0, .15);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--crema);
            color: var(--tinta);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            min-height: 100vh;
        }

        /* ── CABECERA ── */
        .site-header {
            background: var(--tinta);
            padding: 0 clamp(1rem, 5vw, 3rem);
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: var(--granate);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--crema);
            letter-spacing: .01em;
        }

        .logo-sub {
            font-size: .68rem;
            color: #888;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .header-badge {
            background: var(--granate);
            color: #fff;
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 99px;
        }

        /* ── MAIN ── */
        main {
            max-width: 1100px;
            margin: 0 auto;
            padding: clamp(1.5rem, 5vw, 3rem) clamp(1rem, 4vw, 2rem);
        }

        /* ── BOTONES ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 28px;
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all .2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--granate);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--granate-d);
            transform: translateY(-1px);
            box-shadow: var(--sombra-h);
        }

        .btn-outline {
            background: transparent;
            color: var(--granate);
            border: 1.5px solid var(--granate);
        }

        .btn-outline:hover {
            background: var(--granate);
            color: #fff;
        }

        /* ── UTILIDADES ── */
        .tag {
            display: inline-block;
            font-size: .7rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 99px;
        }

        .tag-granate {
            background: #fce8e8;
            color: var(--granate);
        }

        .tag-oro {
            background: #fdf3da;
            color: #8a6a00;
        }

        @media (max-width: 600px) {
            .logo-sub {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <header class="site-header">
        <a href="{{ url('/') }}" class="logo">
            <div class="logo-icon">☕</div>
            <div class="logo-text">
                <span class="logo-name">Cafetería UNI</span>
                <span class="logo-sub">Universidad · Campus</span>
            </div>
        </a>
        <span class="header-badge">@yield('header-badge', 'Pedidos online')</span>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>

</html>
