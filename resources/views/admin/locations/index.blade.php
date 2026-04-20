@extends('layouts.app')

@section('title', 'Gestionar Códigos Postales - Admin EasyMove')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
        <div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-emerald-600 to-emerald-700 bg-clip-text text-transparent mb-2">
                📍 Gestionar Códigos Postales
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Administra todas las ubicaciones disponibles</p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Total: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $ubicaciones->total() }}</span> códigos postales</p>
        </div>
        <a href="{{ route('admin.locations.create') }}" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-bold rounded-lg transition shadow-lg flex items-center gap-2 w-fit">
            <i class="bi bi-plus-circle-fill text-xl"></i>
            Nuevo Código Postal
        </a>
    </div>
</div>

@include('shared.alerts')

<!-- Filtro de búsqueda -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="🔍 Buscar por código postal, ciudad, provincia..."
                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 dark:focus:border-emerald-400 transition">
        </div>
        <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 whitespace-nowrap shadow-md">
            <i class="bi bi-search"></i>
            Buscar
        </button>
        @if($search)
            <a href="{{ route('admin.locations.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition whitespace-nowrap">
                ✕ Limpiar
            </a>
        @endif
    </form>
</div>

<!-- Tabla de Ubicaciones -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b-2 border-gray-200 dark:border-gray-700">
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Código Postal</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Ciudad</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Provincia</th>
                    <th class="text-center py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ubicaciones as $ubicacion)
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-emerald-50 dark:hover:bg-gray-700/50 transition duration-150">
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-3 py-1 rounded-full text-sm font-bold">
                                {{ $ubicacion->codigo_postal }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-gray-900 dark:text-white font-medium">{{ $ubicacion->ciudad }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $ubicacion->provincia }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.locations.edit', $ubicacion) }}"
                                   class="p-2.5 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition duration-200 font-semibold"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.locations.destroy', $ubicacion) }}"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este código postal?');" style="display:inline;">
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
                        <td colspan="4" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-600"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay códigos postales registrados</p>
                                <a href="{{ route('admin.locations.create') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline text-sm font-semibold">
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
<div class="mt-6">
    {{ $ubicaciones->links() }}
</div>
@endsection
