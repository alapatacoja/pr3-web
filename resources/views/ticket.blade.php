@extends('layouts.app')

@section('title', 'Pedido #' . $order->order_number)
@section('header-badge', '✓ Pedido confirmado')

@section('styles')
    <style>
        .ticket-wrap {
            max-width: 520px;
            margin: 0 auto;
            padding: 2rem 0 4rem;
        }

        /* ── CONFIRMACIÓN ANIMADA ── */
        .confirm-header {
            text-align: center;
            margin-bottom: 2.5rem;
            animation: fadeUp .5s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .check-circle {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #990000, #c41a1a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 30px;
            animation: popIn .4s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes popIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .confirm-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            margin-bottom: .4rem;
        }

        .confirm-header p {
            color: var(--tinta-s);
            font-size: .95rem;
            font-weight: 300;
        }

        /* ── TICKET CARD ── */
        .ticket-card {
            background: #fff;
            border: 1.5px solid var(--borde);
            border-radius: var(--radius-lg);
            overflow: hidden;
            animation: fadeUp .5s .15s ease both;
            margin-bottom: 1.2rem;
        }

        .ticket-top {
            background: var(--tinta);
            padding: 1.4rem 1.8rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ticket-num-label {
            font-size: .68rem;
            color: #888;
            letter-spacing: .14em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .ticket-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            color: #fff;
            letter-spacing: .05em;
        }

        .ticket-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4caf50;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .6;
                transform: scale(.85);
            }
        }

        .status-text {
            font-size: .75rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        /* ── ENTREGA DESTACADA ── */
        .delivery-banner {
            padding: 1.2rem 1.8rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px dashed var(--borde);
        }

        .delivery-banner.robot {
            background: #f0f8ff;
        }

        .delivery-banner.agv {
            background: #f5fff0;
        }

        .delivery-banner.vip {
            background: linear-gradient(135deg, #fff8f8, #fff0f0);
        }

        .delivery-icon {
            font-size: 2.2rem;
            flex-shrink: 0;
        }

        .delivery-text h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            margin-bottom: .2rem;
            color: var(--tinta);
        }

        .delivery-text p {
            font-size: .83rem;
            color: var(--tinta-s);
            font-weight: 300;
            line-height: 1.5;
        }

        /* ── QR ── */
        .qr-section {
            padding: 1.8rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px dashed var(--borde);
        }

        .qr-wrap {
            background: #fff;
            padding: 1rem;
            border: 1.5px solid var(--borde);
            border-radius: var(--radius);
            line-height: 0;
        }

        .qr-hint {
            font-size: .78rem;
            color: var(--tinta-s);
            text-align: center;
            font-weight: 300;
            line-height: 1.5;
        }

        /* ── RESUMEN LÍNEAS ── */
        .order-lines {
            padding: 1.2rem 1.8rem;
        }

        .order-line {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: .45rem 0;
            font-size: .88rem;
            border-bottom: 1px solid var(--borde);
        }

        .order-line:last-child {
            border-bottom: none;
        }

        .line-name {
            color: var(--tinta);
        }

        .line-qty {
            color: var(--tinta-s);
            font-size: .78rem;
            margin-left: 4px;
        }

        .line-price {
            color: var(--granate);
            font-weight: 500;
        }

        .order-total-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 1rem 1.8rem;
            background: var(--fondo-t);
            border-top: 1.5px solid var(--borde);
        }

        .order-total-label {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--tinta-s);
            font-weight: 500;
        }

        .order-total-val {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--tinta);
            font-weight: 600;
        }

        /* ── BOTÓN NUEVO PEDIDO ── */
        .new-order-wrap {
            text-align: center;
            animation: fadeUp .5s .3s ease both;
        }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--tinta);
            color: var(--crema);
            padding: 14px 32px;
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-new:hover {
            background: var(--granate);
            transform: translateY(-2px);
            box-shadow: var(--sombra-h);
        }

        .btn-new-hint {
            display: block;
            margin-top: .7rem;
            font-size: .78rem;
            color: var(--tinta-s);
            font-weight: 300;
        }

        @media (max-width: 560px) {
            .ticket-top {
                flex-direction: column;
                align-items: flex-start;
                gap: .8rem;
            }

            .ticket-status {
                align-items: flex-start;
                flex-direction: row;
            }
        }
    </style>
@endsection

@section('content')

    <div class="ticket-wrap">

        {{-- ── CABECERA CONFIRMACIÓN ── --}}
        <div class="confirm-header">
            <div class="check-circle">✓</div>
            <h2>¡Pedido realizado!</h2>
            <p>Guarda el número o muestra el QR para recoger tu pedido</p>
        </div>

        {{-- ── TICKET ── --}}
        <div class="ticket-card">

            {{-- Número + estado --}}
            <div class="ticket-top">
                <div>
                    <div class="ticket-num-label">Número de pedido</div>
                    <div class="ticket-num">{{ $order->order_number }}</div>
                </div>
                <div class="ticket-status">
                    <div class="status-dot"></div>
                    <span class="status-text">En preparación</span>
                </div>
            </div>

            {{-- Banner entrega según tipo --}}
            @if ($order->type === 'robot')
                <div class="delivery-banner robot">
                    <div class="delivery-icon">🤖</div>
                    <div class="delivery-text">
                        <h4>Recoge en el robot</h4>
                        <p>Dirígete a la ventanilla del robot de autoservicio y escanea el QR o introduce tu número de
                            pedido.</p>
                    </div>
                </div>
            @elseif($order->type === 'agv')
                <div class="delivery-banner agv">
                    <div class="delivery-icon">🛺</div>
                    <div class="delivery-text">
                        <h4>Recoge en ventanilla AGV</h4>
                        <p>El AGV llevará tu menú a la ventanilla de recogida. Cuando esté listo recibirás aviso por
                            pantalla.</p>
                    </div>
                </div>
            @elseif($order->type === 'vip')
                <div class="delivery-banner vip">
                    <div class="delivery-icon">⭐</div>
                    <div class="delivery-text">
                        <h4>Entrega en mesa {{ $order->table_number }}</h4>
                        <p>El AGV llevará tu menú directamente a tu mesa. Permanece sentado y espera la entrega.</p>
                    </div>
                </div>
            @endif

            {{-- QR --}}
            <div class="qr-section">
                <div class="qr-wrap">
                    {!! QrCode::size(180)->generate($order->order_number) !!}
                </div>
                <p class="qr-hint">Muestra este código en la ventanilla<br>o úsalo en el lector del robot</p>
            </div>

            {{-- Líneas del pedido --}}
            <div class="order-lines">
                @foreach ($order->items as $item)
                    <div class="order-line">
                        <span>
                            <span class="line-name">{{ $item->product->name }}</span>
                            <span class="line-qty">×{{ $item->quantity }}</span>
                        </span>
                        <span class="line-price">{{ number_format($item->unit_price * $item->quantity, 2) }} €</span>
                    </div>
                @endforeach
            </div>

            <div class="order-total-row">
                <span class="order-total-label">Total pagado</span>
                <span class="order-total-val">{{ number_format($order->total_price, 2) }} €</span>
            </div>

        </div>

        {{-- ── NUEVO PEDIDO ── --}}
        <div class="new-order-wrap">
            <a href="{{ url('/') }}" class="btn-new">
                ← Hacer otro pedido
            </a>
            <span class="btn-new-hint">El pedido queda guardado con el número de arriba</span>
        </div>

    </div>

@endsection
