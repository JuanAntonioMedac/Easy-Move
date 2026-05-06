@extends('pdf.layouts.base')

@section('title', 'Detalle de Tarifa - EasyMove')
@section('subtitle', 'Detalle de Tarifa')

@section('styles')
    .tariff-detail {
        background-color: #fff;
        border: 2px solid #9333ea;
        border-radius: 6px;
        padding: 18px;
        margin-bottom: 20px;
        page-break-inside: avoid;
    }

    .provider-section {
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 2px solid #f0f0f0;
    }
    .provider-section .provider-logo {
        max-width: 70px;
        max-height: 70px;
        vertical-align: middle;
        margin-right: 14px;
    }
    .provider-section .provider-fallback {
        display: inline-block;
        width: 70px;
        height: 70px;
        background: #9333ea;
        color: #fff;
        text-align: center;
        line-height: 70px;
        border-radius: 4px;
        font-size: 28px;
        font-weight: bold;
        margin-right: 14px;
        vertical-align: middle;
    }
    .provider-section .provider-info {
        display: inline-block;
        vertical-align: middle;
    }
    .provider-section h2 {
        color: #9333ea;
        font-size: 18px;
        margin: 0 0 4px 0;
    }
    .provider-section .service {
        color: #666;
        font-size: 11px;
    }

    .tariff-name {
        text-align: center;
        color: #9333ea;
        font-size: 16px;
        margin: 8px 0 14px 0;
    }

    .price-section {
        background-color: #9333ea;
        color: #fff;
        padding: 18px;
        border-radius: 6px;
        text-align: center;
        margin: 0 0 18px 0;
    }
    .price-section .price-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
    }
    .price-section .price-value {
        font-size: 32px;
        font-weight: bold;
        margin: 6px 0 4px 0;
    }
    .price-section .price-unit {
        font-size: 12px;
        opacity: 0.9;
    }

    .detail-item {
        margin-bottom: 10px;
        padding: 10px 12px;
        background-color: #f9f9f9;
        border-radius: 4px;
        font-size: 11px;
    }
    .detail-item strong { color: #333; }
    .detail-item p { margin: 3px 0 0 0; color: #555; }

    .badge {
        display: inline-block;
        background-color: #9333ea;
        color: #fff;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: bold;
        margin-left: 6px;
    }
    .badge.green { background-color: #4caf50; }

    .external-link {
        background-color: #e8f5e9;
        border: 1px solid #4caf50;
        padding: 10px 12px;
        border-radius: 4px;
        margin-top: 12px;
        font-size: 11px;
        word-break: break-all;
    }
    .external-link strong { color: #2e7d32; }
    .external-link a { color: #2e7d32; }
@endsection

@section('location')
    <strong>Ubicación:</strong> {{ $comparacion->ubicacion->ciudad }}, {{ $comparacion->ubicacion->provincia }} ({{ $comparacion->ubicacion->codigo_postal }})<br>
    <strong>Tipo de Servicio:</strong> {{ $comparacion->tipoServicio->nombre }}<br>
    <strong>Fecha de Búsqueda:</strong> {{ $comparacion->fecha->format('d/m/Y H:i') }}
@endsection

@section('content')
    @foreach($tarifas as $tarifa)
        @php
            $logoSrc = \App\Services\PdfService::embedImage($tarifa->servicio->proveedor->logo ?? null);
            $providerInitial = strtoupper(mb_substr($tarifa->servicio->proveedor->nombre ?? '?', 0, 1));
        @endphp
        <div class="tariff-detail">
            <div class="provider-section">
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" alt="{{ $tarifa->servicio->proveedor->nombre }}" class="provider-logo">
                @else
                    <span class="provider-fallback">{{ $providerInitial }}</span>
                @endif
                <div class="provider-info">
                    <h2>{{ $tarifa->servicio->proveedor->nombre }}</h2>
                    <div class="service"><strong>Servicio:</strong> {{ $tarifa->servicio->nombre_servicio }}</div>
                </div>
            </div>

            <h3 class="tariff-name">{{ $tarifa->nombre_tarifa }}</h3>

            <div class="price-section">
                <div class="price-label">Precio</div>
                <div class="price-value">{{ number_format($tarifa->precio, 2, ',', '.') }}€</div>
                @if($tarifa->unidad_precio)
                    <div class="price-unit">por {{ $tarifa->unidad_precio }}</div>
                @endif
            </div>

            @if($tarifa->permanencia)
                <div class="detail-item">
                    <strong>Permanencia</strong>
                    <span class="badge">{{ $tarifa->permanencia }}</span>
                </div>
            @else
                <div class="detail-item">
                    <strong>Permanencia</strong>
                    <span class="badge green">SIN COMPROMISO</span>
                </div>
            @endif

            @if($tarifa->condiciones)
                <div class="detail-item">
                    <strong>Condiciones</strong>
                    <p>{{ $tarifa->condiciones }}</p>
                </div>
            @endif

            <div class="detail-item">
                <strong>Proveedor:</strong>
                <p>{{ $tarifa->servicio->proveedor->nombre }}</p>
            </div>
            <div class="detail-item">
                <strong>Tipo de Servicio:</strong>
                <p>{{ $tarifa->servicio->nombre_servicio }}</p>
            </div>
            @if($tarifa->fecha_actualizacion)
                <div class="detail-item">
                    <strong>Última Actualización:</strong>
                    <p>{{ \Carbon\Carbon::parse($tarifa->fecha_actualizacion)->format('d/m/Y H:i') }}</p>
                </div>
            @endif

            @if($tarifa->url_oferta_externa)
                <div class="external-link">
                    <strong>Enlace de la oferta:</strong><br>
                    <a href="{{ $tarifa->url_oferta_externa }}">{{ $tarifa->url_oferta_externa }}</a>
                </div>
            @endif
        </div>
    @endforeach
@endsection
