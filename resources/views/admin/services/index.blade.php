@extends('layouts.admin')

@section('title', 'Servicios · Admin EasyMove')

@section('admin-content')
<div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 grid place-items-center text-white shadow-lg shadow-purple-500/30">
                <i class="bi bi-briefcase-fill text-xl"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">Servicios</h1>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400">Total: <span class="font-bold text-slate-700 dark:text-slate-200">{{ $servicios->total() }}</span> servicios disponibles</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn-brand ring-brand inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-bold w-fit">
        <i class="bi bi-plus-lg"></i>Nuevo servicio
    </a>
</div>

@include('shared.alerts')

<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div class="relative">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar servicios…"
                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
        </div>
        <select name="proveedor" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
            <option value="">Todos los proveedores</option>
            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->id_proveedor }}" @selected(request('proveedor') == $proveedor->id_proveedor)>{{ $proveedor->nombre }}</option>
            @endforeach
        </select>
        <select name="tipo" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
            <option value="">Todos los tipos</option>
            @foreach ($tiposServicios as $tipo)
                <option value="{{ $tipo->id_tipo_servicio }}" @selected(request('tipo') == $tipo->id_tipo_servicio)>{{ $tipo->nombre }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <button type="submit" class="btn-brand ring-brand flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-bold">
                <i class="bi bi-funnel-fill"></i>Filtrar
            </button>
            @if($search || $filterProveedor || $filterTipo)
                <a href="{{ route('admin.services.index') }}" class="px-4 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold transition" title="Limpiar">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nombre</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Proveedor</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Tipo</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Descripción</th>
                    <th class="text-right py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($servicios as $servicio)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $servicio->nombre_servicio }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300">
                                <i class="bi bi-building"></i>{{ $servicio->proveedor->nombre }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-950/50 text-purple-700 dark:text-purple-300">
                                <i class="bi bi-tag"></i>{{ $servicio->tipoServicio->nombre }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{{ Str::limit($servicio->descripcion, 60) }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.services.edit', $servicio) }}" title="Editar" class="p-2.5 rounded-lg text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.services.destroy', $servicio) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');" class="inline">
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
                        <td colspan="5" class="py-16 px-6 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl grid place-items-center bg-slate-100 dark:bg-slate-800 text-slate-400">
                                <i class="bi bi-inbox text-2xl"></i>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 font-semibold mb-2">No hay servicios registrados</p>
                            <a href="{{ route('admin.services.create') }}" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline">+ Crear el primero</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $servicios->links() }}</div>
@endsection
