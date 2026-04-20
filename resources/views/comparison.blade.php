@extends('layouts.app')

@section('title', 'Comparación de Tarifas -EasyMove')

@section('content')
<div class="mb-16">
    <!-- Header con Gradiente -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-700 dark:to-purple-800 rounded-lg shadow-lg p-8 mb-8">
        <div class="flex justify-between items-start gap-6">
            <div>
                <h1 class="text-5xl font-black text-white mb-2">💰 Comparación de Tarifas</h1>
                <p class="text-blue-100 text-lg">Compara las mejores opciones y ahorra dinero</p>
            </div>
            @auth
                <div class="flex flex-col sm:flex-row gap-2">
                    <button onclick="saveComparison()" class="px-4 py-2.5 bg-white hover:bg-blue-50 text-blue-600 rounded-lg transition font-semibold flex items-center gap-2 shadow-md hover:shadow-lg whitespace-nowrap text-sm sm:text-base">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="hidden sm:inline">Guardar</span>
                    </button>
                    <a href="{{ route('comparison.history') }}" class="px-4 py-2.5 bg-blue-500 hover:bg-blue-700 text-white rounded-lg transition font-semibold flex items-center gap-2 shadow-md hover:shadow-lg whitespace-nowrap text-sm sm:text-base">
                        <i class="bi bi-clock-history"></i>
                        <span class="hidden sm:inline">Historial</span>
                    </a>
                </div>
            @endauth
        </div>
    </div>

    @include('shared.alerts')

    <!-- Cards Comparativas -->
    <div>
        @if(isset($tarifas) && count($tarifas) > 0)
            @php
                // Calcular tarifa más barata
                $minPrecio = $tarifas->min('precio');
            @endphp

            <!-- Información de Precios -->
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-blue-900 dark:text-blue-200 text-sm">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Mejor precio:</strong> {{ number_format($minPrecio, 2, ',', '.') }}€
                    <span class="text-xs opacity-75">(Ahorra hasta {{ number_format($tarifas->max('precio') - $minPrecio, 2, ',', '.') }}€)</span>
                </p>
            </div>

            <!-- Grid de Tarifas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($tarifas as $tarifa)
                    @php
                        $esMasBarata = $tarifa->precio == $minPrecio;
                        $diferencia = $tarifa->precio - $minPrecio;
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-lg border-2 {{ $esMasBarata ? 'border-green-500 dark:border-green-600' : 'border-gray-200 dark:border-gray-700' }} shadow-md hover:shadow-lg transition overflow-hidden">

                        <!-- Badge Mejor Oferta -->
                        @if($esMasBarata)
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 text-center font-bold text-sm">
                                ⭐ MEJOR OFERTA
                            </div>
                        @endif

                        <!-- Contenido Card -->
                        <div class="p-6 space-y-4">

                            <!-- Proveedor -->
                            <div class="flex items-center gap-3 pb-4 border-b border-gray-200 dark:border-gray-700">
                                @if($tarifa->servicio->proveedor->logo)
                                    <img src="{{ Storage::url($tarifa->servicio->proveedor->logo) }}"
                                         alt="{{ $tarifa->servicio->proveedor->nombre }}"
                                         class="w-12 h-12 rounded-lg object-cover shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                        <i class="bi bi-building text-lg"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $tarifa->servicio->proveedor->nombre }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $tarifa->servicio->nombre_servicio }}</p>
                                </div>
                            </div>

                            <!-- Nombre Tarifa -->
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Plan</p>
                                <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $tarifa->nombre_tarifa }}</p>
                            </div>

                            <!-- Precio Principal -->
                            <div class="bg-gradient-to-r {{ $esMasBarata ? 'from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30' : 'from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800' }} rounded-lg p-4">
                                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">Precio</p>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="{{ $esMasBarata ? 'text-green-600 dark:text-green-400' : 'text-gray-900 dark:text-white' }} text-4xl font-black">
                                        {{ number_format($tarifa->precio, 2, ',', '.') }}€
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">/ {{ $tarifa->unidad_precio }}</span>
                                </div>

                                <!-- Diferencia de Precio -->
                                @if(!$esMasBarata)
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-2">
                                        +{{ number_format($diferencia, 2, ',', '.') }}€ más caro
                                    </p>
                                @endif
                            </div>

                            <!-- Permanencia -->
                            @if($tarifa->permanencia)
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Permanencia</p>
                                    <span class="inline-block bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 px-3 py-1 rounded-full text-xs font-medium">
                                        <i class="bi bi-calendar-check me-1"></i>{{ $tarifa->permanencia }}
                                    </span>
                                </div>
                            @else
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Permanencia</p>
                                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">
                                        <i class="bi bi-check-circle me-1"></i>Sin compromiso
                                    </p>
                                </div>
                            @endif

                            <!-- Condiciones -->
                            @if($tarifa->condiciones)
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">Detalles</p>
                                    <p class="text-xs text-gray-700 dark:text-gray-300 line-clamp-2">{{ $tarifa->condiciones }}</p>
                                </div>
                            @endif

                            <!-- Botón Acción -->
                            @if($tarifa->url_oferta_externa)
                                <a href="{{ $tarifa->url_oferta_externa }}" target="_blank" rel="noopener"
                                   class="w-full py-2.5 rounded-lg font-semibold transition text-center block {{ $esMasBarata ? 'bg-green-600 hover:bg-green-700 text-white shadow-lg hover:shadow-xl' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg' }}">
                                    <i class="bi bi-box-arrow-out-right me-2"></i>Ver Oferta {{ $esMasBarata ? '⭐' : '' }}
                                </a>
                            @else
                                <button disabled class="w-full py-2.5 rounded-lg font-semibold bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                                    No disponible
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- Estado Vacío -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-12 text-center">
                <i class="bi bi-inbox text-6xl text-gray-300 dark:text-gray-600 block mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sin tarifas para comparar</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Realiza una búsqueda para comparar opciones</p>
                <a href="{{ route('search') }}" class="inline-block px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                    <i class="bi bi-search me-2"></i>Ir a Búsqueda
                </a>
            </div>
        @endif
    </div>

    <!-- Sección para No Autenticados -->
    @guest
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 border-2 border-amber-300 dark:border-amber-700 rounded-lg p-8 text-center">
            <i class="bi bi-lock-fill text-4xl text-amber-600 dark:text-amber-400 block mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                Acceso Restringido
            </h3>
            <p class="text-gray-700 dark:text-gray-300 mb-6">
                Para guardar tus comparaciones o acceder al historial, debes iniciar sesión o registrarte
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition shadow-md hover:shadow-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition shadow-md hover:shadow-lg">
                    <i class="bi bi-person-plus me-2"></i>Registrarse Gratis
                </a>
            </div>
        </div>
    @endauth



<!-- Modal guardar comparación -->
@auth
    <div id="saveModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">
                    <i class="bi bi-bookmark-fill me-2"></i>Guardar Comparación
                </h3>
            </div>
            <form id="saveComparisonForm" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nombre descriptivo
                    </label>
                    <input type="text" id="nombre" name="nombre" required
                           placeholder="ej: Comparación Mudanza Abril 2026"
                           class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 font-medium">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition shadow-md">
                        <i class="bi bi-check-lg me-2"></i>Guardar
                    </button>
                    <button type="button" onclick="closeSaveModal()" class="flex-1 px-4 py-2.5 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold hover:bg-gray-400 transition">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endauth

@endsection

@section('scripts')
@auth
<script>
let currentComparacionId = null;

function saveComparison() {
    document.getElementById('saveModal').classList.remove('hidden');
}

function closeSaveModal() {
    document.getElementById('saveModal').classList.add('hidden');
}

document.getElementById('saveComparisonForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const nombre = document.getElementById('nombre').value;
    const comparacionId = {{ $comparacion_id ?? 'null' }};

    if (!comparacionId) {
        alert('Error: Identificador de comparación no disponible');
        return;
    }

    try {
        const response = await axios.post('@json(route("comparison.save"))', {
            comparacion_id: comparacionId,
            nombre: nombre,
        });

        if (response.data.success) {
            alert('Comparación guardada exitosamente');
            closeSaveModal();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar la comparación');
    }
});
</script>
@endauth
@endsection
