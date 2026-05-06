@extends('layouts.admin')

@section('title', 'Editar tarifa · Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <a href="{{ route('admin.tariffs.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:gap-2.5 transition-all mb-3">
        <i class="bi bi-arrow-left"></i>Volver a tarifas
    </a>
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 grid place-items-center text-white shadow-lg shadow-amber-500/30">
            <i class="bi bi-tags-fill text-xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Editar tarifa</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Modificando <span class="font-bold text-slate-700 dark:text-slate-200">{{ $tarifa->nombre_tarifa }}</span></p>
        </div>
    </div>
</div>

@include('shared.alerts')

<div class="max-w-3xl rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8">
    <form method="POST" action="{{ route('admin.tariffs.update', $tarifa) }}" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label for="id_servicio" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-briefcase mr-1"></i>Servicio *
            </label>
            <select id="id_servicio" name="id_servicio" required
                    class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('id_servicio') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
                <option value="">— Seleccionar servicio —</option>
                @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id_servicio }}" @selected(old('id_servicio', $tarifa->id_servicio) == $servicio->id_servicio)>{{ $servicio->nombre_servicio }} ({{ $servicio->proveedor->nombre }})</option>
                @endforeach
            </select>
            @error('id_servicio')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="nombre_tarifa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-tag mr-1"></i>Nombre de la tarifa *
            </label>
            <input type="text" id="nombre_tarifa" name="nombre_tarifa" value="{{ old('nombre_tarifa', $tarifa->nombre_tarifa) }}" required
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('nombre_tarifa') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('nombre_tarifa')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="precio" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    <i class="bi bi-currency-euro mr-1"></i>Precio *
                </label>
                <input type="number" id="precio" name="precio" value="{{ old('precio', $tarifa->precio) }}" step="0.01" min="0.01" required
                       class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('precio') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
                @error('precio')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="unidad_precio" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    <i class="bi bi-graph-up mr-1"></i>Unidad *
                </label>
                <input type="text" id="unidad_precio" name="unidad_precio" value="{{ old('unidad_precio', $tarifa->unidad_precio) }}" required
                       class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('unidad_precio') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
                @error('unidad_precio')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="permanencia" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-calendar-check mr-1"></i>Permanencia
            </label>
            <select id="permanencia" name="permanencia"
                    class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all border-slate-200 dark:border-slate-700">
                <option value="">— Sin especificar —</option>
                <option value="1mes" @selected(old('permanencia', $tarifa->permanencia) == '1mes')>1 mes</option>
                <option value="3meses" @selected(old('permanencia', $tarifa->permanencia) == '3meses')>3 meses</option>
                <option value="6meses" @selected(old('permanencia', $tarifa->permanencia) == '6meses')>6 meses</option>
                <option value="12meses" @selected(old('permanencia', $tarifa->permanencia) == '12meses')>12 meses</option>
                <option value="sin_permanencia" @selected(old('permanencia', $tarifa->permanencia) == 'sin_permanencia')>Sin permanencia</option>
            </select>
        </div>

        <div>
            <label for="condiciones" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-file-text mr-1"></i>Condiciones / descripción
            </label>
            <textarea id="condiciones" name="condiciones" rows="4"
                      class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('condiciones') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">{{ old('condiciones', $tarifa->condiciones) }}</textarea>
            @error('condiciones')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="url_oferta_externa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-link-45deg mr-1"></i>URL de oferta externa (opcional)
            </label>
            <input type="url" id="url_oferta_externa" name="url_oferta_externa" value="{{ old('url_oferta_externa', $tarifa->url_oferta_externa) }}" placeholder="https://ejemplo.com/oferta"
                   class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all @error('url_oferta_externa') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror">
            @error('url_oferta_externa')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="bi bi-geo-alt mr-1"></i>Códigos postales disponibles
            </label>
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 max-h-72 overflow-y-auto">
                @forelse ($ubicaciones as $ubicacion)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="ubicaciones[]" value="{{ $ubicacion->id_ubicacion }}"
                               @checked(in_array($ubicacion->id_ubicacion, old('ubicaciones', $tarifa->ubicaciones->pluck('id_ubicacion')->toArray())))
                               class="peer hidden">
                        <span class="block text-center px-2 py-1.5 rounded-lg text-xs font-bold border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:border-indigo-400 transition-all peer-checked:bg-gradient-to-br peer-checked:from-sky-500 peer-checked:to-indigo-500 peer-checked:text-white peer-checked:border-transparent peer-checked:shadow-md">
                            {{ $ubicacion->codigo_postal }}
                        </span>
                    </label>
                @empty
                    <p class="col-span-full text-slate-500 dark:text-slate-400 text-sm">No hay códigos postales registrados</p>
                @endforelse
            </div>
            @error('ubicaciones')<p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
            <button type="submit" class="btn-brand ring-brand flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-bold">
                <i class="bi bi-check-lg"></i>Guardar cambios
            </button>
            <a href="{{ route('admin.tariffs.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold transition">
                <i class="bi bi-x-lg"></i>Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
