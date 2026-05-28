@extends('layouts.app')

@section('title', $type === 'robot' ? 'Pedido rápido' : 'Menú del día')

@section('styles')
<style>
    /* ── LAYOUT PRINCIPAL ── */
    .order-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 2rem;
        align-items: start;
    }

    /* ── ENCABEZADO ── */
    .section-head { margin-bottom: 2rem; }
    .section-head h2 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        color: var(--tinta);
        margin-bottom: .4rem;
    }
    .section-head p { color: var(--tinta-s); font-weight: 300; font-size: .9rem; }
    .section-head p i { color: var(--granate); margin-right: 4px; }

    /* ── CATEGORÍAS ── */
    .category-block { margin-bottom: 2.5rem; }

    .category-label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
    }
    .category-label h3 {
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--tinta-s);
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .category-label h3 i { color: var(--granate); font-size: .8rem; }
    .category-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--borde);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: .75rem;
    }

    /* ── TARJETA PRODUCTO ── */
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
        position: relative;
    }
    .product-card:hover {
        border-color: var(--granate);
        box-shadow: var(--sombra-h);
        transform: translateY(-2px);
    }
    .product-card .p-name { font-size: .9rem; font-weight: 500; line-height: 1.3; }
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
        width: 28px; height: 28px;
        border-radius: 50%;
        border: 1.5px solid var(--borde);
        background: transparent;
        cursor: pointer;
        color: var(--tinta);
        display: flex; align-items: center; justify-content: center;
        transition: all .15s;
        flex-shrink: 0;
        font-size: .85rem;
    }
    .counter-btn:hover { border-color: var(--granate); background: var(--granate); color: #fff; }
    .counter-val { font-weight: 500; font-size: .9rem; min-width: 20px; text-align: center; }

    /* ── DESTACADOS ── */
    .featured-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .75rem;
        margin-bottom: .75rem;
    }

    .product-card.featured {
        border-color: #c9960a;
        background: linear-gradient(135deg, #fffdf0, #fff8dc);
    }
    .product-card.featured:hover {
        border-color: #a07800;
        box-shadow: 0 8px 24px rgba(160,120,0,.15);
    }
    .product-card.featured .p-price { color: #8a6a00; }

    .featured-badge {
        position: absolute;
        top: -1px; right: -1px;
        background: #c9960a;
        color: #fff;
        font-size: .6rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 0 var(--radius) 0 var(--radius);
        display: flex; align-items: center; gap: 4px;
    }

    /* ── TARJETAS MENÚ ── */
    .menu-list { display: flex; flex-direction: column; gap: 1rem; }

    .menu-card {
        background: #fff;
        border: 1.5px solid var(--borde);
        border-radius: var(--radius-lg);
        padding: 1.3rem 1.5rem;
        cursor: pointer;
        transition: all .2s ease;
        display: grid;
        grid-template-columns: 52px 1fr auto;
        gap: 1.1rem;
        align-items: center;
        user-select: none;
    }
    .menu-card:hover { border-color: var(--granate); box-shadow: var(--sombra-h); transform: translateY(-2px); }
    .menu-card.selected { border-color: var(--granate); background: #fff8f8; }

    .menu-icon {
        width: 52px; height: 52px;
        background: var(--fondo-t);
        border-radius: 13px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        color: var(--granate);
        flex-shrink: 0;
        transition: background .2s;
    }
    .menu-card:hover .menu-icon,
    .menu-card.selected .menu-icon { background: #fce8e8; }

    .menu-info h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        margin-bottom: .25rem;
    }
    .menu-platos { font-size: .78rem; color: var(--tinta-s); font-weight: 300; line-height: 1.5; }

    .menu-right { display: flex; flex-direction: column; align-items: flex-end; gap: .5rem; flex-shrink: 0; }
    .menu-price {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        color: var(--granate);
        font-weight: 600;
        white-space: nowrap;
    }
    .menu-select-btn {
        font-size: .75rem; font-weight: 500;
        padding: 5px 14px;
        border-radius: 99px;
        border: 1.5px solid var(--borde);
        background: transparent;
        color: var(--tinta-s);
        cursor: pointer;
        transition: all .2s;
        white-space: nowrap;
        display: flex; align-items: center; gap: 5px;
    }
    .menu-card.selected .menu-select-btn { background: var(--granate); color: #fff; border-color: var(--granate); }

    /* ── VIP BOX ── */
    .vip-box {
        background: linear-gradient(135deg, #fff8f8, #fff2f2);
        border: 1.5px solid #f0c0c0;
        border-radius: var(--radius);
        padding: 1.2rem 1.4rem;
        margin-bottom: 1.5rem;
        display: none;
    }
    .vip-box.show { display: block; }
    .vip-box h4 { font-size: .85rem; font-weight: 500; color: var(--granate); margin-bottom: .3rem; display: flex; align-items: center; gap: 7px; }
    .vip-box p { font-size: .78rem; color: var(--tinta-s); margin-bottom: .8rem; font-weight: 300; }
    .vip-input {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #f0c0c0;
        border-radius: var(--radius);
        font-family: 'DM Sans', sans-serif;
        font-size: 1rem; color: var(--tinta); background: #fff;
        outline: none; transition: border-color .2s;
    }
    .vip-input:focus { border-color: var(--granate); }

    /* ── BOTÓN VOLVER ── */
    .btn-back {
        display: inline-flex; align-items: center; gap: 7px;
        color: var(--tinta-s); font-size: .85rem;
        text-decoration: none; margin-bottom: 1.5rem;
        transition: color .15s;
    }
    .btn-back:hover { color: var(--granate); }
    .btn-back i { font-size: .8rem; }

    /* ════════════════════════════════
       CARRITO — DESKTOP (sticky lateral)
    ════════════════════════════════ */
    .cart-panel {
        background: #fff;
        border: 1.5px solid var(--borde);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        position: sticky;
        top: 70px;
    }

    .cart-panel h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        margin-bottom: 1.2rem;
        display: flex; align-items: center; gap: 8px;
    }
    .cart-panel h3 i { color: var(--granate); font-size: 1rem; }

    .cart-badge {
        background: var(--granate); color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .65rem; font-weight: 700;
        width: 19px; height: 19px;
        border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        margin-left: auto;
    }

    .cart-empty { text-align: center; padding: 2rem 0; color: #bbb; font-size: .85rem; font-weight: 300; }
    .cart-empty i { font-size: 2rem; display: block; margin-bottom: .6rem; color: #ddd; }

    .cart-items { list-style: none; display: flex; flex-direction: column; gap: .5rem; }
    .cart-item {
        display: flex; align-items: center; justify-content: space-between; gap: .4rem;
        padding: .45rem 0; border-bottom: 1px solid var(--borde); font-size: .84rem;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item-name { color: var(--tinta); flex: 1; }
    .cart-item-qty { color: var(--tinta-s); font-size: .76rem; white-space: nowrap; }
    .cart-item-price { color: var(--granate); font-weight: 500; white-space: nowrap; }
    .cart-item-remove {
        background: none; border: none; color: #ccc;
        cursor: pointer; font-size: .85rem; padding: 0 2px;
        transition: color .15s; line-height: 1;
    }
    .cart-item-remove:hover { color: var(--granate); }

    .cart-divider { height: 1px; background: var(--borde); margin: 1rem 0; }
    .cart-total { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1rem; }
    .cart-total span:first-child { font-size: .78rem; color: var(--tinta-s); text-transform: uppercase; letter-spacing: .08em; font-weight: 500; }
    .cart-total-price { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--tinta); font-weight: 600; }

    .btn-checkout {
        width: 100%; padding: 13px;
        background: var(--granate); color: #fff;
        border: none; border-radius: var(--radius);
        font-family: 'DM Sans', sans-serif;
        font-size: .95rem; font-weight: 500;
        cursor: pointer; transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-checkout:hover:not(:disabled) { background: var(--granate-d); transform: translateY(-1px); box-shadow: var(--sombra-h); }
    .btn-checkout:disabled { background: #ddd; cursor: not-allowed; }

    /* ════════════════════════════════
       CARRITO MÓVIL — FAB + DRAWER
    ════════════════════════════════ */

    /* Botón flotante (solo móvil) */
    .cart-fab {
        display: none;
        position: fixed;
        bottom: 1.5rem; right: 1.5rem;
        z-index: 150;
        background: var(--granate);
        color: #fff;
        width: 58px; height: 58px;
        border-radius: 50%;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(153,0,0,.4);
        transition: transform .2s, box-shadow .2s;
        align-items: center; justify-content: center;
    }
    .cart-fab:hover { transform: scale(1.08); box-shadow: 0 6px 28px rgba(153,0,0,.5); }

    .cart-fab-badge {
        position: absolute;
        top: -4px; right: -4px;
        background: #fff;
        color: var(--granate);
        font-size: .65rem; font-weight: 700;
        width: 20px; height: 20px;
        border-radius: 50%;
        display: none;
        align-items: center; justify-content: center;
        border: 2px solid var(--granate);
    }
    .cart-fab-badge.visible { display: flex; }

    /* Overlay oscuro */
    .cart-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.45);
        z-index: 160;
        opacity: 0;
        transition: opacity .25s;
    }
    .cart-overlay.open { display: block; opacity: 1; }

    /* Drawer desde abajo */
    .cart-drawer {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        z-index: 170;
        background: #fff;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        padding: 0 1.3rem 2rem;
        max-height: 85vh;
        overflow-y: auto;
        transform: translateY(100%);
        transition: transform .3s cubic-bezier(.32,.72,0,1);
        display: none;
    }
    .cart-drawer.open { display: block; transform: translateY(0); }

    .drawer-handle {
        display: flex; justify-content: center; padding: 12px 0 8px;
    }
    .drawer-handle::before {
        content: '';
        width: 40px; height: 4px;
        background: var(--borde);
        border-radius: 2px;
    }

    .drawer-header {
        display: flex; align-items: center; justify-content: space-between;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--borde);
        margin-bottom: 1rem;
        padding-top: 1rem;
    }
    .drawer-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        display: flex; align-items: center; gap: 8px;
    }
    .drawer-title i { color: var(--granate); font-size: .95rem; }

    .drawer-close {
        background: none; border: none;
        color: var(--tinta-s); font-size: 1.1rem;
        cursor: pointer; padding: 4px 8px;
        transition: color .15s;
    }
    .drawer-close:hover { color: var(--granate); }

    /* ── RESPONSIVE ── */
    @media (max-width: 780px) {
        .order-layout { grid-template-columns: 1fr; }
        .cart-panel { display: none; }   /* Ocultar panel lateral */
        .cart-fab { display: flex; }     /* Mostrar FAB */
        main { padding-bottom: 5rem; }
        .featured-grid { grid-template-columns: 1fr; }
        .menu-card { grid-template-columns: 44px 1fr auto; gap: .8rem; }
        .menu-icon { width: 44px; height: 44px; font-size: 1.1rem; border-radius: 10px; }
    }
</style>
@endsection

@section('content')

<a href="{{ url('/') }}" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i> Volver al inicio
</a>

<div class="order-layout">

    {{-- ═══ COLUMNA PRODUCTOS ═══ --}}
    <div class="products-col">

        @if($type === 'robot')
        {{-- ── PEDIDO RÁPIDO ── --}}
        <div class="section-head">
            <h2>Pedido rápido</h2>
            <p><i class="fa-solid fa-robot"></i> Listo en minutos · Recogida en ventanilla robot con tu ticket</p>
        </div>

        {{-- DESTACADOS --}}
        @if(isset($products['bocata_especial']) || isset($products['bocata_dia']))
        <div class="category-block">
            <div class="category-label">
                <h3><i class="fa-solid fa-star"></i> Destacados del día</h3>
            </div>
            <div class="featured-grid">
                @foreach($products->intersectByKeys(array_flip(['bocata_especial', 'bocata_dia']))->collapse() as $product)
                <div class="product-card featured"
                     onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                    <span class="featured-badge">
                        <i class="fa-solid fa-{{ $product->category === 'bocata_dia' ? 'calendar-day' : 'crown' }}"></i>
                        {{ $product->category === 'bocata_dia' ? 'Del día' : 'Especial' }}
                    </span>
                    <div class="p-name">{{ $product->name }}</div>
                    <div class="p-price">{{ number_format($product->price, 2) }} €</div>
                    <div class="p-counter">
                        <button class="counter-btn" onclick="event.stopPropagation(); changeQty({{ $product->id }}, -1)">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <span class="counter-val" id="qty-{{ $product->id }}">0</span>
                        <button class="counter-btn" onclick="event.stopPropagation(); changeQty({{ $product->id }}, 1)">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- RESTO CATEGORÍAS --}}
        @php
            $labels = [
                'bocata'   => ['icon' => 'fa-bread-slice',  'label' => 'Bocadillos'],
                'bolleria' => ['icon' => 'fa-cookie',       'label' => 'Bollería'],
                'cafe'     => ['icon' => 'fa-mug-hot',      'label' => 'Cafés'],
                'bebida'   => ['icon' => 'fa-glass-water',  'label' => 'Bebidas frías'],
            ];
        @endphp

        @foreach($labels as $cat => $meta)
            @if(isset($products[$cat]) && $products[$cat]->count())
            <div class="category-block">
                <div class="category-label">
                    <h3><i class="fa-solid {{ $meta['icon'] }}"></i> {{ $meta['label'] }}</h3>
                </div>
                <div class="products-grid">
                    @foreach($products[$cat] as $product)
                    <div class="product-card"
                         onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                        <div class="p-name">{{ $product->name }}</div>
                        <div class="p-price">{{ number_format($product->price, 2) }} €</div>
                        <div class="p-counter">
                            <button class="counter-btn" onclick="event.stopPropagation(); changeQty({{ $product->id }}, -1)">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <span class="counter-val" id="qty-{{ $product->id }}">0</span>
                            <button class="counter-btn" onclick="event.stopPropagation(); changeQty({{ $product->id }}, 1)">
                                <i class="fa-solid fa-plus"></i>
                            </button>
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
            <p><i class="fa-solid fa-truck-fast"></i> AGV lo lleva a ventanilla o a tu mesa si eres zona VIP</p>
        </div>

        @php
            $menuMeta = [
                'menu_completo'    => ['icon' => 'fa-utensils',    'desc' => 'Primero + segundo + postre + bebida'],
                'menu_medio'       => ['icon' => 'fa-plate-wheat', 'desc' => 'Segundo + bebida'],
                'menu_vegetariano' => ['icon' => 'fa-leaf',        'desc' => 'Primero vegetariano + segundo vegetal + postre'],
                'menu_saludable'   => ['icon' => 'fa-heart-pulse', 'desc' => 'Ensalada + proteína + fruta + agua'],
            ];
        @endphp
        {{-- VIP --}}
        <div class="vip-box" id="vip-box">
            <h4><i class="fa-solid fa-star"></i> Zona VIP — entrega en mesa</h4>
            <p>Si eres de zona VIP el AGV te lleva el menú directamente a tu mesa. Si no lo eres, déjalo vacío y recógelo en ventanilla.</p>
            <input type="number" id="table-number" class="vip-input"
                   placeholder="Número de mesa (opcional)" min="1" max="999">
        </div>
        <div class="menu-list">
            @foreach($products->flatten() as $product)
            @php $meta = $menuMeta[$product->category] ?? ['icon' => 'fa-utensils', 'desc' => '']; @endphp
            <div class="menu-card" id="menu-card-{{ $product->id }}"
                 onclick="selectMenu({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                <div class="menu-icon">
                    <i class="fa-solid {{ $meta['icon'] }}"></i>
                </div>
                <div class="menu-info">
                    <h4>{{ $product->name }}</h4>
                    <div class="menu-platos">{{ $meta['desc'] }}</div>
                </div>
                <div class="menu-right">
                    <span class="menu-price">{{ number_format($product->price, 2) }} €</span>
                    <button class="menu-select-btn" id="btn-{{ $product->id }}">
                        <i class="fa-regular fa-circle" id="icon-{{ $product->id }}"></i> Elegir
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        
        @endif

    </div>

    {{-- ═══ CARRITO DESKTOP ═══ --}}
    <aside class="cart-panel" id="cart-panel-desktop">
        <h3>
            <i class="fa-solid fa-bag-shopping"></i>
            Tu pedido
            <span class="cart-badge" id="cart-count-desktop">0</span>
        </h3>

        <div id="cart-empty-desktop" class="cart-empty">
            <i class="fa-solid fa-bag-shopping"></i>
            Añade algo para empezar
        </div>

        <ul class="cart-items" id="cart-list-desktop" style="display:none"></ul>

        <div id="cart-footer-desktop" style="display:none">
            <div class="cart-divider"></div>
            <div class="cart-total">
                <span>Total</span>
                <span class="cart-total-price" id="cart-total-desktop">0,00 €</span>
            </div>
            <form method="POST" action="{{ url('/checkout') }}" id="checkout-form-desktop">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="cart" id="cart-input-desktop">
                <input type="hidden" name="table_number" id="table-input-desktop">
                <button type="submit" class="btn-checkout">
                    <i class="fa-solid fa-check"></i> Confirmar pedido
                </button>
            </form>
        </div>
    </aside>

</div>

{{-- ═══ CARRITO MÓVIL — FAB + DRAWER ═══ --}}

<!-- Botón flotante -->
<button class="cart-fab" id="cart-fab" onclick="openDrawer()" aria-label="Ver carrito">
    <i class="fa-solid fa-bag-shopping"></i>
    <span class="cart-fab-badge" id="cart-fab-badge">0</span>
</button>

<!-- Overlay -->
<div class="cart-overlay" id="cart-overlay" onclick="closeDrawer()"></div>

<!-- Drawer -->
<div class="cart-drawer" id="cart-drawer">
    <div class="drawer-header">
        <div class="drawer-title">
            <i class="fa-solid fa-bag-shopping"></i> Tu pedido
            <span class="cart-badge" id="cart-count-drawer">0</span>
        </div>
        <button class="drawer-close" onclick="closeDrawer()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div id="cart-empty-drawer" class="cart-empty">
        <i class="fa-solid fa-bag-shopping"></i>
        Añade algo para empezar
    </div>

    <ul class="cart-items" id="cart-list-drawer" style="display:none"></ul>

    <div id="cart-footer-drawer" style="display:none">
        <div class="cart-divider"></div>
        <div class="cart-total">
            <span>Total</span>
            <span class="cart-total-price" id="cart-total-drawer">0,00 €</span>
        </div>
        <form method="POST" action="{{ url('/checkout') }}" id="checkout-form-drawer">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="cart" id="cart-input-drawer">
            <input type="hidden" name="table_number" id="table-input-drawer">
            <button type="submit" class="btn-checkout">
                <i class="fa-solid fa-check"></i> Confirmar pedido
            </button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
const TYPE = '{{ $type }}';
let cart = {};
let selectedMenu = null;

/* ── DRAWER ── */
function openDrawer() {
    document.getElementById('cart-drawer').classList.add('open');
    document.getElementById('cart-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeDrawer() {
    document.getElementById('cart-drawer').classList.remove('open');
    document.getElementById('cart-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ── ROBOT ── */
/* ── ROBOT: máximo 1 producto en total ── */
function addToCart(id, name, price) {
    // Si ya hay algo en el carrito, no añadir más
    if (Object.keys(cart).length > 0 && !cart[id]) {
        alert('Solo puedes pedir un producto a la vez.');
        return;
    }
    if (!cart[id]) cart[id] = { name, price, qty: 0 };
    // Máximo qty 1
    if (cart[id].qty >= 1) return;
    cart[id].qty = 1;
    updateQtyDisplay(id);
    renderCart();
}

function changeQty(id, delta) {
    if (!cart[id]) return;
    const newQty = cart[id].qty + delta;
    if (newQty > 1) return; // no dejar subir de 1
    cart[id].qty = Math.max(0, newQty);
    if (cart[id].qty === 0) delete cart[id];
    updateQtyDisplay(id);
    renderCart();
}

function updateQtyDisplay(id) {
    const el = document.getElementById('qty-' + id);
    if (el) el.textContent = cart[id] ? cart[id].qty : 0;
}

/* ── MENÚ ── */
function selectMenu(id, name, price) {
    if (selectedMenu !== null) {
        document.getElementById('menu-card-' + selectedMenu)?.classList.remove('selected');
        const oldBtn  = document.getElementById('btn-' + selectedMenu);
        const oldIcon = document.getElementById('icon-' + selectedMenu);
        if (oldBtn)  oldBtn.innerHTML  = '<i class="fa-regular fa-circle" id="icon-' + selectedMenu + '"></i> Elegir';
    }

    if (selectedMenu === id) {
        selectedMenu = null;
        cart = {};
    } else {
        selectedMenu = id;
        cart = { [id]: { name, price, qty: 1 } };
        document.getElementById('menu-card-' + id).classList.add('selected');
        document.getElementById('btn-' + id).innerHTML =
            '<i class="fa-solid fa-circle-check" id="icon-' + id + '"></i> Seleccionado';
        document.getElementById('vip-box')?.classList.add('show');
    }
    renderCart();
}

/* ── RENDER ── */
function cartItemHTML(id, item) {
    return `
        <li class="cart-item">
            <span class="cart-item-name">${item.name}</span>
            <span class="cart-item-qty">×${item.qty}</span>
            <span class="cart-item-price">${(item.price * item.qty).toFixed(2).replace('.', ',')} €</span>
            <button class="cart-item-remove" onclick="removeItem(${id})" title="Quitar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </li>`;
}

function renderCart() {
    const items = Object.entries(cart).filter(([, v]) => v.qty > 0);
    const count = items.reduce((s, [, v]) => s + v.qty, 0);
    const total = items.reduce((s, [, v]) => s + v.price * v.qty, 0);
    const totalStr = total.toFixed(2).replace('.', ',') + ' €';
    const cartJSON = JSON.stringify(items.map(([id, item]) => ({ id: parseInt(id), qty: item.qty, price: item.price })));
    const hasItems = items.length > 0;
    const html = items.map(([id, item]) => cartItemHTML(id, item)).join('');

    // FAB badge
    const fab = document.getElementById('cart-fab-badge');
    fab.textContent = count;
    fab.classList.toggle('visible', count > 0);

    // Actualiza DESKTOP y DRAWER con los mismos datos
    ['desktop', 'drawer'].forEach(zone => {
        document.getElementById('cart-count-' + zone).textContent = count;
        document.getElementById('cart-empty-' + zone).style.display  = hasItems ? 'none'  : 'block';
        document.getElementById('cart-list-' + zone).style.display   = hasItems ? 'flex'  : 'none';
        document.getElementById('cart-footer-' + zone).style.display = hasItems ? 'block' : 'none';

        if (hasItems) {
            document.getElementById('cart-list-' + zone).innerHTML = html;
            document.getElementById('cart-total-' + zone).textContent = totalStr;
            document.getElementById('cart-input-' + zone).value = cartJSON;
        }
    });

    // Bloquear botones + si ya hay un producto
document.querySelectorAll('.counter-btn').forEach(btn => {
    if (btn.querySelector('.fa-plus')) {
        const hasItem = Object.keys(cart).length > 0;
        btn.style.opacity = hasItem ? '0.3' : '1';
        btn.style.pointerEvents = hasItem ? 'none' : 'auto';
    }
});
// Desbloquear el + del producto que ya está en el carrito
Object.keys(cart).forEach(id => {
    const card = document.getElementById('qty-' + id)?.closest('.product-card');
    if (card) {
        const plusBtn = card.querySelector('.fa-plus')?.parentElement;
        if (plusBtn) { plusBtn.style.opacity = '0.3'; plusBtn.style.pointerEvents = 'none'; }
    }
});
}

function removeItem(id) {
    if (TYPE === 'menu') {
        if (selectedMenu !== null) {
            document.getElementById('menu-card-' + selectedMenu)?.classList.remove('selected');
            document.getElementById('btn-' + selectedMenu).innerHTML =
                '<i class="fa-regular fa-circle" id="icon-' + selectedMenu + '"></i> Elegir';
            selectedMenu = null;
        }
        document.getElementById('vip-box')?.classList.remove('show');
    }
    delete cart[id];
    const el = document.getElementById('qty-' + id);
    if (el) el.textContent = 0;
    renderCart();
}

/* ── SUBMIT ── */
['desktop', 'drawer'].forEach(zone => {
    document.getElementById('checkout-form-' + zone)?.addEventListener('submit', function() {
        const mesa = document.getElementById('table-number')?.value || '';
        document.getElementById('table-input-' + zone).value = mesa;
    });
});
</script>
@endsection