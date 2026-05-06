@extends('layouts.admin')

@section('title', 'Tarifas · Admin EasyMove')

@section('admin-content')
<div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 grid place-items-center text-white shadow-lg shadow-amber-500/30">
                <i class="bi bi-tags-fill text-xl"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">Tarifas</h1>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400">Total: <span class="font-bold text-slate-700 dark:text-slate-200">{{ $tarifas->total() }}</span> tarifas registradas</p>
    </div>
    <a href="{{ route('admin.tariffs.create') }}" class="btn-brand ring-brand inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-bold w-fit">
        <i class="bi bi-plus-lg"></i>Nueva tarifa
    </a>
</div>

@include('shared.alerts')

<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 mb-6">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar tarifas…"
                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
        </div>
        <button type="submit" class="btn-brand ring-brand inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-white font-bold whitespace-nowrap">
            <i class="bi bi-search"></i>Buscar
        </button>
        @if($search)
            <a href="{{ route('admin.tariffs.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold whitespace-nowrap transition">
                <i class="bi bi-x-lg"></i>Limpiar
            </a>
        @endif
    </form>
</div>

<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nombre</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Servicio</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Proveedor</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Ubicaciones</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Precio</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Permanencia</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Actualizado</th>
                    <th class="text-right py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($tarifas as $tarifa)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $tarifa->nombre_tarifa }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $tarifa->servicio->nombre_servicio }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300">
                                <i class="bi bi-building"></i>{{ $tarifa->servicio->proveedor->nombre }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if ($tarifa->disponibilidades->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($tarifa->disponibilidades->take(3) as $disponibilidad)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-sky-100 dark:bg-sky-950/50 text-sky-700 dark:text-sky-300">
                                            {{ $disponibilidad->ubicacion->codigo_postal }}
                                        </span>
                                    @endforeach
                                    @if ($tarifa->disponibilidades->count() > 3)
                                        <span class="text-slate-500 dark:text-slate-400 text-[11px] font-bold">+{{ $tarifa->disponibilidades->count() - 3 }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-400 text-sm">—</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-extrabold gradient-text tabular-nums">{{ number_format($tarifa->precio, 2, ',', '.') }} €</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-semibold">/ {{ $tarifa->unidad_precio }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if ($tarifa->permanencia)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300">
                                    <i class="bi bi-calendar-check"></i>{{ $tarifa->permanencia }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300">
                                    <i class="bi bi-unlock"></i>Sin
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-400">
                            {{ $tarifa->updated_at ? \Carbon\Carbon::parse($tarifa->updated_at)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.tariffs.edit', $tarifa) }}" title="Editar" class="p-2.5 rounded-lg text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.tariffs.destroy', $tarifa) }}" onsubmit="return confirm('¿Seguro que deseas eliminar esta tarifa?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Eliminar" class="p-2.5 rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-16 px-6 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl grid place-items-center bg-slate-100 dark:bg-slate-800 text-slate-400">
                                <i class="bi bi-inbox text-2xl"></i>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 font-semibold mb-2">No hay tarifas registradas</p>
                            <a href="{{ route('admin.tariffs.create') }}" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline">+ Crear la primera</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $tarifas->links() }}</div>
@endsection
