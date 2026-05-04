@extends('layouts.admin')

@section('title', 'Gestionar Servicios - Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
        <div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-purple-600 to-purple-700 bg-clip-text text-transparent mb-2">
                ⚡ Gestionar Servicios
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Administra el catálogo de servicios disponibles</p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Total: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $servicios->total() }}</span> servicios</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold rounded-lg transition shadow-lg flex items-center gap-2 w-fit">
            <i class="bi bi-plus-circle-fill text-xl"></i>
            Nuevo Servicio
        </a>
    </div>
</div>

@include('shared.alerts')

<!-- Filtros -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div>
            <input type="text" name="search" value="{{ $search }}" placeholder="🔍 Buscar servicios..."
                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 transition">
        </div>
        <div>
            <select name="proveedor" class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 transition">
                <option value="">📦 Todos los proveedores</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}" @selected(request('proveedor') == $proveedor->id_proveedor)>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="tipo" class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-purple-500 dark:focus:border-purple-400 transition">
                <option value="">📋 Todos los tipos</option>
                @foreach ($tiposServicios as $tipo)
                    <option value="{{ $tipo->id_tipo_servicio }}" @selected(request('tipo') == $tipo->id_tipo_servicio)>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 whitespace-nowrap shadow-md">
                <i class="bi bi-filter"></i>
                Filtrar
            </button>
            @if($search || $filterProveedor || $filterTipo)
                <a href="{{ route('admin.services.index') }}" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition whitespace-nowrap">
                    ✕ Limpiar
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabla de Servicios -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b-2 border-gray-200 dark:border-gray-700">
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Nombre</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Proveedor</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Tipo</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Descripción</th>
                    <th class="text-center py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servicios as $servicio)
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-purple-50 dark:hover:bg-gray-700/50 transition duration-150">
                        <td class="py-4 px-6">
                            <p class="text-gray-900 dark:text-white font-bold">{{ $servicio->nombre_servicio }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $servicio->proveedor->nombre }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $servicio->tipoServicio->nombre }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">{{ Str::limit($servicio->descripcion, 50) }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.services.edit', $servicio) }}"
                                   class="p-2.5 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition duration-200 font-semibold"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.services.destroy', $servicio) }}"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition duration-200 font-semibold" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-600"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay servicios registrados</p>
                                <a href="{{ route('admin.services.create') }}" class="text-purple-600 dark:text-purple-400 hover:underline text-sm font-semibold">
                                    + Crear el primero
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Paginación -->
<div class="mt-6 flex justify-center">
    <nav aria-label="pagination" class="inline-flex gap-1">
        {{ $servicios->links() }}
    </nav>
</div>
@endsection
