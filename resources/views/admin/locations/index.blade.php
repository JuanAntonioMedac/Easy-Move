@extends('layouts.admin')

@section('title', 'Ubicaciones · Admin EasyMove')

@section('admin-content')
<div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 grid place-items-center text-white shadow-lg shadow-sky-500/30">
                <i class="bi bi-geo-alt-fill text-xl"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">Códigos postales</h1>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400">Total: <span class="font-bold text-slate-700 dark:text-slate-200">{{ $ubicaciones->total() }}</span> ubicaciones registradas</p>
    </div>
    <a href="{{ route('admin.locations.create') }}" class="btn-brand ring-brand inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-bold w-fit">
        <i class="bi bi-plus-lg"></i>Nueva ubicación
    </a>
</div>

@include('shared.alerts')

<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 mb-6">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por código postal, ciudad, provincia…"
                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
        </div>
        <button type="submit" class="btn-brand ring-brand inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-white font-bold whitespace-nowrap">
            <i class="bi bi-search"></i>Buscar
        </button>
        @if($search)
            <a href="{{ route('admin.locations.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold whitespace-nowrap transition">
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
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Código postal</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Ciudad</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Provincia</th>
                    <th class="text-right py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($ubicaciones as $ubicacion)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-sky-100 dark:bg-sky-950/50 text-sky-700 dark:text-sky-300 tabular-nums">
                                <i class="bi bi-geo-alt-fill"></i>{{ $ubicacion->codigo_postal }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $ubicacion->ciudad }}</p>
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-400">{{ $ubicacion->provincia }}</td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.locations.edit', $ubicacion) }}" title="Editar" class="p-2.5 rounded-lg text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.locations.destroy', $ubicacion) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este código postal?');" class="inline">
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
                        <td colspan="4" class="py-16 px-6 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl grid place-items-center bg-slate-100 dark:bg-slate-800 text-slate-400">
                                <i class="bi bi-inbox text-2xl"></i>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 font-semibold mb-2">No hay códigos postales</p>
                            <a href="{{ route('admin.locations.create') }}" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline">+ Crear el primero</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $ubicaciones->links() }}</div>
@endsection
