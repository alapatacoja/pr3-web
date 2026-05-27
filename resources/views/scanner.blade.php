@extends('layouts.app')

@section('title', 'Scanner')

@section('styles')
<style>
    .scanner-wrap {
        max-width: 500px;
        margin: auto;
        padding: 1.5rem;
        text-align: center;
    }

    .scanner-wrap h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        margin-bottom: 1.2rem;
        color: var(--tinta);
    }

    #reader {
        width: 100%;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 2px solid var(--borde);
        box-shadow: var(--sombra);
        background: #000;
        /* altura fija para que el div exista antes de que arranque la cámara */
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .camera-placeholder {
        color: #555;
        font-size: .9rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .5rem;
    }
    .camera-placeholder i { font-size: 2rem; color: #777; }

    .status-box {
        margin-top: 1.2rem;
        padding: 1rem 1.2rem;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: .95rem;
        transition: all .3s ease;
        min-height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .status-idle    { background: var(--fondo-t);  color: var(--tinta-s); }
    .status-loading { background: #fff3cd; color: #856404; }
    .status-success { background: #d4edda; color: #155724; }
    .status-error   { background: #f8d7da; color: #721c24; }

    .last-code {
        margin-top: .8rem;
        font-size: .75rem;
        color: #aaa;
        word-break: break-all;
    }

    /* Botón de arranque — solo se muestra si la cámara no arranca sola */
    .btn-start {
        margin-top: 1rem;
        width: 100%;
        padding: 13px;
        background: var(--granate);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-family: 'DM Sans', sans-serif;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background .2s;
    }
    .btn-start:hover { background: var(--granate-d); }
    .btn-start.hidden { display: none; }
</style>
@endsection

@section('content')

<div class="scanner-wrap">

    <h1><i class="fa-solid fa-qrcode" style="color:var(--granate)"></i> Lector de pedidos</h1>

    <div id="reader">
        <div class="camera-placeholder" id="placeholder">
            <i class="fa-solid fa-camera"></i>
            <span>Iniciando cámara...</span>
        </div>
    </div>

    <button class="btn-start hidden" id="btn-start" onclick="startScanner()">
        <i class="fa-solid fa-camera"></i> Activar cámara
    </button>

    <div id="status" class="status-box status-idle">
        <i class="fa-solid fa-camera"></i> Apunta al código QR del ticket
    </div>

    <div id="last" class="last-code"></div>

</div>

<!-- Versión fijada de html5-qrcode para evitar cambios de API -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

<script>
let html5QrCode = null;
let processing  = false;

function setStatus(type, message, icon = 'fa-circle-info') {
    const box = document.getElementById('status');
    box.className = 'status-box status-' + type;
    box.innerHTML = `<i class="fa-solid ${icon}"></i> ${message}`;
}

function onScanSuccess(decodedText) {
    if (processing) return;
    processing = true;

    document.getElementById('last').innerText = 'Último QR: ' + decodedText;
    setStatus('loading', 'Procesando pedido...', 'fa-spinner fa-spin');
    navigator.vibrate?.(150);

    fetch('/api/scan-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ token: decodedText })
    })
    .then(res => res.json())
    .then(data => {
        const ok = data.message?.toLowerCase().includes('enviado');
        if (ok) {
            setStatus('success', 'Pedido enviado al robot', 'fa-circle-check');
            navigator.vibrate?.([100, 50, 100]);
            new Audio('/sounds/success.mp3').play().catch(() => {});
        } else {
            setStatus('error', data.message || 'Error desconocido', 'fa-triangle-exclamation');
        }
    })
    .catch(() => {
        setStatus('error', 'Error de conexión', 'fa-wifi');
    })
    .finally(() => {
        setTimeout(() => {
            processing = false;
            setStatus('idle', 'Apunta al código QR del ticket', 'fa-camera');
        }, 2500);
    });
}

function startScanner() {
    document.getElementById('btn-start').classList.add('hidden');
    document.getElementById('placeholder').style.display = 'none';

    html5QrCode = new Html5Qrcode('reader');

    // Pide cámara trasera directamente
    html5QrCode.start(
        { facingMode: 'environment' },   // cámara trasera del móvil
        { fps: 10, qrbox: { width: 240, height: 240 } },
        onScanSuccess,
        () => {}   // errores de frame los ignoramos (son normales)
    ).catch(err => {
        // Si falla (permiso denegado, etc), mostrar error claro
        setStatus('error', 'No se pudo acceder a la cámara. Comprueba los permisos.', 'fa-ban');
        document.getElementById('placeholder').innerHTML =
            '<i class="fa-solid fa-ban" style="color:#c00;font-size:2rem"></i>';
        console.error('Camera error:', err);
    });
}

// Intentar arrancar automáticamente al cargar
window.addEventListener('load', () => {
    // Pequeño delay para asegurarse de que el DOM y ngrok han terminado de cargar
    setTimeout(() => {
        // Comprobamos si el navegador soporta getUserMedia
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            startScanner();
        } else {
            // Si no, mostrar botón manual
            setStatus('error', 'Tu navegador no soporta la cámara por HTTP. Usa el enlace HTTPS de ngrok.', 'fa-triangle-exclamation');
            document.getElementById('btn-start').classList.remove('hidden');
        }
    }, 600);
});
</script>

@endsection