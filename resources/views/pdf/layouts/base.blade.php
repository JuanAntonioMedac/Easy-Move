<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EasyMove')</title>
    <style>
        @page { margin: 25mm 15mm 25mm 15mm; }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 12px;
        }

        .container { width: 100%; }

        header.pdf-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #9333ea;
            padding-bottom: 15px;
        }

        header.pdf-header h1 {
            color: #9333ea;
            font-size: 26px;
            margin-bottom: 4px;
        }

        header.pdf-header .subtitle {
            color: #9333ea;
            font-size: 12px;
        }

        .info-box {
            background-color: #f4f4f4;
            padding: 12px 14px;
            border-radius: 4px;
            margin-bottom: 14px;
            border-left: 4px solid #9333ea;
            font-size: 11px;
        }

        .info-box.green {
            background-color: #e8f5e9;
            border-left-color: #4caf50;
        }

        h2.section-title {
            color: #9333ea;
            font-size: 16px;
            margin: 20px 0 12px 0;
        }

        footer.pdf-footer {
            position: fixed;
            bottom: -15mm;
            left: 0;
            right: 0;
            text-align: center;
            color: #999;
            font-size: 10px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
        }

        .page-number:before {
            content: counter(page) " / " counter(pages);
        }

        @yield('styles')
    </style>
</head>
<body>
    <footer class="pdf-footer">
        <div>Documento generado automáticamente por EasyMove · {{ now()->format('d/m/Y H:i') }} · Página <span class="page-number"></span></div>
    </footer>

    <div class="container">
        <header class="pdf-header">
            <h1>EasyMove</h1>
            <div class="subtitle">@yield('subtitle', 'Comparativo de Servicios')</div>
        </header>

        @if(!empty($usuario))
            <div class="info-box">
                <strong>Usuario:</strong> {{ $usuario->nombre }} ({{ $usuario->email }})<br>
                <strong>Fecha de descarga:</strong> {{ now()->format('d/m/Y H:i') }}
            </div>
        @endif

        @hasSection('location')
            <div class="info-box green">
                @yield('location')
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
