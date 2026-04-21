@extends('layouts.app')

@section('title', 'Crear Proveedor - Admin EasyMove')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.providers.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 mb-4">
        <i class="bi bi-chevron-left"></i>
        Volver a Proveedores
    </a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Crear Nuevo Proveedor</h1>
</div>

@include('shared.alerts')

<div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 border border-gray-200 dark:border-slate-800 max-w-2xl">
    <form method="POST" action="{{ route('admin.providers.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-building me-2"></i>Nombre del Proveedor
            </label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('nombre') border-red-500 @enderror">
            @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tipo Proveedor -->
        <div>
            <label for="tipo_proveedor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-tag me-2"></i>Tipo de Proveedor
            </label>
            <input type="text" id="tipo_proveedor" name="tipo_proveedor" value="{{ old('tipo_proveedor') }}" required
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('tipo_proveedor') border-red-500 @enderror"
                   placeholder="ej: Telecomunicaciones, Servicios Postales, etc.">
            @error('tipo_proveedor') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Web -->
        <div>
            <label for="web" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-globe me-2"></i>Sitio Web
            </label>
            <input type="url" id="web" name="web" value="{{ old('web') }}"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('web') border-red-500 @enderror"
                   placeholder="https://ejemplo.com">
            @error('web') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Logo -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                <i class="bi bi-image me-2"></i>Logo
            </label>

            <!-- Selector de tipo: Archivo o URL -->
            <div class="mb-4 flex gap-4">
                <label class="flex items-center">
                    <input type="radio" name="logo_type" value="file" checked
                           class="w-4 h-4 text-primary-600 focus:ring-2 focus:ring-primary-600">
                    <span class="ms-2 text-sm text-gray-700 dark:text-gray-300">Subir archivo</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="logo_type" value="url"
                           class="w-4 h-4 text-primary-600 focus:ring-2 focus:ring-primary-600">
                    <span class="ms-2 text-sm text-gray-700 dark:text-gray-300">URL del logo</span>
                </label>
            </div>

            <!-- Input de archivo -->
            <div id="fileInput" class="mb-4">
                <input type="file" id="logo" name="logo" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('logo') border-red-500 @enderror">
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Máximo 5MB (PNG, JPG, JPEG)</p>
            </div>

            <!-- Input de URL -->
            <div id="urlInput" class="mb-4 hidden">
                <input type="text" id="logo_url" name="logo" placeholder="https://ejemplo.com/logo.png"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('logo') border-red-500 @enderror">
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">URL completa incluyendo protocolo (http:// o https://)</p>
            </div>

            @error('logo') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
        </div>

        <script>
            const radioButtons = document.querySelectorAll('input[name="logo_type"]');
            const fileInput = document.getElementById('fileInput');
            const urlInput = document.getElementById('urlInput');
            const logoFileInput = document.getElementById('logo');
            const logoUrlInput = document.getElementById('logo_url');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'file') {
                        fileInput.classList.remove('hidden');
                        urlInput.classList.add('hidden');
                        logoUrlInput.value = '';
                    } else {
                        fileInput.classList.add('hidden');
                        urlInput.classList.remove('hidden');
                        logoFileInput.value = '';
                    }
                });
            });
        </script>

        <!-- API Disponible -->
        <div class="flex items-center gap-3">
            <input type="checkbox" id="api_disponible" name="api_disponible"
                   class="w-4 h-4 rounded text-primary-600 focus:ring-2 focus:ring-primary-600 @error('api_disponible') border-red-500 @enderror">
            <label for="api_disponible" class="text-sm text-gray-700 dark:text-gray-300">
                <i class="bi bi-plug-fill me-2"></i>API Disponible
            </label>
        </div>

        <!-- Botones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                <i class="bi bi-check-lg"></i>
                Crear Proveedor
            </button>
            <a href="{{ route('admin.providers.index') }}" class="flex-1 px-6 py-2 bg-gray-300 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 transition flex items-center justify-center gap-2">
                <i class="bi bi-x-lg"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
