@extends('layouts.admin')

@section('title', 'Panel Administrador - EasyMove')

@section('admin-content')
<!-- Header Profesional -->
<div class="mb-8 animate-slide-down">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="bi bi-speedometer2 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-sky-600 to-blue-600 dark:from-sky-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Panel de Control
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Bienvenido, <span class="font-semibold text-gray-700 dark:text-gray-200">{{ Auth::user()->nombre }}</span></p>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                <i class="bi bi-calendar3"></i> {{ now()->locale('es')->translatedFormat('l, j \d\e F \d\e Y') }}
            </p>
        </div>
        <a href="{{ route('home') }}" class="px-6 py-3 bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg hover:shadow-lg hover:border-sky-500 dark:hover:border-sky-400 transition-all duration-300 font-semibold flex items-center gap-2 w-fit group">
            <i class="bi bi-house group-hover:-translate-y-1 transition-transform"></i>
            Volver al Sitio
        </a>
    </div>
</div>

<!-- Estadísticas Principales con diseño mejorado -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card: Usuarios Totales -->
    <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl shadow-card hover:shadow-card-hover transition-all duration-300 overflow-hidden border border-gray-200 dark:border-slate-700">
        <div class="absolute inset-0 bg-gradient-to-r from-sky-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Usuarios</p>
                    <p class="text-5xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsuarios }}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-sky-100 to-sky-50 dark:from-sky-900/40 dark:to-sky-900/20 rounded-xl group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                    <i class="bi bi-people text-3xl text-sky-600 dark:text-sky-400"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-100 dark:border-slate-700">
                <span class="text-green-600 dark:text-green-400 font-bold text-sm flex items-center gap-1">
                    <i class="bi bi-arrow-up"></i> {{ $usuariosNuevos }}
                </span>
                <span class="text-gray-500 dark:text-gray-400 text-xs">nuevos en 7 días</span>
            </div>
        </div>
    </div>

    <!-- Card: Proveedores -->
    <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl shadow-card hover:shadow-card-hover transition-all duration-300 overflow-hidden border border-gray-200 dark:border-slate-700">
        <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Proveedores</p>
                    <p class="text-5xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalProveedores }}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-green-100 to-green-50 dark:from-green-900/40 dark:to-green-900/20 rounded-xl group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                    <i class="bi bi-building text-3xl text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-100 dark:border-slate-700">
                <span class="text-green-600 dark:text-green-400 font-bold text-sm flex items-center gap-1">
                    <i class="bi bi-check-circle-fill"></i> Activos
                </span>
                <span class="text-gray-500 dark:text-gray-400 text-xs">{{ $totalProveedores }} disponibles</span>
            </div>
        </div>
    </div>

    <!-- Card: Servicios -->
    <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl shadow-card hover:shadow-card-hover transition-all duration-300 overflow-hidden border border-gray-200 dark:border-slate-700">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Servicios</p>
                    <p class="text-5xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalServicios }}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-purple-100 to-purple-50 dark:from-purple-900/40 dark:to-purple-900/20 rounded-xl group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                    <i class="bi bi-briefcase text-3xl text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-100 dark:border-slate-700">
                <span class="text-purple-600 dark:text-purple-400 font-bold text-sm flex items-center gap-1">
                    <i class="bi bi-lightning-fill"></i> {{ $totalTarifas }}
                </span>
                <span class="text-gray-500 dark:text-gray-400 text-xs">tarifas activas</span>
            </div>
        </div>
    </div>

    <!-- Card: Búsquedas -->
    <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl shadow-card hover:shadow-card-hover transition-all duration-300 overflow-hidden border border-gray-200 dark:border-slate-700">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Búsquedas (7d)</p>
                    <p class="text-5xl font-bold text-gray-900 dark:text-white mt-2">{{ $busquedasUltimaSemana }}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-orange-100 to-orange-50 dark:from-orange-900/40 dark:to-orange-900/20 rounded-xl group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                    <i class="bi bi-search text-3xl text-orange-600 dark:text-orange-400"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-100 dark:border-slate-700">
                @if ($porcentajeBusquedas >= 0)
                    <span class="text-green-600 dark:text-green-400 font-bold text-sm flex items-center gap-1">
                        <i class="bi bi-graph-up"></i> {{ $porcentajeBusquedas }}%
                    </span>
                @else
                    <span class="text-red-600 dark:text-red-400 font-bold text-sm flex items-center gap-1">
                        <i class="bi bi-graph-down"></i> {{ abs($porcentajeBusquedas) }}%
                    </span>
                @endif
                <span class="text-gray-500 dark:text-gray-400 text-xs">vs. semana anterior</span>
            </div>
        </div>
    </div>
</div>

<!-- Accesos Rápidos -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    <a href="{{ route('admin.providers.index') }}" class="group p-5 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/30 dark:to-blue-900/10 border-2 border-blue-200 dark:border-blue-800/40 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
        <div class="flex flex-col gap-3">
            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="bi bi-building text-xl text-white"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Proveedores</span>
        </div>
    </a>
    <a href="{{ route('admin.services.index') }}" class="group p-5 bg-gradient-to-br from-green-50 to-green-100/50 dark:from-green-900/30 dark:to-green-900/10 border-2 border-green-200 dark:border-green-800/40 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
        <div class="flex flex-col gap-3">
            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="bi bi-briefcase text-xl text-white"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Servicios</span>
        </div>
    </a>
    <a href="{{ route('admin.tariffs.index') }}" class="group p-5 bg-gradient-to-br from-purple-50 to-purple-100/50 dark:from-purple-900/30 dark:to-purple-900/10 border-2 border-purple-200 dark:border-purple-800/40 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
        <div class="flex flex-col gap-3">
            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="bi bi-tags text-xl text-white"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Tarifas</span>
        </div>
    </a>
    <a href="{{ route('admin.locations.index') }}" class="group p-5 bg-gradient-to-br from-indigo-50 to-indigo-100/50 dark:from-indigo-900/30 dark:to-indigo-900/10 border-2 border-indigo-200 dark:border-indigo-800/40 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
        <div class="flex flex-col gap-3">
            <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="bi bi-geo-alt text-xl text-white"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Ubicaciones</span>
        </div>
    </a>
    <a href="{{ route('admin.users.index') }}" class="group p-5 bg-gradient-to-br from-orange-50 to-orange-100/50 dark:from-orange-900/30 dark:to-orange-900/10 border-2 border-orange-200 dark:border-orange-800/40 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
        <div class="flex flex-col gap-3">
            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="bi bi-people text-xl text-white"></i>
            </div>
            <span class="text-sm font-bold text-gray-900 dark:text-white">Usuarios</span>
        </div>
    </a>
</div>

<!-- Gráficos y Análisis -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Gráfico de Búsquedas -->
    <div class="lg:col-span-2 bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-gray-200 dark:border-slate-700 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="bi bi-graph-up text-sky-600 dark:text-sky-400"></i>
                    Búsquedas por Día
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Últimos 7 días</p>
            </div>
            <span class="text-4xl font-black text-sky-600 dark:text-sky-400">{{ $busquedasUltimaSemana }}</span>
        </div>
        <div class="space-y-4">
            @php
                $dias = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                $datos = $busquedasPorDia;
                $maxValor = !empty($datos) && max($datos) > 0 ? max($datos) : 1;
            @endphp
            @forelse ($dias as $idx => $dia)
                <div class="flex items-center gap-3 group">
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400 w-8">{{ $dia }}</span>
                    <div class="flex-1">
                        <div class="h-8 bg-gradient-to-r from-sky-400 to-sky-600 dark:from-sky-600 dark:to-sky-500 rounded-lg transition-all duration-500 hover:shadow-lg group-hover:shadow-sky-500/30"
                             style="width: {{ ($datos[$idx] / $maxValor) * 100 }}%; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);">
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-900 dark:text-white w-10 text-right">{{ $datos[$idx] }}</span>
                </div>
            @empty
            @endforelse
        </div>
    </div>

    <!-- Servicios Populares -->
    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-gray-200 dark:border-slate-700 p-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-6">
            <i class="bi bi-star-fill text-yellow-500"></i>
            Servicios Populares
        </h3>
        <div class="space-y-3">
            @forelse ($tiposMasDemandados as $tipo)
                <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white group-hover:translate-x-1 transition-transform">{{ $tipo->nombre }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $tipo->servicios_count }} servicios</p>
                        </div>
                        <div class="px-3 py-1 bg-gradient-to-r from-yellow-100 to-orange-100 dark:from-yellow-900/40 dark:to-orange-900/40 text-yellow-700 dark:text-yellow-300 rounded-full text-xs font-bold">
                            ⭐ Top
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 dark:text-gray-500 py-8">Sin datos</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Tabla: Top Proveedores -->
<div class="bg-gradient-to-br from-white to-gray-50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl shadow-card hover:shadow-card-hover transition-all duration-300 border border-gray-200 dark:border-slate-700 p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i class="bi bi-building text-sky-600 dark:text-sky-400"></i>
            Top Proveedores
        </h3>
        <a href="{{ route('admin.providers.index') }}" class="text-sm text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 font-semibold flex items-center gap-1 hover:gap-2 transition-all">
            Ver todos <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-gray-200 dark:border-slate-700">
                    <th class="text-left py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Proveedor</th>
                    <th class="text-left py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Servicios</th>
                    <th class="text-left py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Estado</th>
                    <th class="text-right py-4 px-4 text-gray-700 dark:text-gray-300 font-bold text-sm">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proveedoresMasBuscados as $proveedor)
                    <tr class="border-b border-gray-100 dark:border-slate-700/50 hover:bg-gradient-to-r hover:from-sky-50 dark:hover:from-sky-900/10 hover:to-transparent transition-all duration-300 group">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                @if ($proveedor->logo)
                                    <img src="{{ asset('storage/' . $proveedor->logo) }}" alt="{{ $proveedor->nombre }}" class="w-10 h-10 rounded-lg object-cover shadow-md">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-sky-100 to-sky-50 dark:from-sky-900/40 dark:to-sky-900/20 flex items-center justify-center shadow-md">
                                        <i class="bi bi-building text-sky-600 dark:text-sky-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">{{ $proveedor->nombre }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $proveedor->id_proveedor }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-2 font-bold text-gray-900 dark:text-white">
                                <i class="bi bi-briefcase text-sky-600"></i>
                                {{ $proveedor->servicios_count }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1.5 bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-700 dark:text-green-300 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                <i class="bi bi-check-circle-fill"></i> Activo
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <a href="{{ route('admin.providers.index') }}" class="text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 font-bold text-sm flex items-center gap-1 justify-end hover:gap-2 transition-all">
                                Editar <i class="bi bi-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 px-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-inbox text-4xl opacity-30 block mb-2"></i>
                            <p class="font-semibold">No hay proveedores aún</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
