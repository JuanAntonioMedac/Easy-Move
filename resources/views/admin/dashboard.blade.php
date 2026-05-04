@extends('layouts.app')

@section('title', 'Panel Administrador - EasyMove')

@section('content')
<!-- Header -->
<div class="mb-10">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
        <div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                🎛️ Panel de Control
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Bienvenido, <span class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->nombre }}</span>
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                {{ now()->locale('es')->translatedFormat('l, j \d\e F \d\e Y') }}
            </p>
        </div>
        <a href="{{ route('home') }}" class="px-6 py-3 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded-lg transition border border-gray-200 dark:border-gray-700 font-medium flex items-center gap-2 w-fit">
            <i class="bi bi-house"></i>
            Volver al sitio
        </a>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Usuarios Totales -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition group">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Usuarios</p>
                <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $totalUsuarios }}</p>
            </div>
            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg group-hover:scale-110 transition">
                <i class="bi bi-people text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
            <span class="text-green-600 dark:text-green-400 font-semibold text-sm">{{ $usuariosNuevos }} nuevo{{ $usuariosNuevos !== 1 ? 's' : '' }}</span>
            <span class="text-gray-500 dark:text-gray-400 text-xs">en los últimos 7 días</span>
        </div>
    </div>

    <!-- Proveedores -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition group">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Proveedores</p>
                <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $totalProveedores }}</p>
            </div>
            <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg group-hover:scale-110 transition">
                <i class="bi bi-building text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
            <span class="text-green-600 dark:text-green-400 font-semibold text-sm">✓ {{ $totalProveedores }} Activos</span>
            <span class="text-gray-500 dark:text-gray-400 text-xs">disponibles</span>
        </div>
    </div>

    <!-- Servicios -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition group">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Servicios</p>
                <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $totalServicios }}</p>
            </div>
            <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg group-hover:scale-110 transition">
                <i class="bi bi-briefcase text-2xl text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
            <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">{{ $totalTarifas }}</span>
            <span class="text-gray-500 dark:text-gray-400 text-xs">tarifas</span>
        </div>
    </div>

    <!-- Búsquedas Semana -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition group">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Búsquedas (7d)</p>
                <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $busquedasUltimaSemana }}</p>
            </div>
            <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg group-hover:scale-110 transition">
                <i class="bi bi-search text-2xl text-orange-600 dark:text-orange-400"></i>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
            @if ($porcentajeBusquedas >= 0)
                <span class="text-green-600 dark:text-green-400 font-semibold text-sm">↑ {{ $porcentajeBusquedas }}%</span>
            @else
                <span class="text-red-600 dark:text-red-400 font-semibold text-sm">↓ {{ abs($porcentajeBusquedas) }}%</span>
            @endif
            <span class="text-gray-500 dark:text-gray-400 text-xs">vs. semana anterior</span>
        </div>
    </div>
</div>
            <i class="bi bi-map-fill text-3xl text-indigo-600 opacity-20"></i>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    <a href="{{ route('admin.providers.index') }}" class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl hover:shadow-lg hover:scale-105 transition duration-200">
        <div class="flex flex-col gap-2">
            <i class="bi bi-building text-2xl text-blue-600"></i>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Proveedores</span>
        </div>
    </a>
    <a href="{{ route('admin.services.index') }}" class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl hover:shadow-lg hover:scale-105 transition duration-200">
        <div class="flex flex-col gap-2">
            <i class="bi bi-briefcase text-2xl text-green-600"></i>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Servicios</span>
        </div>
    </a>
    <a href="{{ route('admin.tariffs.index') }}" class="p-4 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl hover:shadow-lg hover:scale-105 transition duration-200">
        <div class="flex flex-col gap-2">
            <i class="bi bi-tags text-2xl text-purple-600"></i>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Tarifas</span>
        </div>
    </a>
    <a href="{{ route('admin.locations.index') }}" class="p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-xl hover:shadow-lg hover:scale-105 transition duration-200">
        <div class="flex flex-col gap-2">
            <i class="bi bi-map-fill text-2xl text-indigo-600"></i>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Ubicaciones</span>
        </div>
    </a>
    <a href="{{ route('admin.users.index') }}" class="p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl hover:shadow-lg hover:scale-105 transition duration-200">
        <div class="flex flex-col gap-2">
            <i class="bi bi-people text-2xl text-orange-600"></i>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Usuarios</span>
        </div>
    </a>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Actividad Últimos 7 Días -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Búsquedas (Últimos 7 días)</h3>
            <span class="text-3xl font-black text-blue-600">{{ $busquedasUltimaSemana }}</span>
        </div>
        <div class="space-y-3">
            @php
                $dias = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                $datos = $busquedasPorDia;
                $maxValor = !empty($datos) && max($datos) > 0 ? max($datos) : 1;
            @endphp
            @forelse ($dias as $idx => $dia)
                <div class="flex items-end gap-3">
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400 w-10">{{ $dia }}</span>
                    <div class="flex-1">
                        <div class="h-10 bg-gradient-to-r from-blue-400 to-blue-600 dark:from-blue-600 dark:to-blue-500 rounded-lg"
                             style="width: {{ ($datos[$idx] / $maxValor) * 100 }}%">
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-900 dark:text-white w-8 text-right">{{ $datos[$idx] }}</span>
                </div>
            @empty
            @endforelse
        </div>
    </div>

    <!-- Top Tipos Servicio -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Servicios Populares</h3>
        <div class="space-y-4">
            @forelse ($tiposMasDemandados as $tipo)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $tipo->nombre }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $tipo->servicios_count }} servicios</p>
                    </div>
                    <div class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 rounded-full text-sm font-bold">
                        ⭐ Top
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-6">Sin datos disponibles</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Proveedores Principales -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top Proveedores</h3>
        <a href="{{ route('admin.providers.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">Ver todos →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Proveedor</th>
                    <th class="text-left py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Servicios</th>
                    <th class="text-left py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Estado</th>
                    <th class="text-right py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proveedoresMasBuscados as $proveedor)
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                @if ($proveedor->logo)
                                    <img src="{{ asset('storage/' . $proveedor->logo) }}" alt="{{ $proveedor->nombre }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                        <i class="bi bi-building text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $proveedor->nombre }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $proveedor->id_proveedor }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="font-bold text-gray-900 dark:text-white">{{ $proveedor->servicios_count }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-semibold">Activo</span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <a href="{{ route('admin.providers.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm">Editar →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-inbox text-3xl opacity-50 block mb-2"></i>
                            No hay proveedores aún
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
