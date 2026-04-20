@extends('layouts.app')

@section('title', 'Gestionar Tarifas - Admin EasyMove')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
        <div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-rose-600 to-rose-700 bg-clip-text text-transparent mb-2">
                💰 Gestionar Tarifas
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Administra precios y planes de servicios</p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Total: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $tarifas->total() }}</span> tarifas</p>
        </div>
        <a href="{{ route('admin.tariffs.create') }}" class="px-6 py-3 bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 text-white font-bold rounded-lg transition shadow-lg flex items-center gap-2 w-fit">
            <i class="bi bi-plus-circle-fill text-xl"></i>
            Nueva Tarifa
        </a>
    </div>
</div>

@include('shared.alerts')

<!-- Filtro de búsqueda -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="🔍 Buscar tarifas..."
                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-rose-500 dark:focus:border-rose-400 transition">
        </div>
        <button type="submit" class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 whitespace-nowrap shadow-md">
            <i class="bi bi-search"></i>
            Buscar
        </button>
        @if($search)
            <a href="{{ route('admin.tariffs.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition whitespace-nowrap">
                ✕ Limpiar
            </a>
        @endif
    </form>
</div>

<!-- Tabla de Tarifas -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b-2 border-gray-200 dark:border-gray-700">
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Nombre</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Servicio</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Proveedor</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Ubicaciones</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Precio</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Permanencia</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Actualizado</th>
                    <th class="text-center py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tarifas as $tarifa)
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-rose-50 dark:hover:bg-gray-700/50 transition duration-150">
                        <td class="py-4 px-6">
                            <p class="text-gray-900 dark:text-white font-bold">{{ $tarifa->nombre_tarifa }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $tarifa->servicio->nombre_servicio }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $tarifa->servicio->proveedor->nombre }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if ($tarifa->disponibilidades->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($tarifa->disponibilidades->take(3) as $disponibilidad)
                                        <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $disponibilidad->ubicacion->codigo_postal }}
                                        </span>
                                    @endforeach
                                    @if ($tarifa->disponibilidades->count() > 3)
                                        <span class="text-gray-500 dark:text-gray-400 text-xs font-semibold">+{{ $tarifa->disponibilidades->count() - 3 }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-gray-900 dark:text-white font-bold">{{ number_format($tarifa->precio, 2, ',', '.') }} €</p>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">/ {{ $tarifa->unidad_precio }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if ($tarifa->permanencia)
                                <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $tarifa->permanencia }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">
                                @if ($tarifa->updated_at)
                                    {{ \Carbon\Carbon::parse($tarifa->updated_at)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.tariffs.edit', $tarifa) }}"
                                   class="p-2.5 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition duration-200 font-semibold"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.tariffs.destroy', $tarifa) }}"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar esta tarifa?');" style="display:inline;">
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
                        <td colspan="8" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-600"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay tarifas registradas</p>
                                <a href="{{ route('admin.tariffs.create') }}" class="text-rose-600 dark:text-rose-400 hover:underline text-sm font-semibold">
                                    + Crear la primera
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
        {{ $tarifas->links() }}
    </nav>
</div>
@endsection
