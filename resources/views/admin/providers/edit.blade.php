@extends('layouts.app')

@section('title', 'Editar Proveedor - Admin EasyMove')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.providers.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 mb-4">
        <i class="bi bi-chevron-left"></i>
        Volver a Proveedores
    </a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Proveedor</h1>
</div>

@include('shared.alerts')

<div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 border border-gray-200 dark:border-slate-800 max-w-2xl">
    <form method="POST" action="{{ route('admin.providers.update', $proveedor) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-building me-2"></i>Nombre del Proveedor
            </label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('nombre') border-red-500 @enderror">
            @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tipo Proveedor -->
        <div>
            <label for="tipo_proveedor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-tag me-2"></i>Tipo de Proveedor
            </label>
            <input type="text" id="tipo_proveedor" name="tipo_proveedor" value="{{ old('tipo_proveedor', $proveedor->tipo_proveedor) }}" required
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('tipo_proveedor') border-red-500 @enderror"
                   placeholder="ej: Telecomunicaciones, Servicios Postales, etc.">
            @error('tipo_proveedor') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Web -->
        <div>
            <label for="web" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-globe me-2"></i>Sitio Web
            </label>
            <input type="url" id="web" name="web" value="{{ old('web', $proveedor->web) }}"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('web') border-red-500 @enderror"
                   placeholder="https://ejemplo.com">
            @error('web') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Logo -->
        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-image me-2"></i>Logo
            </label>
            @if ($proveedor->logo)
                <div class="mb-4">
                    <img src="{{ Storage::url($proveedor->logo) }}" alt="{{ $proveedor->nombre }}" class="w-20 h-20 rounded">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Logo actual</p>
                </div>
            @endif
            <input type="file" id="logo" name="logo" accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('logo') border-red-500 @enderror">
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Máximo 5MB (PNG, JPG, JPEG) - Dejar vacío para mantener el actual</p>
            @error('logo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- API Disponible -->
        <div class="flex items-center gap-3">
            <input type="checkbox" id="api_disponible" name="api_disponible"
                   @checked(old('api_disponible', $proveedor->api_disponible))
                   class="w-4 h-4 rounded text-primary-600 focus:ring-2 focus:ring-primary-600 @error('api_disponible') border-red-500 @enderror">
            <label for="api_disponible" class="text-sm text-gray-700 dark:text-gray-300">
                <i class="bi bi-plug-fill me-2"></i>API Disponible
            </label>
        </div>

        <!-- Botones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                <i class="bi bi-check-lg"></i>
                Guardar Cambios
            </button>
            <a href="{{ route('admin.providers.index') }}" class="flex-1 px-6 py-2 bg-gray-300 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 transition flex items-center justify-center gap-2">
                <i class="bi bi-x-lg"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
