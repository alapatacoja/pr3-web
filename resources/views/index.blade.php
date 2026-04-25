@extends('layouts.app')

@section('title', 'Inicio')

@section('styles')
    <style>
        .page-intro {
            text-align: center;
            padding: clamp(2rem, 6vw, 4rem) 0 clamp(1.5rem, 4vw, 2.5rem);
        }

        .page-intro h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            line-height: 1.15;
            color: var(--tinta);
            margin-bottom: .75rem;
        }

        .page-intro h1 span {
            color: var(--granate);
        }

        .page-intro p {
            color: var(--tinta-s);
            font-size: 1.05rem;
            font-weight: 300;
            max-width: 480px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ── TARJETAS SELECCIÓN ── */
        .choice-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(1rem, 3vw, 2rem);
            max-width: 820px;
            margin: 0 auto;
            padding-bottom: 3rem;
        }

        .choice-card {
            background: #fff;
            border: 1.5px solid var(--borde);
            border-radius: var(--radius-lg);
            padding: clamp(1.8rem, 4vw, 2.8rem) clamp(1.5rem, 3vw, 2.2rem);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            transition: all .25s ease;
            position: relative;
            overflow: hidden;
        }

        .choice-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--granate) 0%, var(--granate-l) 100%);
            opacity: 0;
            transition: opacity .25s ease;
            border-radius: inherit;
        }

        .choice-card:hover {
            border-color: var(--granate);
            transform: translateY(-4px);
            box-shadow: var(--sombra-h);
        }

        .choice-card:hover::before {
            opacity: 1;
        }

        .choice-card:hover .card-icon,
        .choice-card:hover .card-title,
        .choice-card:hover .card-desc,
        .choice-card:hover .card-items,
        .choice-card:hover .card-cta {
            color: #fff;
        }

        .choice-card:hover .card-icon {
            background: rgba(255, 255, 255, .2);
        }

        .choice-card:hover .card-cta {
            background: rgba(255, 255, 255, .25);
            color: #fff;
        }

        .choice-card>* {
            position: relative;
            z-index: 1;
        }

        .card-icon {
            width: 56px;
            height: 56px;
            background: var(--fondo-t);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            transition: background .25s;
            color: var(--tinta);
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.3rem, 2.5vw, 1.7rem);
            font-weight: 700;
            color: var(--tinta);
            line-height: 1.2;
            transition: color .25s;
        }

        .card-desc {
            font-size: .9rem;
            color: var(--tinta-s);
            line-height: 1.6;
            font-weight: 300;
            transition: color .25s;
        }

        .card-items {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            transition: color .25s;
        }

        .card-items li {
            font-size: .75rem;
            background: var(--fondo-t);
            color: var(--tinta-s);
            padding: 4px 10px;
            border-radius: 99px;
            transition: background .25s, color .25s;
        }

        .choice-card:hover .card-items li {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        .card-cta {
            margin-top: auto;
            font-size: .85rem;
            font-weight: 500;
            color: var(--granate);
            background: #fce8e8;
            padding: 8px 18px;
            border-radius: 99px;
            transition: all .25s;
        }

        .card-time {
            position: absolute;
            top: 1.2rem;
            right: 1.4rem;
            font-size: .7rem;
            color: #aaa;
            font-weight: 300;
            z-index: 1;
            transition: color .25s;
        }

        .choice-card:hover .card-time {
            color: rgba(255, 255, 255, .7);
        }

        /* ── INFO STRIP ── */
        .info-strip {
            background: var(--fondo-t);
            border: 1px solid var(--borde);
            border-radius: var(--radius);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            max-width: 820px;
            margin: 0 auto 2rem;
            flex-wrap: wrap;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .82rem;
            color: var(--tinta-s);
        }

        .info-item span:first-child {
            font-size: 1rem;
        }

        @media (max-width: 580px) {
            .choice-grid {
                grid-template-columns: 1fr;
            }

            .card-time {
                display: none;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-intro">
        <h1>¿Qué vas a pedir <span>hoy</span>?</h1>
        <p>Haz tu pedido online y recógelo sin esperas. Sin colas, sin perder tiempo.</p>
    </div>

    <div class="info-strip">
        <div class="info-item"><span>🤖</span><span>Robot de autoservicio disponible</span></div>
        <div class="info-item"><span>🛺</span><span>AGVs para menús del día</span></div>
        <div class="info-item"><span>⭐</span><span>Entrega en mesa para zona VIP</span></div>
    </div>

    <div class="choice-grid">

        {{-- PEDIDO RÁPIDO --}}
        <a href="{{ url('/order/robot') }}" class="choice-card">
            <span class="card-time">~2 min</span>
            <div class="card-icon">⚡</div>
            <div class="card-title">Pedido<br>rápido</div>
            <p class="card-desc">Bocadillos, bollería, cafés y bebidas frías. Lo prepara el robot y lo tienes en minutos.
            </p>
            <ul class="card-items">
                <li>🥖 Bocadillos</li>
                <li>☕ Cafés</li>
                <li>🥐 Bollería</li>
                <li>🥤 Bebidas</li>
            </ul>
            <span class="card-cta">Pedir ahora →</span>
        </a>

        {{-- MENÚ DEL DÍA --}}
        <a href="{{ url('/order/menu') }}" class="choice-card">
            <span class="card-time">~15 min</span>
            <div class="card-icon">🍽️</div>
            <div class="card-title">Menú<br>del día</div>
            <p class="card-desc">Primero, segundo y postre. Cuatro opciones diarias para todos los gustos y necesidades.</p>
            <ul class="card-items">
                <li>🍛 Completo</li>
                <li>🥗 Vegetariano</li>
                <li>🥙 Medio menú</li>
                <li>🥦 Saludable</li>
            </ul>
            <span class="card-cta">Ver menú →</span>
        </a>

    </div>

@endsection
