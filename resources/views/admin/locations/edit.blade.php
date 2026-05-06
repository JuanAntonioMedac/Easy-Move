@extends('layouts.admin')

@section('title', 'Editar ubicación · Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <a href="{{ route('admin.locations.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:gap-2.5 transition-all mb-3">
        <i class="bi bi-arrow-left"></i>Volver a ubicaciones
    </a>
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 grid place-items-center text-white shadow-lg shadow-sky-500/30">
            <i class="bi bi-geo-alt-fill text-xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Editar código postal</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Modificando <span class="font-bold text-slate-700 dark:text-slate-200">{{ $ubicacion->codigo_postal }}</span></p>
        </div>
    </div>
</div>

@include('shared.alerts')

<div class="max-w-2xl rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8">
    <form method="POST" action="{{ route('admin.locations.update', $ubicacion) }}" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label for="codigo_postal" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-mailbox mr-1"></i>Código postal *
            </label>
            <input type="text" id="codigo_postal" name="codigo_postal" placeholder="Ej: 28001" value="{{ old('codigo_postal', $ubicacion->codigo_postal) }}"
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('codigo_postal') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('codigo_postal')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="ciudad" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-geo-alt mr-1"></i>Ciudad *
            </label>
            <input type="text" id="ciudad" name="ciudad" placeholder="Ej: Madrid" value="{{ old('ciudad', $ubicacion->ciudad) }}"
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('ciudad') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('ciudad')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="provincia" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-map mr-1"></i>Provincia *
            </label>
            <input type="text" id="provincia" name="provincia" placeholder="Ej: Madrid" value="{{ old('provincia', $ubicacion->provincia) }}"
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('provincia') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('provincia')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
            <button type="submit" class="btn-brand ring-brand flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-bold">
                <i class="bi bi-check-lg"></i>Actualizar
            </button>
            <a href="{{ route('admin.locations.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold transition">
                <i class="bi bi-x-lg"></i>Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
