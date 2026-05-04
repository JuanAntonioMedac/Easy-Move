@extends('layouts.admin')

@section('title', 'Crear Ubicación - Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.locations.index') }}" class="text-primary-600 hover:text-primary-700 transition">
            <i class="bi bi-arrow-left text-2xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Crear Código Postal</h1>
            <p class="text-gray-600 dark:text-gray-400">Añade un nuevo código postal y ubicación al sistema</p>
        </div>
    </div>
</div>

@include('shared.alerts')

<!-- Formulario -->
<div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 border border-gray-200 dark:border-slate-800 max-w-2xl">
    <form method="POST" action="{{ route('admin.locations.store') }}" class="space-y-6">
        @csrf

        <!-- Código Postal -->
        <div>
            <label for="codigo_postal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-mailbox me-2"></i>Código Postal *
            </label>
            <input type="text" id="codigo_postal" name="codigo_postal"
                   placeholder="Ej: 28001"
                   value="{{ old('codigo_postal') }}"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('codigo_postal') border-red-500 @enderror">
            @error('codigo_postal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Ciudad -->
        <div>
            <label for="ciudad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-geo-alt me-2"></i>Ciudad *
            </label>
            <input type="text" id="ciudad" name="ciudad"
                   placeholder="Ej: Madrid"
                   value="{{ old('ciudad') }}"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('ciudad') border-red-500 @enderror">
            @error('ciudad') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Provincia -->
        <div>
            <label for="provincia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="bi bi-map me-2"></i>Provincia *
            </label>
            <input type="text" id="provincia" name="provincia"
                   placeholder="Ej: Madrid"
                   value="{{ old('provincia') }}"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 @error('provincia') border-red-500 @enderror">
            @error('provincia') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Acciones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition font-medium flex items-center justify-center gap-2">
                <i class="bi bi-check-lg"></i>
                Crear Código Postal
            </button>
            <a href="{{ route('admin.locations.index') }}" class="flex-1 px-4 py-2 bg-gray-300 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-slate-600 transition font-medium flex items-center justify-center gap-2">
                <i class="bi bi-x-lg"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
