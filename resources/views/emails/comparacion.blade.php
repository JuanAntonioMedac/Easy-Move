<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .content {
            padding: 30px;
        }

        .content h2 {
            color: #9333ea;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .info-box {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #9333ea;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #9333ea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
        }

        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            color: #999;
            font-size: 12px;
        }

        .tariff-summary {
            background-color: #f0f9f7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .tariff-summary strong {
            color: #9333ea;
        }

        a {
            color: #9333ea;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎯 EasyMove</h1>
            <p>Tu Comparativa de Tarifas</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>¡Hola {{ $usuario->nombre }}!</h2>

            <p>
                Te enviamos tu comparativa de tarifas para <strong>{{ $comparacion->tipoServicio->nombre }}</strong> en
                <strong>{{ $comparacion->ubicacion->ciudad }}, {{ $comparacion->ubicacion->provincia }}</strong>.
            </p>

            <!-- Información de la búsqueda -->
            <div class="info-box">
                <strong>📍 Ubicación:</strong> {{ $comparacion->ubicacion->ciudad }}, {{ $comparacion->ubicacion->provincia }} ({{ $comparacion->ubicacion->codigo_postal }})<br>
                <strong>🔍 Servicio:</strong> {{ $comparacion->tipoServicio->nombre }}<br>
                <strong>📅 Fecha:</strong> {{ $comparacion->fecha->format('d/m/Y H:i') }}
            </div>

            <!-- Resumen de Tarifas -->
            <h2>Resumen de Ofertas</h2>
            <p>Encontramos <strong>{{ $comparacion->tarifas->count() }} ofertas</strong> disponibles para ti:</p>

            <div class="tariff-summary">
                <strong>Tarifa más económica:</strong>
                @php
                    $cheapest = $comparacion->tarifas->minBy('precio');
                @endphp
                {{ $cheapest->precio }}€ - {{ $cheapest->nombre_tarifa }} ({{ $cheapest->servicio->proveedor->nombre }})
            </div>

            <div class="tariff-summary">
                <strong>Ahorro potencial:</strong>
                @php
                    $min = $comparacion->tarifas->min('precio');
                    $max = $comparacion->tarifas->max('precio');
                    $savings = $max - $min;
                @endphp
                Hasta {{ $savings }}€ respecto a la oferta más cara
            </div>

            <!-- Call to Action -->
            <p>
                <strong>📎 Adjunto encontrarás el PDF completo</strong> con todas las tarifas, detalles de permanencia y condiciones.
            </p>

            <p>
                <a href="{{ config('app.url') }}" class="button">Ver en EasyMove</a>
            </p>

            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">

            <h3 style="color: #333; margin-top: 20px;">¿Necesitas ayuda?</h3>
            <p>
                Si tienes preguntas sobre estas tarifas o necesitas más información, puedes:
            </p>
            <ul>
                <li>Acceder a tu cuenta en EasyMove</li>
                <li>Contactarnos en <a href="mailto:soporte@easymove.net">soporte@easymove.net</a></li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ now()->year }} EasyMove - Tu Comparador de Servicios</p>
            <p>
                <a href="{{ config('app.url') }}/politica-privacidad">Privacidad</a> |
                <a href="{{ config('app.url') }}/terminos">Términos</a> |
                <a href="{{ config('app.url') }}/contacto">Contacto</a>
            </p>
            <p>
                Este email contiene información sobre tu comparativa de tarifas. Si no lo solicitaste,
                <a href="mailto:no-reply@easymove.net">contacta este correo</a>.
            </p>
        </div>
    </div>
</body>
</html>
