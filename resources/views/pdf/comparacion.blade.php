@extends('pdf.layouts.base')

@section('title', 'Comparativa de Tarifas - EasyMove')
@section('subtitle', 'Comparativo de Servicios')

@section('styles')
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0 20px 0;
        font-size: 11px;
    }
    table th {
        background-color: #f0f0f0;
        color: #9333ea;
        padding: 8px;
        text-align: left;
        border-bottom: 2px solid #9333ea;
    }
    table td {
        padding: 7px 8px;
        border-bottom: 1px solid #e5e5e5;
    }
    table tr { page-break-inside: avoid; }

    .summary {
        background-color: #f9f9f9;
        padding: 14px 16px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    .summary h2 {
        color: #9333ea;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .summary-row {
        padding: 5px 0;
        border-bottom: 1px solid #e5e5e5;
        font-size: 11px;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-row .label { font-weight: bold; }
    .summary-row .value { float: right; color: #333; }
    .summary-row::after { content: ""; display: block; clear: both; }

    .tariff-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 14px 16px;
        margin-bottom: 12px;
        page-break-inside: avoid;
    }
    .tariff-card .provider-name {
        color: #666;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tariff-card h3 {
        color: #9333ea;
        font-size: 14px;
        margin: 4px 0 8px 0;
    }
    .tariff-card .price {
        font-size: 20px;
        color: #9333ea;
        font-weight: bold;
        margin: 6px 0 8px 0;
    }
    .tariff-card .price-unit {
        font-size: 11px;
        color: #999;
        margin-left: 4px;
        font-weight: normal;
    }
    .tariff-card .details {
        font-size: 11px;
        color: #555;
        margin: 4px 0;
    }
    .tariff-card .details strong { color: #333; }
@endsection

@section('location')
    <strong>Ubicación:</strong> {{ $comparacion->ubicacion->ciudad }}, {{ $comparacion->ubicacion->provincia }} ({{ $comparacion->ubicacion->codigo_postal }})<br>
    <strong>Tipo de Servicio:</strong> {{ $comparacion->tipoServicio->nombre }}<br>
    <strong>Fecha de Búsqueda:</strong> {{ $comparacion->fecha->format('d/m/Y H:i') }}
@endsection

@section('content')
    <div class="summary">
        <h2>Resumen de Resultados</h2>
        <div class="summary-row">
            <span class="label">Total de ofertas encontradas:</span>
            <span class="value">{{ $tarifas->count() }}</span>
        </div>
        @if($cheapest)
            <div class="summary-row">
                <span class="label">Tarifa más económica:</span>
                <span class="value">{{ number_format($cheapest->precio, 2, ',', '.') }}€ — {{ $cheapest->servicio->proveedor->nombre }}</span>
            </div>
        @endif
        @if($expensive && $expensive->id_tarifa !== ($cheapest->id_tarifa ?? null))
            <div class="summary-row">
                <span class="label">Tarifa más cara:</span>
                <span class="value">{{ number_format($expensive->precio, 2, ',', '.') }}€ — {{ $expensive->servicio->proveedor->nombre }}</span>
            </div>
        @endif
    </div>

    <h2 class="section-title">Listado de Tarifas</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Proveedor</th>
                <th>Tarifa</th>
                <th style="width: 90px;">Precio</th>
                <th style="width: 90px;">Permanencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tarifas as $tarifa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $tarifa->servicio->proveedor->nombre }}</strong></td>
                    <td>{{ $tarifa->nombre_tarifa }}</td>
                    <td>
                        <strong style="color: #9333ea;">{{ number_format($tarifa->precio, 2, ',', '.') }}€</strong>
                        @if($tarifa->unidad_precio)
                            <span style="font-size: 10px; color: #999;">/ {{ $tarifa->unidad_precio }}</span>
                        @endif
                    </td>
                    <td>{{ $tarifa->permanencia ?? 'Sin permanencia' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="section-title">Detalle de Ofertas</h2>
    @foreach($tarifas as $tarifa)
        <div class="tariff-card">
            <div class="provider-name">{{ $tarifa->servicio->proveedor->nombre }}</div>
            <h3>{{ $tarifa->nombre_tarifa }}</h3>
            <div class="price">
                {{ number_format($tarifa->precio, 2, ',', '.') }}€
                @if($tarifa->unidad_precio)
                    <span class="price-unit">/ {{ $tarifa->unidad_precio }}</span>
                @endif
            </div>

            @if($tarifa->permanencia)
                <div class="details"><strong>Permanencia:</strong> {{ $tarifa->permanencia }}</div>
            @else
                <div class="details"><strong>Permanencia:</strong> Sin compromiso</div>
            @endif

            @if($tarifa->condiciones)
                <div class="details">
                    <strong>Condiciones:</strong> {{ \Illuminate\Support\Str::limit($tarifa->condiciones, 220) }}
                </div>
            @endif

            @if($tarifa->url_oferta_externa)
                <div class="details">
                    <strong>Enlace:</strong> {{ \Illuminate\Support\Str::limit($tarifa->url_oferta_externa, 90) }}
                </div>
            @endif
        </div>
    @endforeach
@endsection
