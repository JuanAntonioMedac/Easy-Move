<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Tarifa - EasyMove</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        header { text-align: center; margin-bottom: 40px; border-bottom: 3px solid #9333ea; padding-bottom: 20px; }
        h1 { color: #9333ea; font-size: 32px; margin-bottom: 10px; }
        .info-box { background-color: #f0f0f0; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #9333ea; }
        .location-box { background-color: #e8f5e9; padding: 15px; border-radius: 5px; margin-bottom: 30px; border-left: 4px solid #4caf50; }
        .tariff-detail { background-color: white; border: 2px solid #9333ea; border-radius: 8px; padding: 30px; }
        .provider-section { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0; }
        .provider-logo { max-width: 80px; max-height: 80px; object-fit: contain; }
        .price-section { background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%); color: white; padding: 30px; border-radius: 8px; text-align: center; margin: 30px 0; }
        .price-value { font-size: 48px; font-weight: bold; margin: 10px 0; }
        .detail-item { margin-bottom: 15px; padding: 10px; background-color: #f9f9f9; border-radius: 5px; }
        .badge { display: inline-block; background-color: #9333ea; color: white; padding: 8px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge.green { background-color: #4caf50; }
        footer { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>EasyMove</h1>
            <p style="color: #9333ea; font-size: 14px;">Detalle de Tarifa</p>
        </header>

        @if($usuario)
            <div class="info-box">
                <strong>Usuario:</strong> {{ $usuario->nombre }} ({{ $usuario->email }})<br>
                <strong>Fecha de descarga:</strong> {{ now()->format('d/m/Y H:i') }}
            </div>
        @endif

        <div class="location-box">
            <strong>📍 Ubicación:</strong> {{ $comparacion->ubicacion->ciudad }}, {{ $comparacion->ubicacion->provincia }} ({{ $comparacion->ubicacion->codigo_postal }})<br>
            <strong>🔍 Tipo de Servicio:</strong> {{ $comparacion->tipoServicio->nombre }}<br>
            <strong>📅 Fecha de Búsqueda:</strong> {{ \Carbon\Carbon::parse($comparacion->fecha)->format('d/m/Y H:i') }}
        </div>

        @foreach($tarifas as $tarifa)
            <div class="tariff-detail">
                <div class="provider-section">
                    @if($tarifa->servicio->proveedor->logo)
                        <img src="{{ storage_path('app/public/' . $tarifa->servicio->proveedor->logo) }}" alt="{{ $tarifa->servicio->proveedor->nombre }}" class="provider-logo">
                    @else
                        <div style="width: 80px; height: 80px; background: #9333ea; color: white; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size: 36px;">🏢</div>
                    @endif
                    <div>
                        <h2 style="color: #9333ea; margin: 0;">{{ $tarifa->servicio->proveedor->nombre }}</h2>
                        <p style="margin: 5px 0; color: #666;"><strong>Servicio:</strong> {{ $tarifa->servicio->nombre_servicio }}</p>
                    </div>
                </div>

                <div style="text-align: center; margin-bottom: 20px;">
                    <h3 style="color: #9333ea; font-size: 20px; margin: 0;">{{ $tarifa->nombre_tarifa }}</h3>
                </div>

                <div class="price-section">
                    <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9;">Precio {{ $tarifa->unidad_precio ? '(' . $tarifa->unidad_precio . ')' : '' }}</div>
                    <div class="price-value">{{ number_format($tarifa->precio, 2, ',', '.') }}€</div>
                    @if($tarifa->unidad_precio)
                        <div style="font-size: 16px;">por {{ $tarifa->unidad_precio }}</div>
                    @endif
                </div>

                @if($tarifa->permanencia)
                    <div class="detail-item">
                        <strong>⏱️ Permanencia</strong>
                        <div class="badge">{{ $tarifa->permanencia }}</div>
                    </div>
                @else
                    <div class="detail-item">
                        <strong>✅ Sin Permanencia</strong>
                        <div class="badge green">SIN COMPROMISO</div>
                    </div>
                @endif

                @if($tarifa->condiciones)
                    <div class="detail-item">
                        <strong>📋 Condiciones</strong>
                        <p style="margin: 5px 0;">{{ $tarifa->condiciones }}</p>
                    </div>
                @endif

                @if($tarifa->url_oferta_externa)
                    <div style="background-color: #e8f5e9; border: 1px solid #4caf50; padding: 15px; border-radius: 5px; margin-top: 20px;">
                        <strong style="color: #4caf50;">🔗 Enlace de la oferta:</strong><br>
                        <a href="{{ $tarifa->url_oferta_externa }}" style="color: #4caf50; word-break: break-all;">{{ $tarifa->url_oferta_externa }}</a>
                    </div>
                @endif

                <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                    <div class="detail-item">
                        <strong>Proveedor:</strong>
                        <p style="margin: 5px 0;">{{ $tarifa->servicio->proveedor->nombre }}</p>
                    </div>
                    <div class="detail-item">
                        <strong>Tipo de Servicio:</strong>
                        <p style="margin: 5px 0;">{{ $tarifa->servicio->nombre_servicio }}</p>
                    </div>
                    @if($tarifa->fecha_actualizacion)
                        <div class="detail-item">
                            <strong>Última Actualización:</strong>
                            <p style="margin: 5px 0;">{{ \Carbon\Carbon::parse($tarifa->fecha_actualizacion)->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <footer>
            <p>Este documento fue generado automáticamente por EasyMove</p>
            <p>Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i:s') }}</p>
        </footer>
    </div>
</body>
</html>
