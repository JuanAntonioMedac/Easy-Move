@extends('layouts.app')

@section('title', 'Crear Servicio - Admin EasyMove')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 mb-4">
        <i class="bi bi-chevron-left"></i>
        Volver a Servicios
    </a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Crear Nuevo Servicio</h1>
</div>

@include('shared.alerts')

<div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 border border-gray-200 dark:border-slate-800 max-w-2xl">
    <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-6">
        @csrf

        <!-- Nombre -->
        <div>
            <label for="nombre_servicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-briefcase me-2"></i>Nombre del Servicio
            </label>
            <input type="text" id="nombre_servicio" name="nombre_servicio" value="{{ old('nombre_servicio') }}" required
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('nombre_servicio') border-red-500 @enderror">
            @error('nombre_servicio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Proveedor -->
        <div>
            <label for="id_proveedor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-building me-2"></i>Proveedor
            </label>
            <select id="id_proveedor" name="id_proveedor" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('id_proveedor') border-red-500 @enderror">
                <option value="">-- Seleccionar proveedor --</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}" @selected(old('id_proveedor') == $proveedor->id_proveedor)>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_proveedor') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tipo de Servicio -->
        <div>
            <label for="id_tipo_servicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-list-check me-2"></i>Tipo de Servicio
            </label>
            <select id="id_tipo_servicio" name="id_tipo_servicio" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('id_tipo_servicio') border-red-500 @enderror">
                <option value="">-- Seleccionar tipo --</option>
                @foreach ($tiposServicios as $tipo)
                    <option value="{{ $tipo->id_tipo_servicio }}" @selected(old('id_tipo_servicio') == $tipo->id_tipo_servicio)>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_tipo_servicio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Descripción -->
        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-file-text me-2"></i>Descripción
            </label>
            <textarea id="descripcion" name="descripcion" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
            @error('descripcion') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Botones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                <i class="bi bi-check-lg"></i>
                Crear Servicio
            </button>
            <a href="{{ route('admin.services.index') }}" class="flex-1 px-6 py-2 bg-gray-300 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 transition flex items-center justify-center gap-2">
                <i class="bi bi-x-lg"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
