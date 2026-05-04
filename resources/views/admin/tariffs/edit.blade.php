@extends('layouts.admin')

@section('title', 'Editar Tarifa - Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <a href="{{ route('admin.tariffs.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 mb-4">
        <i class="bi bi-chevron-left"></i>
        Volver a Tarifas
    </a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Tarifa</h1>
</div>

@include('shared.alerts')

<div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 border border-gray-200 dark:border-slate-800 max-w-2xl">
    <form method="POST" action="{{ route('admin.tariffs.update', $tarifa) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Servicio -->
        <div>
            <label for="id_servicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-briefcase me-2"></i>Servicio
            </label>
            <select id="id_servicio" name="id_servicio" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('id_servicio') border-red-500 @enderror">
                <option value="">-- Seleccionar servicio --</option>
                @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id_servicio }}" @selected(old('id_servicio', $tarifa->id_servicio) == $servicio->id_servicio)>
                        {{ $servicio->nombre_servicio }} ({{ $servicio->proveedor->nombre }})
                    </option>
                @endforeach
            </select>
            @error('id_servicio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Nombre Tarifa -->
        <div>
            <label for="nombre_tarifa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-tags me-2"></i>Nombre de la Tarifa
            </label>
            <input type="text" id="nombre_tarifa" name="nombre_tarifa" value="{{ old('nombre_tarifa', $tarifa->nombre_tarifa) }}" required
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('nombre_tarifa') border-red-500 @enderror"
                   placeholder="ej: Plan Básico, Premium, etc.">
            @error('nombre_tarifa') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Grid de Precio y Unidad -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Precio -->
            <div>
                <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="bi bi-currency-euro me-2"></i>Precio
                </label>
                <input type="number" id="precio" name="precio" value="{{ old('precio', $tarifa->precio) }}" step="0.01" min="0.01" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('precio') border-red-500 @enderror"
                       placeholder="29.99">
                @error('precio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Unidad Precio -->
            <div>
                <label for="unidad_precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="bi bi-graph-up me-2"></i>Unidad
                </label>
                <input type="text" id="unidad_precio" name="unidad_precio" value="{{ old('unidad_precio', $tarifa->unidad_precio) }}" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('unidad_precio') border-red-500 @enderror"
                       placeholder="mes, año, GB, Mbps, etc.">
                @error('unidad_precio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Permanencia -->
        <div>
            <label for="permanencia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-calendar me-2"></i>Permanencia
            </label>
            <select id="permanencia" name="permanencia"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
                <option value="">-- Sin permanencia --</option>
                <option value="1mes" @selected(old('permanencia', $tarifa->permanencia) == '1mes')>1 Mes</option>
                <option value="3meses" @selected(old('permanencia', $tarifa->permanencia) == '3meses')>3 Meses</option>
                <option value="6meses" @selected(old('permanencia', $tarifa->permanencia) == '6meses')>6 Meses</option>
                <option value="12meses" @selected(old('permanencia', $tarifa->permanencia) == '12meses')>12 Meses</option>
                <option value="sin_permanencia" @selected(old('permanencia', $tarifa->permanencia) == 'sin_permanencia')>Sin Permanencia</option>
            </select>
            @error('permanencia') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Condiciones -->
        <div>
            <label for="condiciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-file-text me-2"></i>Condiciones / Descripción
            </label>
            <textarea id="condiciones" name="condiciones" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('condiciones') border-red-500 @enderror"
                      placeholder="Descripción detallada de la tarifa, incluidas condiciones especiales">{{ old('condiciones', $tarifa->condiciones) }}</textarea>
            @error('condiciones') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- URL Oferta Externa -->
        <div>
            <label for="url_oferta_externa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-link-45deg me-2"></i>URL de Oferta Externa (Opcional)
            </label>
            <input type="url" id="url_oferta_externa" name="url_oferta_externa" value="{{ old('url_oferta_externa', $tarifa->url_oferta_externa) }}"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('url_oferta_externa') border-red-500 @enderror"
                   placeholder="https://ejemplo.com/oferta">
            @error('url_oferta_externa') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Códigos Postales -->
        <div>
            <label for="ubicaciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-geo-alt me-2"></i>Códigos Postales Disponibles
            </label>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 p-4 bg-gray-50 dark:bg-slate-800 rounded-lg border border-gray-300 dark:border-slate-700">
                @forelse ($ubicaciones as $ubicacion)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="ubicaciones[]" value="{{ $ubicacion->id_ubicacion }}"
                               @checked(in_array($ubicacion->id_ubicacion, old('ubicaciones', $tarifa->ubicaciones->pluck('id_ubicacion')->toArray())))
                               class="w-4 h-4 text-primary-600 rounded focus:ring-2 focus:ring-primary-600">
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $ubicacion->codigo_postal }}</span>
                    </label>
                @empty
                    <p class="col-span-full text-gray-500 dark:text-gray-400 text-sm">No hay códigos postales registrados</p>
                @endforelse
            </div>
            @error('ubicaciones') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Botones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                <i class="bi bi-check-lg"></i>
                Guardar Cambios
            </button>
            <a href="{{ route('admin.tariffs.index') }}" class="flex-1 px-6 py-2 bg-gray-300 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 transition flex items-center justify-center gap-2">
                <i class="bi bi-x-lg"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
