@extends('layouts.admin')

@section('title', 'Nuevo proveedor · Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <a href="{{ route('admin.providers.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:gap-2.5 transition-all mb-3">
        <i class="bi bi-arrow-left"></i>Volver a proveedores
    </a>
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 grid place-items-center text-white shadow-lg shadow-emerald-500/30">
            <i class="bi bi-building-fill text-xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Nuevo proveedor</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Añade un proveedor al catálogo</p>
        </div>
    </div>
</div>

@include('shared.alerts')

<div class="max-w-2xl rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8">
    <form method="POST" action="{{ route('admin.providers.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="nombre" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-building mr-1"></i>Nombre del proveedor *
            </label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('nombre') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('nombre')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="tipo_proveedor" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-tag mr-1"></i>Tipo de proveedor *
            </label>
            <input type="text" id="tipo_proveedor" name="tipo_proveedor" value="{{ old('tipo_proveedor') }}" required placeholder="Ej: Telecomunicaciones, Energía…"
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('tipo_proveedor') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('tipo_proveedor')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="web" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-globe mr-1"></i>Sitio web
            </label>
            <input type="url" id="web" name="web" value="{{ old('web') }}" placeholder="https://ejemplo.com"
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('web') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('web')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-3">
                <i class="bi bi-image mr-1"></i>Logo
            </label>
            <div class="mb-3 flex gap-2 p-1 rounded-xl bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="logo_type" value="file" checked class="peer hidden">
                    <div class="px-4 py-2 rounded-lg text-center text-sm font-semibold text-slate-600 dark:text-slate-300 peer-checked:bg-white peer-checked:dark:bg-slate-700 peer-checked:text-indigo-600 peer-checked:dark:text-indigo-300 peer-checked:shadow-sm transition-all">
                        <i class="bi bi-upload mr-1"></i>Subir archivo
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="logo_type" value="url" class="peer hidden">
                    <div class="px-4 py-2 rounded-lg text-center text-sm font-semibold text-slate-600 dark:text-slate-300 peer-checked:bg-white peer-checked:dark:bg-slate-700 peer-checked:text-indigo-600 peer-checked:dark:text-indigo-300 peer-checked:shadow-sm transition-all">
                        <i class="bi bi-link-45deg mr-1"></i>URL
                    </div>
                </label>
            </div>
            <div id="fileInput">
                <input type="file" id="logo" name="logo" accept="image/*"
                       class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 dark:file:bg-indigo-950/50 file:text-indigo-700 dark:file:text-indigo-300 file:font-bold file:text-xs focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 @error('logo') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Máximo 5MB · PNG, JPG, JPEG</p>
            </div>
            <div id="urlInput" class="hidden">
                <input type="text" id="logo_url" name="logo" placeholder="https://ejemplo.com/logo.png"
                       class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all border-slate-200 dark:border-slate-700">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">URL completa con http:// o https://</p>
            </div>
            @error('logo')<p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
            <input type="checkbox" id="api_disponible" name="api_disponible"
                   class="w-5 h-5 rounded text-indigo-600 focus:ring-2 focus:ring-indigo-500/40">
            <label for="api_disponible" class="flex-1 text-sm font-semibold text-slate-700 dark:text-slate-300">
                <i class="bi bi-plug-fill text-indigo-500 mr-1"></i>API disponible
                <span class="block text-xs text-slate-500 dark:text-slate-400 font-normal mt-0.5">El proveedor expone una API para obtener tarifas en tiempo real</span>
            </label>
        </div>

        <div class="flex gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
            <button type="submit" class="btn-brand ring-brand flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-bold">
                <i class="bi bi-check-lg"></i>Crear proveedor
            </button>
            <a href="{{ route('admin.providers.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold transition">
                <i class="bi bi-x-lg"></i>Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('input[name="logo_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const isFile = this.value === 'file';
            document.getElementById('fileInput').classList.toggle('hidden', !isFile);
            document.getElementById('urlInput').classList.toggle('hidden', isFile);
            if (isFile) document.getElementById('logo_url').value = '';
            else document.getElementById('logo').value = '';
        });
    });
</script>
@endsection
