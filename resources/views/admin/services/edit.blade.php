@extends('layouts.admin')

@section('title', 'Editar servicio · Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:gap-2.5 transition-all mb-3">
        <i class="bi bi-arrow-left"></i>Volver a servicios
    </a>
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 grid place-items-center text-white shadow-lg shadow-purple-500/30">
            <i class="bi bi-briefcase-fill text-xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Editar servicio</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Modificando <span class="font-bold text-slate-700 dark:text-slate-200">{{ $servicio->nombre_servicio }}</span></p>
        </div>
    </div>
</div>

@include('shared.alerts')

<div class="max-w-2xl rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8">
    <form method="POST" action="{{ route('admin.services.update', $servicio) }}" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label for="nombre_servicio" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-briefcase mr-1"></i>Nombre del servicio *
            </label>
            <input type="text" id="nombre_servicio" name="nombre_servicio" value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}" required
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('nombre_servicio') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('nombre_servicio')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="id_proveedor" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-building mr-1"></i>Proveedor *
            </label>
            <select id="id_proveedor" name="id_proveedor" required
                    class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('id_proveedor') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
                <option value="">— Seleccionar proveedor —</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}" @selected(old('id_proveedor', $servicio->id_proveedor) == $proveedor->id_proveedor)>{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
            @error('id_proveedor')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="id_tipo_servicio" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-list-check mr-1"></i>Tipo de servicio *
            </label>
            <select id="id_tipo_servicio" name="id_tipo_servicio" required
                    class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('id_tipo_servicio') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
                <option value="">— Seleccionar tipo —</option>
                @foreach ($tiposServicios as $tipo)
                    <option value="{{ $tipo->id_tipo_servicio }}" @selected(old('id_tipo_servicio', $servicio->id_tipo_servicio) == $tipo->id_tipo_servicio)>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
            @error('id_tipo_servicio')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="descripcion" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-file-text mr-1"></i>Descripción
            </label>
            <textarea id="descripcion" name="descripcion" rows="4"
                      class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('descripcion') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">{{ old('descripcion', $servicio->descripcion) }}</textarea>
            @error('descripcion')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
            <button type="submit" class="btn-brand ring-brand flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-bold">
                <i class="bi bi-check-lg"></i>Guardar cambios
            </button>
            <a href="{{ route('admin.services.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold transition">
                <i class="bi bi-x-lg"></i>Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
