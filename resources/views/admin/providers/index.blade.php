@extends('layouts.admin')

@section('title', 'Gestionar Proveedores - Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
        <div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">
                🏢 Gestionar Proveedores
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Administra el catálogo de proveedores de servicios</p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Total: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $proveedores->total() }}</span> proveedores</p>
        </div>
        <a href="{{ route('admin.providers.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg transition shadow-lg flex items-center gap-2 w-fit">
            <i class="bi bi-plus-circle-fill text-xl"></i>
            Nuevo Proveedor
        </a>
    </div>
</div>

@include('shared.alerts')

<!-- Barra de búsqueda -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="🔍 Buscar por nombre, web..."
                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 transition">
        </div>
        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 whitespace-nowrap shadow-md">
            <i class="bi bi-search"></i>
            Buscar
        </button>
        @if($search)
            <a href="{{ route('admin.providers.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition whitespace-nowrap">
                ✕ Limpiar
            </a>
        @endif
    </form>
</div>

<!-- Tabla de Proveedores -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b-2 border-gray-200 dark:border-gray-700">
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Logo</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Nombre</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Tipo</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Web</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">API</th>
                    <th class="text-center py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proveedores as $proveedor)
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-blue-50 dark:hover:bg-gray-700/50 transition duration-150">
                        <td class="py-4 px-6">
                            @if ($proveedor->logo)
                                <img src="{{ $proveedor->logo_url }}" alt="{{ $proveedor->nombre }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 flex items-center justify-center text-blue-600">
                                    <i class="bi bi-building text-lg"></i>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-gray-900 dark:text-white font-bold">{{ $proveedor->nombre }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $proveedor->tipo_proveedor }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if ($proveedor->web)
                                <a href="{{ $proveedor->web }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium flex items-center gap-1">
                                    {{ Str::limit($proveedor->web, 25) }}
                                    <i class="bi bi-box-arrow-up-right text-xs"></i>
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if ($proveedor->api_disponible)
                                <span class="inline-flex items-center gap-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="bi bi-check-circle-fill"></i> Sí
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="bi bi-dash-circle-fill"></i> No
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.providers.edit', $proveedor) }}"
                                   class="p-2.5 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition duration-200 font-semibold"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.providers.destroy', $proveedor) }}"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este proveedor?');" style="display:inline;">
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
                        <td colspan="6" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-600"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay proveedores registrados</p>
                                <a href="{{ route('admin.providers.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
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
        {{ $proveedores->links() }}
    </nav>
</div>
@endsection
