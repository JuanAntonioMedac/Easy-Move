<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparativa de Tarifas - EasyMove</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #9333ea;
            padding-bottom: 20px;
        }

        h1 {
            color: #9333ea;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .meta-info {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .user-info {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            border-left: 4px solid #9333ea;
        }

        .location-info {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            border-left: 4px solid #4caf50;
        }

        .tariff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .tariff-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            page-break-inside: avoid;
        }

        .tariff-card h3 {
            color: #9333ea;
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .provider-name {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .price {
            font-size: 28px;
            color: #9333ea;
            font-weight: bold;
            margin: 15px 0;
        }

        .price-unit {
            font-size: 14px;
            color: #999;
            margin-left: 5px;
        }

        .details {
            font-size: 13px;
            color: #666;
            margin: 10px 0;
        }

        .details strong {
            color: #333;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #999;
            font-size: 12px;
        }

        .report-date {
            color: #999;
            font-size: 12px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th {
            background-color: #f0f0f0;
            color: #9333ea;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #9333ea;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .summary {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .summary h2 {
            color: #9333ea;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-row:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>EasyMove</h1>
            <p style="color: #9333ea; font-size: 14px; margin-top: 5px;">Comparativo de Servicios</p>
        </header>

        <!-- Informacion de Usuario -->
        @if($usuario)
            <div class="user-info">
                <strong>Usuario:</strong> {{ $usuario->nombre }} ({{ $usuario->email }})<br>
                <strong>Fecha de descarga:</strong> {{ now()->format('d/m/Y H:i') }}
            </div>
        @endif

        <!-- Información de Ubicación -->
        <div class="location-info">
            <strong>📍 Ubicación:</strong> {{ $comparacion->ubicacion->ciudad }}, {{ $comparacion->ubicacion->provincia }} ({{ $comparacion->ubicacion->codigo_postal }})<br>
            <strong>🔍 Tipo de Servicio:</strong> {{ $comparacion->tipoServicio->nombre }}<br>
            <strong>📅 Fecha de Búsqueda:</strong> {{ $comparacion->fecha->format('d/m/Y H:i') }}
        </div>

        <!-- Resumen -->
        <div class="summary">
            <h2>Resumen de Resultados</h2>
            <div class="summary-row">
                <span><strong>Total de ofertas encontradas:</strong></span>
                <span>{{ $comparacion->tarifas->count() }}</span>
            </div>
            <div class="summary-row">
                <span><strong>Tarifa más económica:</strong></span>
                <span>
                    @php
                        $cheapest = $comparacion->tarifas->min(fn ($t) => $t->precio);
                    @endphp
                    {{ $cheapest }}€
                </span>
            </div>
            <div class="summary-row">
                <span><strong>Tarifa más cara:</strong></span>
                <span>
                    @php
                        $expensive = $comparacion->tarifas->max(fn ($t) => $t->precio);
                    @endphp
                    {{ $expensive }}€
                </span>
            </div>
        </div>

        <!-- Tabla de Tarifas -->
        <h2 style="color: #9333ea; margin: 30px 0 20px 0; font-size: 22px;">Listado de Tarifas</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Tarifa</th>
                    <th>Precio</th>
                    <th>Permanencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comparacion->tarifas as $tarifa)
                    <tr>
                        <td>{{ loop.index }}</td>
                        <td><strong>{{ $tarifa->servicio->proveedor->nombre }}</strong></td>
                        <td>{{ $tarifa->nombre_tarifa }}</td>
                        <td><strong style="color: #9333ea;">{{ $tarifa->precio }}€</strong>
                            @if($tarifa->unidad_precio)
                                <span style="font-size: 12px; color: #999;">/ {{ $tarifa->unidad_precio }}</span>
                            @endif
                        </td>
                        <td>{{ $tarifa->permanencia ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Cards de Tarifas (Alternativa visual) -->
        <h2 style="color: #9333ea; margin: 40px 0 20px 0; font-size: 22px;">Detalle de Ofertas</h2>
        <div class="tariff-grid">
            @foreach($comparacion->tarifas as $tarifa)
                <div class="tariff-card">
                    <div class="provider-name">{{ $tarifa->servicio->proveedor->nombre }}</div>
                    <h3>{{ $tarifa->nombre_tarifa }}</h3>
                    <div class="price">
                        {{ $tarifa->precio }}€
                        @if($tarifa->unidad_precio)
                            <span class="price-unit">/ {{ $tarifa->unidad_precio }}</span>
                        @endif
                    </div>

                    @if($tarifa->permanencia)
                        <div class="details">
                            <strong>Permanencia:</strong> {{ $tarifa->permanencia }}
                        </div>
                    @endif

                    @if($tarifa->condiciones)
                        <div class="details">
                            <strong>Condiciones:</strong><br>
                            {{ Str::limit($tarifa->condiciones, 100) }}
                        </div>
                    @endif

                    @if($tarifa->url_oferta_externa)
                        <div class="details">
                            <strong>Enlace:</strong> {{ Str::limit($tarifa->url_oferta_externa, 50) }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Footer -->
        <footer>
            <p>Este documento fue generado automáticamente por EasyMove</p>
            <p class="report-date">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i:s') }}</p>
        </footer>
    </div>
</body>
</html>
