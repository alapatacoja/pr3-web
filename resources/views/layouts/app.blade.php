<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetería · @yield('title', 'Bienvenido')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 — aquí estaba el problema, faltaba este link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --granate:   #990000;
            --granate-d: #6b0000;
            --granate-l: #c41a1a;
            --crema:     #FFFBF2;
            --tinta:     #1A1A1A;
            --tinta-s:   #4a4a4a;
            --borde:     #e8e0d0;
            --fondo-t:   #f5efe3;
            --radius:    12px;
            --radius-lg: 20px;
            --sombra:    0 2px 16px rgba(26,26,26,.08);
            --sombra-h:  0 8px 32px rgba(153,0,0,.15);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 200;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            height: 100%;
        }

        .logo-img {
            height: 80px;
            width: auto;
            display: block;
            object-fit: contain;
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

        .btn-primary { background: var(--granate); color: #fff; }
        .btn-primary:hover {
            background: var(--granate-d);
            transform: translateY(-1px);
            box-shadow: var(--sombra-h);
        }

        .tag {
            display: inline-block;
            font-size: .7rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 99px;
        }
    </style>
    @yield('styles')
</head>

<body>

<header class="site-header">
    <a href="{{ url('/') }}" class="logo">
        <img src="{{ asset('imgs/VELLAk_blanco.png') }}" alt="Cafetería" class="logo-img">
    </a>
</header>

<main>
    @yield('content')
</main>

@yield('scripts')
</body>
</html>