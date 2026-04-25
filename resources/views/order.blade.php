@extends('layouts.app')

@section('title', $type === 'robot' ? 'Pedido rápido' : 'Menú del día')
@section('header-badge', $type === 'robot' ? '⚡ Pedido rápido' : '🍽️ Menú del día')

@section('styles')
    <style>
        /* ── LAYOUT PRINCIPAL ── */
        .order-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2rem;
            align-items: start;
        }

        /* ── ENCABEZADO SECCIÓN ── */
        .section-head {
            margin-bottom: 2rem;
        }

        .section-head h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            color: var(--tinta);
            margin-bottom: .4rem;
        }

        .section-head p {
            color: var(--tinta-s);
            font-weight: 300;
            font-size: .95rem;
        }

        /* ── CATEGORÍAS (ROBOT) ── */
        .category-block {
            margin-bottom: 2.5rem;
        }

        .category-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .category-label h3 {
            font-size: .75rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--tinta-s);
        }

        .category-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--borde);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: .75rem;
        }

        /* ── TARJETA PRODUCTO NORMAL ── */
        .product-card {
            background: #fff;
            border: 1.5px solid var(--borde);
            border-radius: var(--radius);
            padding: 1rem;
            cursor: pointer;
            transition: all .2s ease;
            display: flex;
            flex-direction: column;
            gap: .5rem;
            user-select: none;
        }

        .product-card:hover {
            border-color: var(--granate);
            box-shadow: var(--sombra-h);
            transform: translateY(-2px);
        }

        .product-card.selected {
            border-color: var(--granate);
            background: #fff8f8;
        }

        .product-card .p-name {
            font-size: .9rem;
            font-weight: 500;
            color: var(--tinta);
            line-height: 1.3;
        }

        .product-card .p-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--granate);
            font-weight: 600;
        }

        .product-card .p-counter {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
        }

        .counter-btn {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1.5px solid var(--borde);
            background: transparent;
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            color: var(--tinta);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
            flex-shrink: 0;
        }

        .counter-btn:hover {
            border-color: var(--granate);
            background: var(--granate);
            color: #fff;
        }

        .counter-val {
            font-weight: 500;
            font-size: .9rem;
            min-width: 20px;
            text-align: center;
        }

        /* ── DESTACADOS (bocata del día / especial) ── */
        .featured-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-bottom: .75rem;
        }

        .product-card.featured {
            border-color: #d4a800;
            background: linear-gradient(135deg, #fffdf0 0%, #fff8dc 100%);
            position: relative;
        }

        .product-card.featured:hover {
            border-color: #b88f00;
            box-shadow: 0 8px 24px rgba(180, 140, 0, .18);
        }

        .featured-badge {
            position: absolute;
            top: -1px;
            right: -1px;
            background: #d4a800;
            color: #fff;
            font-size: .62rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 0 var(--radius) 0 var(--radius);
        }

        .product-card.featured .p-price {
            color: #8a6a00;
        }

        /* ── TARJETAS MENÚ ── */
        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .menu-card {
            background: #fff;
            border: 1.5px solid var(--borde);
            border-radius: var(--radius-lg);
            padding: 1.4rem 1.6rem;
            cursor: pointer;
            transition: all .2s ease;
            display: grid;
            grid-template-columns: 56px 1fr auto;
            gap: 1.2rem;
            align-items: center;
            user-select: none;
        }

        .menu-card:hover {
            border-color: var(--granate);
            box-shadow: var(--sombra-h);
            transform: translateY(-2px);
        }

        .menu-card.selected {
            border-color: var(--granate);
            background: #fff8f8;
        }

        .menu-icon {
            width: 56px;
            height: 56px;
            background: var(--fondo-t);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
            transition: background .2s;
        }

        .menu-card:hover .menu-icon,
        .menu-card.selected .menu-icon {
            background: #fce8e8;
        }

        .menu-info h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--tinta);
            margin-bottom: .3rem;
        }

        .menu-platos {
            font-size: .8rem;
            color: var(--tinta-s);
            font-weight: 300;
            line-height: 1.5;
        }

        .menu-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: .5rem;
            flex-shrink: 0;
        }

        .menu-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--granate);
            font-weight: 600;
            white-space: nowrap;
        }

        .menu-select-btn {
            font-size: .75rem;
            font-weight: 500;
            padding: 5px 14px;
            border-radius: 99px;
            border: 1.5px solid var(--borde);
            background: transparent;
            color: var(--tinta-s);
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }

        .menu-card.selected .menu-select-btn {
            background: var(--granate);
            color: #fff;
            border-color: var(--granate);
        }

        /* ── CAMPO MESA VIP (solo en menú) ── */
        .vip-box {
            background: linear-gradient(135deg, #fff8f8, #fff2f2);
            border: 1.5px solid #f0c0c0;
            border-radius: var(--radius);
            padding: 1.2rem 1.4rem;
            margin-top: 1.5rem;
            display: none;
        }

        .vip-box.show {
            display: block;
        }

        .vip-box h4 {
            font-size: .85rem;
            font-weight: 500;
            color: var(--granate);
            margin-bottom: .3rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .vip-box p {
            font-size: .78rem;
            color: var(--tinta-s);
            margin-bottom: .8rem;
            font-weight: 300;
        }

        .vip-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #f0c0c0;
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            color: var(--tinta);
            background: #fff;
            outline: none;
            transition: border-color .2s;
        }

        .vip-input:focus {
            border-color: var(--granate);
        }

        /* ── CARRITO ── */
        .cart-panel {
            background: #fff;
            border: 1.5px solid var(--borde);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            position: sticky;
            top: 88px;
        }

        .cart-panel h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-badge {
            background: var(--granate);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .7rem;
            font-weight: 600;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .cart-empty {
            text-align: center;
            padding: 2rem 0;
            color: #bbb;
            font-size: .85rem;
            font-weight: 300;
        }

        .cart-empty span {
            font-size: 2rem;
            display: block;
            margin-bottom: .5rem;
        }

        .cart-items {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            padding: .5rem 0;
            border-bottom: 1px solid var(--borde);
            font-size: .85rem;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-name {
            color: var(--tinta);
            font-weight: 400;
            flex: 1;
        }

        .cart-item-qty {
            color: var(--tinta-s);
            font-size: .78rem;
            white-space: nowrap;
        }

        .cart-item-price {
            color: var(--granate);
            font-weight: 500;
            white-space: nowrap;
        }

        .cart-item-remove {
            background: none;
            border: none;
            color: #ccc;
            cursor: pointer;
            font-size: .9rem;
            padding: 0 2px;
            transition: color .15s;
            line-height: 1;
        }

        .cart-item-remove:hover {
            color: var(--granate);
        }

        .cart-divider {
            height: 1px;
            background: var(--borde);
            margin: 1rem 0;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 1.2rem;
        }

        .cart-total span:first-child {
            font-size: .82rem;
            color: var(--tinta-s);
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 500;
        }

        .cart-total-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--tinta);
            font-weight: 600;
        }

        .btn-checkout {
            width: 100%;
            padding: 14px;
            background: var(--granate);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-checkout:hover:not(:disabled) {
            background: var(--granate-d);
            transform: translateY(-1px);
            box-shadow: var(--sombra-h);
        }

        .btn-checkout:disabled {
            background: #ddd;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-back {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--tinta-s);
            font-size: .85rem;
            text-decoration: none;
            margin-bottom: 1.5rem;
            transition: color .15s;
        }

        .btn-back:hover {
            color: var(--granate);
        }

        @media (max-width: 780px) {
            .order-layout {
                grid-template-columns: 1fr;
            }

            .cart-panel {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: auto;
                border-radius: var(--radius-lg) var(--radius-lg) 0 0;
                border-bottom: none;
                box-shadow: 0 -4px 24px rgba(0, 0, 0, .12);
                z-index: 50;
                padding: 1rem 1.2rem;
                max-height: 50vh;
                overflow-y: auto;
            }

            main {
                padding-bottom: 220px;
            }

            .menu-card {
                grid-template-columns: 44px 1fr auto;
                gap: .8rem;
            }

            .menu-icon {
                width: 44px;
                height: 44px;
                font-size: 20px;
                border-radius: 10px;
            }

            .featured-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')

    <a href="{{ url('/') }}" class="btn-back">← Volver al inicio</a>

    <div class="order-layout">

        {{-- ═══ COLUMNA PRODUCTOS ═══ --}}
        <div class="products-col">

            @if ($type === 'robot')
                {{-- ── PEDIDO RÁPIDO ── --}}
                <div class="section-head">
                    <h2>Pedido rápido</h2>
                    <p>Listo en minutos · Recogida en ventanilla robot con tu ticket</p>
                </div>

                {{-- BOCADILLOS DESTACADOS --}}
                @if (isset($products['bocata_especial']) || isset($products['bocata_dia']))
                    <div class="category-block">
                        <div class="category-label">
                            <h3>🌟 Destacados del día</h3>
                        </div>
                        <div class="featured-grid">
                            @foreach ($products->only(['bocata_especial', 'bocata_dia'])->flatten() as $product)
                                <div class="product-card featured"
                                    onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                                    <span class="featured-badge">
                                        {{ $product->category === 'bocata_dia' ? 'Del día' : 'Especial' }}
                                    </span>
                                    <div class="p-name">{{ $product->name }}</div>
                                    <div class="p-price">{{ number_format($product->price, 2) }} €</div>
                                    <div class="p-counter">
                                        <button class="counter-btn"
                                            onclick="event.stopPropagation(); changeQty({{ $product->id }}, -1)">−</button>
                                        <span class="counter-val" id="qty-{{ $product->id }}">0</span>
                                        <button class="counter-btn"
                                            onclick="event.stopPropagation(); changeQty({{ $product->id }}, 1)">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- RESTO DE CATEGORÍAS --}}
                @php
                    $labels = [
                        'bocata' => ['emoji' => '🥖', 'label' => 'Bocadillos'],
                        'bolleria' => ['emoji' => '🥐', 'label' => 'Bollería'],
                        'cafe' => ['emoji' => '☕', 'label' => 'Cafés'],
                        'bebida' => ['emoji' => '🥤', 'label' => 'Bebidas frías'],
                    ];
                @endphp

                @foreach ($labels as $cat => $meta)
                    @if (isset($products[$cat]) && $products[$cat]->count())
                        <div class="category-block">
                            <div class="category-label">
                                <h3>{{ $meta['emoji'] }} {{ $meta['label'] }}</h3>
                            </div>
                            <div class="products-grid">
                                @foreach ($products[$cat] as $product)
                                    <div class="product-card"
                                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                                        <div class="p-name">{{ $product->name }}</div>
                                        <div class="p-price">{{ number_format($product->price, 2) }} €</div>
                                        <div class="p-counter">
                                            <button class="counter-btn"
                                                onclick="event.stopPropagation(); changeQty({{ $product->id }}, -1)">−</button>
                                            <span class="counter-val" id="qty-{{ $product->id }}">0</span>
                                            <button class="counter-btn"
                                                onclick="event.stopPropagation(); changeQty({{ $product->id }}, 1)">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                {{-- ── MENÚ DEL DÍA ── --}}
                <div class="section-head">
                    <h2>Menú del día</h2>
                    <p>Elige tu opción · AGV lo lleva a ventanilla o a tu mesa si eres zona VIP</p>
                </div>

                @php
                    $menuMeta = [
                        'menu_completo' => ['icon' => '🍛', 'desc' => 'Primero + segundo + postre + bebida'],
                        'menu_medio' => ['icon' => '🥙', 'desc' => 'Segundo + bebida'],
                        'menu_vegetariano' => [
                            'icon' => '🥗',
                            'desc' => 'Primero vegetariano + segundo vegetal + postre',
                        ],
                        'menu_saludable' => ['icon' => '🥦', 'desc' => 'Ensalada + proteína + fruta + agua'],
                    ];
                @endphp

                <div class="menu-list">
                    @foreach ($products->flatten() as $product)
                        @php $meta = $menuMeta[$product->category] ?? ['icon' => '🍽️', 'desc' => '']; @endphp
                        <div class="menu-card" id="menu-card-{{ $product->id }}"
                            onclick="selectMenu({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                            <div class="menu-icon">{{ $meta['icon'] }}</div>
                            <div class="menu-info">
                                <h4>{{ $product->name }}</h4>
                                <div class="menu-platos">{{ $meta['desc'] }}</div>
                            </div>
                            <div class="menu-right">
                                <span class="menu-price">{{ number_format($product->price, 2) }} €</span>
                                <button class="menu-select-btn" id="btn-{{ $product->id }}">Elegir</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- VIP --}}
                <div class="vip-box" id="vip-box">
                    <h4>⭐ Zona VIP — entrega en mesa</h4>
                    <p>Si eres de zona VIP el AGV te lleva el menú a tu mesa. Si no lo eres, déjalo vacío y recógelo en
                        ventanilla.</p>
                    <input type="number" id="table-number" class="vip-input" placeholder="Número de mesa (opcional)"
                        min="1" max="999">
                </div>

            @endif

        </div>

        {{-- ═══ CARRITO ═══ --}}
        <aside class="cart-panel">
            <h3>
                Tu pedido
                <span class="cart-badge" id="cart-count">0</span>
            </h3>

            <div id="cart-empty" class="cart-empty">
                <span>🛒</span>Añade algo para empezar
            </div>

            <ul class="cart-items" id="cart-list" style="display:none"></ul>

            <div id="cart-footer" style="display:none">
                <div class="cart-divider"></div>
                <div class="cart-total">
                    <span>Total</span>
                    <span class="cart-total-price" id="cart-total">0,00 €</span>
                </div>
                <form method="POST" action="{{ url('/checkout') }}" id="checkout-form">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="cart" id="cart-input">
                    <input type="hidden" name="table_number" id="table-input">
                    <button type="submit" class="btn-checkout" id="btn-checkout">
                        Confirmar pedido
                    </button>
                </form>
            </div>
        </aside>

    </div>

@endsection

@section('scripts')
    <script>
        const TYPE = '{{ $type }}';
        let cart = {}; // { id: { name, price, qty } }
        let selectedMenu = null;

        /* ── ROBOT: añadir/cambiar cantidad ── */
        function addToCart(id, name, price) {
            if (!cart[id]) cart[id] = {
                name,
                price,
                qty: 0
            };
            cart[id].qty++;
            updateQtyDisplay(id);
            renderCart();
        }

        function changeQty(id, delta) {
            if (!cart[id]) return;
            cart[id].qty = Math.max(0, cart[id].qty + delta);
            if (cart[id].qty === 0) delete cart[id];
            updateQtyDisplay(id);
            renderCart();
        }

        function updateQtyDisplay(id) {
            const el = document.getElementById('qty-' + id);
            if (el) el.textContent = cart[id] ? cart[id].qty : 0;
        }

        /* ── MENÚ: selección única ── */
        function selectMenu(id, name, price) {
            // Deseleccionar anterior
            if (selectedMenu !== null) {
                document.getElementById('menu-card-' + selectedMenu)?.classList.remove('selected');
                document.getElementById('btn-' + selectedMenu).textContent = 'Elegir';
            }

            if (selectedMenu === id) {
                selectedMenu = null;
                cart = {};
            } else {
                selectedMenu = id;
                cart = {
                    [id]: {
                        name,
                        price,
                        qty: 1
                    }
                };
                document.getElementById('menu-card-' + id).classList.add('selected');
                document.getElementById('btn-' + id).textContent = '✓ Seleccionado';
                document.getElementById('vip-box')?.classList.add('show');
            }
            renderCart();
        }

        /* ── RENDER CARRITO ── */
        function renderCart() {
            const items = Object.entries(cart).filter(([, v]) => v.qty > 0);
            const count = items.reduce((s, [, v]) => s + v.qty, 0);
            const total = items.reduce((s, [, v]) => s + v.price * v.qty, 0);

            document.getElementById('cart-count').textContent = count;

            const emptyEl = document.getElementById('cart-empty');
            const listEl = document.getElementById('cart-list');
            const footerEl = document.getElementById('cart-footer');

            if (items.length === 0) {
                emptyEl.style.display = 'block';
                listEl.style.display = 'none';
                footerEl.style.display = 'none';
                return;
            }

            emptyEl.style.display = 'none';
            listEl.style.display = 'flex';
            footerEl.style.display = 'block';

            listEl.innerHTML = items.map(([id, item]) => `
        <li class="cart-item">
            <span class="cart-item-name">${item.name}</span>
            <span class="cart-item-qty">×${item.qty}</span>
            <span class="cart-item-price">${(item.price * item.qty).toFixed(2).replace('.', ',')} €</span>
            <button class="cart-item-remove" onclick="removeItem(${id})" title="Quitar">✕</button>
        </li>
    `).join('');

            document.getElementById('cart-total').textContent =
                total.toFixed(2).replace('.', ',') + ' €';

            // Preparar para el form
            document.getElementById('cart-input').value = JSON.stringify(
                items.map(([id, item]) => ({
                    id: parseInt(id),
                    qty: item.qty,
                    price: item.price
                }))
            );
        }

        function removeItem(id) {
            if (TYPE === 'menu') {
                selectedMenu = null;
                document.getElementById('vip-box')?.classList.remove('show');
            }
            delete cart[id];
            const el = document.getElementById('qty-' + id);
            if (el) el.textContent = 0;
            renderCart();
        }

        /* ── SUBMIT: meter número de mesa si VIP ── */
        document.getElementById('checkout-form')?.addEventListener('submit', function() {
            const mesa = document.getElementById('table-number')?.value || '';
            document.getElementById('table-input').value = mesa;
        });
    </script>
@endsection
