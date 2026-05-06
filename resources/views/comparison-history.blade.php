@extends('layouts.app')

@section('title', ($title ?? 'Historial de Comparaciones') . ' · EasyMove')

@section('content')
<div class="space-y-8">

    {{-- ============== HERO HEADER ============== --}}
    <div class="relative overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8 bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-500 text-white shadow-xl shadow-indigo-500/20">
        <div class="bg-blob w-[360px] h-[360px] -top-20 -right-20 bg-white/30"></div>
        <div class="relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur border border-white/30 mb-3">
                    <i class="bi bi-clock-history"></i> {{ $title ?? 'Historial' }}
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $title ?? 'Historial de Comparaciones' }}</h1>
                <p class="mt-1 text-white/90">{{ $subtitle ?? 'Todas tus comparaciones guardadas en un solo lugar' }}</p>
            </div>
            <a href="{{ route('search') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white text-indigo-700 font-bold shadow-md hover:shadow-xl hover:-translate-y-0.5 transition-all">
                <i class="bi bi-plus-lg"></i>Nueva búsqueda
            </a>
        </div>
    </div>

    @include('shared.alerts')

    {{-- ============== TABLA ============== --}}
    @if($comparaciones->count() > 0)
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nombre</th>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Servicio</th>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Ubicación</th>
                            <th class="text-left py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Fecha</th>
                            <th class="text-right py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($comparaciones as $i => $comparacion)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors animate-fade-in-up" style="animation-delay: {{ $i * 0.04 }}s">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-500 grid place-items-center text-white shadow-md flex-shrink-0">
                                            <i class="bi bi-bar-chart-fill"></i>
                                        </div>
                                        <p class="font-bold text-slate-900 dark:text-white">
                                            {{ $comparacion->nombre_guardado ?? 'Comparación #' . $comparacion->id_comparacion }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300">
                                        <i class="bi bi-tag-fill"></i>{{ $comparacion->tipoServicio->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-slate-700 dark:text-slate-300 text-sm font-medium">
                                    <i class="bi bi-geo-alt text-slate-400 mr-1"></i>{{ $comparacion->ubicacion->codigo_postal ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-6 text-slate-600 dark:text-slate-400 text-sm">
                                    {{ $comparacion->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('comparison.show', $comparacion) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-sm hover:shadow-md">
                                            <i class="bi bi-eye-fill"></i>Ver
                                        </a>
                                        <form method="POST" action="{{ route('comparison.export-pdf') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="comparacion_id" value="{{ $comparacion->id_comparacion }}">
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 text-xs font-bold transition">
                                                <i class="bi bi-file-earmark-pdf"></i>PDF
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-2">{{ $comparaciones->links() }}</div>
    @else
        <div class="rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 bg-white/60 dark:bg-slate-900/40 p-16 text-center">
            <div class="w-16 h-16 mx-auto mb-5 rounded-2xl grid place-items-center bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 text-slate-500">
                <i class="bi bi-inbox text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ $emptyMessage ?? 'No tienes comparaciones guardadas' }}</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Empieza creando tu primera comparación.</p>
            <a href="{{ route('search') }}" class="btn-brand ring-brand inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-bold">
                <i class="bi bi-search"></i>Realizar nueva búsqueda
            </a>
        </div>
    @endif
</div>
@endsection
