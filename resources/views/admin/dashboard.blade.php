@extends('layouts.admin')

@section('title', 'Dashboard · Admin EasyMove')

@section('admin-content')
{{-- ============== HEADER ============== --}}
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-500 grid place-items-center text-white shadow-lg shadow-indigo-500/30">
                    <i class="bi bi-speedometer2 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight gradient-text">Panel de Control</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Bienvenido, <span class="font-semibold text-slate-700 dark:text-slate-200">{{ Auth::user()->nombre }}</span></p>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                <i class="bi bi-calendar3"></i> {{ now()->locale('es')->translatedFormat('l, j \\d\\e F \\d\\e Y') }}
            </p>
        </div>
        <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 font-bold hover:border-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
            <i class="bi bi-house-door group-hover:-translate-y-0.5 transition-transform"></i>
            Volver al sitio
        </a>
    </div>
</div>

{{-- ============== STATS ============== --}}
@php
    $stats = [
        ['label' => 'Usuarios', 'value' => $totalUsuarios, 'icon' => 'people-fill', 'gradient' => 'from-sky-500 to-indigo-500', 'shadow' => 'shadow-sky-500/30', 'sub' => '+'.$usuariosNuevos.' nuevos en 7 días', 'subColor' => 'text-emerald-600 dark:text-emerald-400'],
        ['label' => 'Proveedores', 'value' => $totalProveedores, 'icon' => 'building-fill', 'gradient' => 'from-emerald-500 to-teal-500', 'shadow' => 'shadow-emerald-500/30', 'sub' => $totalProveedores.' activos', 'subColor' => 'text-emerald-600 dark:text-emerald-400'],
        ['label' => 'Servicios', 'value' => $totalServicios, 'icon' => 'briefcase-fill', 'gradient' => 'from-purple-500 to-pink-500', 'shadow' => 'shadow-purple-500/30', 'sub' => $totalTarifas.' tarifas activas', 'subColor' => 'text-purple-600 dark:text-purple-400'],
        ['label' => 'Búsquedas (7d)', 'value' => $busquedasUltimaSemana, 'icon' => 'search', 'gradient' => 'from-amber-500 to-orange-500', 'shadow' => 'shadow-amber-500/30', 'sub' => ($porcentajeBusquedas >= 0 ? '+' : '').$porcentajeBusquedas.'% vs. semana anterior', 'subColor' => $porcentajeBusquedas >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'],
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @foreach ($stats as $i => $stat)
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ $i * 0.05 }}s">
            <div class="absolute -top-12 -right-12 w-32 h-32 rounded-full bg-gradient-to-br {{ $stat['gradient'] }} opacity-10 blur-2xl group-hover:opacity-25 transition-opacity"></div>
            <div class="relative">
                <div class="flex justify-between items-start mb-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                        <p class="text-4xl font-extrabold text-slate-900 dark:text-white mt-2 tabular-nums">{{ $stat['value'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $stat['gradient'] }} grid place-items-center text-white shadow-lg {{ $stat['shadow'] }} group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        <i class="bi bi-{{ $stat['icon'] }} text-xl"></i>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-semibold {{ $stat['subColor'] }}">{{ $stat['sub'] }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ============== QUICK ACCESS ============== --}}
@php
    $quickLinks = [
        ['route' => 'admin.providers.index', 'icon' => 'building-fill', 'label' => 'Proveedores', 'gradient' => 'from-sky-500 to-indigo-500'],
        ['route' => 'admin.services.index', 'icon' => 'briefcase-fill', 'label' => 'Servicios', 'gradient' => 'from-emerald-500 to-teal-500'],
        ['route' => 'admin.tariffs.index', 'icon' => 'tags-fill', 'label' => 'Tarifas', 'gradient' => 'from-purple-500 to-pink-500'],
        ['route' => 'admin.locations.index', 'icon' => 'geo-alt-fill', 'label' => 'Ubicaciones', 'gradient' => 'from-amber-500 to-orange-500'],
        ['route' => 'admin.users.index', 'icon' => 'people-fill', 'label' => 'Usuarios', 'gradient' => 'from-rose-500 to-fuchsia-500'],
    ];
@endphp
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 mb-8">
    @foreach ($quickLinks as $link)
        <a href="{{ route($link['route']) }}" class="group relative overflow-hidden rounded-2xl p-5 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:border-indigo-400 hover:shadow-lg hover:-translate-y-1 transition-all">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $link['gradient'] }} grid place-items-center text-white shadow-md mb-3 group-hover:scale-110 transition-transform">
                <i class="bi bi-{{ $link['icon'] }} text-lg"></i>
            </div>
            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $link['label'] }}</span>
            <i class="bi bi-arrow-up-right absolute top-4 right-4 text-slate-300 dark:text-slate-700 group-hover:text-indigo-500 group-hover:rotate-12 transition-all"></i>
        </a>
    @endforeach
</div>

{{-- ============== ANALYTICS ROW ============== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Búsquedas por día --}}
    <div class="lg:col-span-2 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="bi bi-graph-up-arrow text-indigo-500"></i>
                    Búsquedas por día
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Últimos 7 días</p>
            </div>
            <span class="text-3xl font-extrabold gradient-text tabular-nums">{{ $busquedasUltimaSemana }}</span>
        </div>
        <div class="space-y-3">
            @php
                $datos = $busquedasPorDia ?? [0,0,0,0,0,0,0];
                $labels = $labelsBusquedasPorDia ?? ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
                $maxValor = !empty($datos) && max($datos) > 0 ? max($datos) : 1;
            @endphp
            @foreach ($labels as $idx => $dia)
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 w-8">{{ $dia }}</span>
                    <div class="flex-1 h-7 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-sky-500 via-indigo-500 to-purple-500 shadow-md shadow-indigo-500/30 transition-all duration-700"
                             style="width: {{ ($datos[$idx] ?? 0) / $maxValor * 100 }}%"></div>
                    </div>
                    <span class="text-sm font-bold text-slate-900 dark:text-white w-10 text-right tabular-nums">{{ $datos[$idx] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Servicios populares --}}
    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2 mb-5">
            <i class="bi bi-star-fill text-amber-500"></i>
            Más demandados
        </h3>
        <div class="space-y-2">
            @forelse ($tiposMasDemandados as $i => $tipo)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-orange-500 grid place-items-center text-white text-sm font-bold flex-shrink-0">{{ $i + 1 }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-slate-900 dark:text-white truncate">{{ $tipo->nombre }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $tipo->servicios_count }} servicios</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-400 py-8 text-sm">Sin datos disponibles</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ============== TOP PROVIDERS ============== --}}
<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
    <div class="flex justify-between items-center p-6 border-b border-slate-100 dark:border-slate-800">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="bi bi-trophy-fill text-amber-500"></i>
            Top proveedores
        </h3>
        <a href="{{ route('admin.providers.index') }}" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1">
            Ver todos <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Proveedor</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Servicios</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Estado</th>
                    <th class="text-right py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($proveedoresMasBuscados as $proveedor)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if ($proveedor->logo_url)
                                    <img src="{{ $proveedor->logo_url }}" alt="{{ $proveedor->nombre }}" class="w-10 h-10 rounded-xl object-contain bg-white dark:bg-slate-900 p-1 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-500 grid place-items-center text-white font-bold shadow-md">{{ substr($proveedor->nombre, 0, 1) }}</div>
                                @endif
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $proveedor->nombre }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">ID: {{ $proveedor->id_proveedor }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 font-bold text-sm text-slate-900 dark:text-white">
                                <i class="bi bi-briefcase text-indigo-500"></i>
                                {{ $proveedor->servicios_count }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300">
                                <i class="bi bi-check-circle-fill"></i>Activo
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.providers.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:gap-2 transition-all">
                                Editar <i class="bi bi-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 px-6 text-center text-slate-500 dark:text-slate-400">
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
