@extends('layouts.app')

@section('title', ($title ?? 'Historial de Comparaciones') . ' - EasyMove')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $title ?? 'Historial de Comparaciones' }}</h1>
            <p class="text-gray-600 dark:text-gray-400">{{ $subtitle ?? 'Tus comparaciones guardadas' }}</p>
        </div>
        <a href="{{ route('search') }}" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition flex items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            Nueva Búsqueda
        </a>
    </div>
</div>

@include('shared.alerts')

<!-- Tabla de Comparaciones -->
<div class="bg-white dark:bg-slate-900 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-slate-800">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700">
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-semibold">Nombre</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-semibold">Tipo de Servicio</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-semibold">Ubicación</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-semibold">Fecha de guardado</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comparaciones as $comparacion)
                    <tr class="border-b border-gray-100 dark:border-slate-800 hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                        <td class="py-4 px-6">
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ $comparacion->nombre_guardado ?? 'Comparación ' . $comparacion->id_comparacion }}
                            </p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm">
                                {{ $comparacion->tipoServicio->nombre ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-gray-600 dark:text-gray-400">
                            {{ $comparacion->ubicacion->codigo_postal ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-gray-600 dark:text-gray-400 text-sm">
                            {{ $comparacion->updated_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2">
                                <a href="{{ route('comparison.show', $comparacion) }}"
                                   class="px-3 py-1 bg-primary-600 hover:bg-primary-700 text-white rounded text-sm transition flex items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                    Ver
                                </a>
                                <form method="POST" action="{{ route('comparison.export-pdf') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="comparacion_id" value="{{ $comparacion->id_comparacion }}">
                                    <button type="submit" class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm transition flex items-center gap-1">
                                        <i class="bi bi-file-pdf"></i>
                                        PDF
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-6 text-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-inbox text-4xl opacity-50 block mb-2"></i>
                            <p class="font-medium mb-2">{{ $emptyMessage ?? 'No tienes comparaciones guardadas' }}</p>
                            <a href="{{ route('search') }}" class="text-primary-600 hover:text-primary-700 underline">
                                Realiza una nueva búsqueda
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Paginación -->
<div class="mt-6">
    {{ $comparaciones->links() }}
</div>
@endsection
