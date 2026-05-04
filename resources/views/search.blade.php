@extends('layouts.app')

@section('title', 'Búsqueda - EasyMove')

@section('content')
<style>
    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideInScale {
        animation: slideInScale 0.4s ease-out forwards;
    }

    @keyframes slideInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .chip {
        padding: 0.5rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 9999px;
        background-color: white;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        color: #4b5563;
    }

    .dark .chip {
        background-color: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }

    .chip:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    .dark .chip:hover {
        background-color: #1f2937;
        border-color: #60a5fa;
    }

    .chip.active {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .dark .chip.active {
        background-color: #3b82f6;
        border-color: #60a5fa;
        color: white;
    }
</style>

<div class="space-y-8 p-4 md:p-8">
    <!-- FORMULARIO DE BÚSQUEDA MEJORADO -->
    <div class="bg-gradient-to-br from-white via-gray-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-2">
                🔍 Buscar Servicios
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Encuentra las mejores tarifas de luz, gas y telefonía en tu zona</p>
        </div>

        <form id="searchForm" class="space-y-6">
            @csrf

            <!-- Fila Principal: Tipo Servicio, Código Postal, Botón -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <!-- Tipo de Servicio -->
                <div>
                    <label for="id_tipo_servicio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-list-check me-2"></i>Tipo de Servicio
                    </label>
                    <select id="id_tipo_servicio" name="id_tipo_servicio" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                        <option value="">-- Seleccionar --</option>
                        @foreach ($tiposServicios as $tipo)
                            <option value="{{ $tipo->id_tipo_servicio }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Código Postal -->
                <div>
                    <label for="codigo_postal" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-geo-alt me-2"></i>Código Postal
                    </label>
                    <select id="codigo_postal" name="codigo_postal" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                        <option value="">-- Seleccionar --</option>
                        @foreach ($codigosPostales as $codigo)
                            <option value="{{ $codigo }}">{{ $codigo }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón Buscar -->
                <div>
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-primary-600 via-primary-500 to-primary-700 hover:from-primary-700 hover:via-primary-600 hover:to-primary-800 text-white font-bold rounded-lg transition transform hover:scale-105 active:scale-95 shadow-lg flex items-center justify-center gap-2">
                        <i class="bi bi-search text-lg"></i>
                        Buscar Tarifas
                    </button>
                </div>
            </div>

            <!-- FILTROS AVANZADOS -->
            @auth
                <button type="button" id="toggleFiltersBtn" onclick="toggleAdvancedFilters()"
                        class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold flex items-center gap-2 text-sm transition">
                    <i class="bi bi-sliders me-1"></i>
                    <span id="filterToggleText">Mostrar Filtros Avanzados</span>
                </button>

                <div id="advancedFilters" class="hidden pt-8 border-t border-gray-300 dark:border-gray-700 space-y-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="bi bi-funnel-fill text-primary-600"></i>Filtros Avanzados
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Rango de Precios -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                                <i class="bi bi-currency-euro me-2"></i>Rango de Precio (€/mes)
                            </label>
                            <div class="flex items-center gap-4">
                                <input type="number" id="min_precio" name="min_precio" step="0.01" min="0" placeholder="Min"
                                   class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-600">
                                <span class="text-gray-500 dark:text-gray-400 font-bold">—</span>
                                <input type="number" id="max_precio" name="max_precio" step="0.01" min="0" placeholder="Max"
                                       class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-600">
                            </div>
                        </div>

                        <!-- Ordenamiento -->
                        <div>
                            <label for="ordenar_por" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="bi bi-sort-down me-2"></i>Ordenar Por
                            </label>
                            <select id="ordenar_por" name="ordenar_por"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-600">
                                <option value="precio_asc">💰 Precio: Menor a Mayor</option>
                                <option value="precio_desc">💰 Precio: Mayor a Menor</option>
                                <option value="reciente">🆕 Más Reciente</option>
                                <option value="nombre_asc">🔤 Alfabético (A-Z)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Permanencia con Chips -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                            <i class="bi bi-calendar-check me-2"></i>Permanencia
                        </label>
                        <div class="flex flex-wrap gap-3">
                            <button type="button" class="chip" onclick="toggleChip(this, 'sin_permanencia')">Sin permanencia</button>
                            <button type="button" class="chip" onclick="toggleChip(this, '1mes')">1 Mes</button>
                            <button type="button" class="chip" onclick="toggleChip(this, '3meses')">3 Meses</button>
                            <button type="button" class="chip" onclick="toggleChip(this, '6meses')">6 Meses</button>
                            <button type="button" class="chip" onclick="toggleChip(this, '12meses')">12 Meses</button>
                        </div>
                    </div>

                    <!-- Búsqueda por Nombre -->
                    <div>
                        <label for="buscar_nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="bi bi-search me-2"></i>Buscar Tarifa
                        </label>
                        <input type="text" id="buscar_nombre" name="buscar_nombre" placeholder="Ej: Plan Premium, Básico, Eco..."
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-600">
                    </div>

                    <!-- Botones de Filtros -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" id="applyFiltersBtn" class="flex-1 px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                            <i class="bi bi-check-lg"></i>Aplicar Filtros
                        </button>
                        <button type="button" id="clearFiltersBtn" class="flex-1 px-6 py-2 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-white font-bold rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 transition flex items-center justify-center gap-2">
                            <i class="bi bi-arrow-counterclockwise"></i>Limpiar
                        </button>
                    </div>
                </div>
            @endauth
        </form>

        <!-- INFO USUARIOS ANÓNIMOS -->
        @guest
            <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-950 dark:to-cyan-950 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-sm text-blue-800 dark:text-blue-300 flex items-start gap-3">
                    <i class="bi bi-info-circle mt-0.5 flex-shrink-0 text-lg"></i>
                    <span>
                        <strong>Nota:</strong> Como usuario anónimo solo ves 2 resultados.
                        <a href="{{ route('login') }}" class="underline font-bold hover:text-blue-900 dark:hover:text-blue-100">Inicia sesión</a> para ver todas las opciones.
                    </span>
                </p>
            </div>
        @endguest
    </div>

    <!-- ESTADO VACÍO / PLACEHOLDER -->
    <div id="emptyState" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-20 text-center border border-gray-200 dark:border-gray-700">
        <i class="bi bi-search block text-8xl mb-6 opacity-20 text-gray-400 dark:text-gray-600"></i>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Comienza tu búsqueda</h2>
        <p class="text-gray-600 dark:text-gray-300 text-lg max-w-xl mx-auto leading-relaxed">
            Selecciona un tipo de servicio y código postal para encontrar las mejores tarifas disponibles en tu zona. Compara precios, permanências y beneficios.
        </p>
    </div>

    <!-- CONTENEDOR DE RESULTADOS -->
    <div id="resultsSection" class="hidden">
        <!-- Barra de Info Sticky -->
        <div class="sticky top-0 z-20 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 p-4 rounded-t-xl shadow-sm">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div class="flex items-center gap-3">
                    <i class="bi bi-lightning-fill text-yellow-500 text-2xl animate-pulse"></i>
                    <span id="resultsCount" class="text-sm font-bold text-gray-700 dark:text-gray-200">
                        Cargando resultados...
                    </span>
                </div>
                <button onclick="document.getElementById('advancedFilters').classList.toggle('hidden')"
                        class="text-xs px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition font-semibold text-gray-700 dark:text-white">
                    <i class="bi bi-sliders me-1"></i>Filtros
                </button>
            </div>
        </div>

        <!-- GRID DE RESULTADOS RESPONSIVO -->
        <div id="resultsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
            <!-- Cards generadas por JavaScript -->
        </div>
    </div>

    <!-- MODAL DE COMPARATIVA -->
    @if (auth()->check())
        <div id="comparisonModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-md flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto animate-slideInScale">
                <div class="sticky top-0 p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="bi bi-bar-chart-fill text-primary-600"></i>Detalles de Comparativa
                    </h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-3xl">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div id="modalContent" class="p-6 space-y-4">
                    <!-- Contenido cargado vía AJAX -->
                </div>
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                    <button onclick="exportPdf()" class="flex-1 px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition font-bold flex items-center justify-center gap-2">
                        <i class="bi bi-file-pdf"></i>Descargar PDF
                    </button>
                    <button onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-bold">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
// Inicializar Tom Select
new TomSelect('#codigo_postal', {
    create: false,
    placeholder: 'Buscar código postal...',
    searchField: ['text', 'value'],
    maxOptions: 100,
});

const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
const searchUrl = @json(route('search'));
const exportPdfUrl = @json(route('export-pdf'));
const comparisonUrlTemplate = @json(url('/comparacion/__ID__'));
let currentComparacionId = null;
let selectedChips = new Set();

// Mapeo color-proveedor
const providerColors = {
    'Endesa': 'endesa',
    'Iberdrola': 'iberdrola',
    'EDF': 'edf',
    'Naturgy': 'naturgy',
    'Telefónica': 'telefonica',
    'Vodafone': 'vodafone',
};

function toggleAdvancedFilters() {
    const filters = document.getElementById('advancedFilters');
    const toggleText = document.getElementById('filterToggleText');
    filters.classList.toggle('hidden');
    toggleText.textContent = filters.classList.contains('hidden')
        ? 'Mostrar Filtros Avanzados'
        : 'Ocultar Filtros Avanzados';
}

function toggleChip(button, value) {
    button.classList.toggle('active');
    if (selectedChips.has(value)) {
        selectedChips.delete(value);
    } else {
        selectedChips.add(value);
    }
}

function resetFilters() {
    document.getElementById('min_precio').value = '';
    document.getElementById('max_precio').value = '';
    document.getElementById('buscar_nombre').value = '';
    document.getElementById('ordenar_por').value = 'precio_asc';
    document.querySelectorAll('.chip').forEach(chip => chip.classList.remove('active'));
    selectedChips.clear();
}

// Agregar listener al botón "Limpiar"
const clearFiltersBtn = document.getElementById('clearFiltersBtn');
if (clearFiltersBtn) {
    clearFiltersBtn.addEventListener('click', function(e) {
        e.preventDefault();
        resetFilters();
    });
}

// Generar badge dinámico
function generateBadge(tarifa, index) {
    if (tarifa.condiciones && tarifa.condiciones.toLowerCase().includes('renovable')) {
        return '<span class="badge-eco"><i class="bi bi-leaf me-1"></i>Eco-Friendly</span>';
    }
    if (index === 0) {
        return '<span class="badge-bestseller"><i class="bi bi-star-fill me-1"></i>Top Precio</span>';
    }
    if (!tarifa.permanencia || tarifa.permanencia === 'Sin permanencia') {
        return '<span class="badge-sin-permanencia"><i class="bi bi-unlock me-1"></i>Sin permanencia</span>';
    }
    return '';
}

// Generar beneficios
function generateBenefits(tarifa) {
    const benefits = [];

    if (tarifa.permanencia) {
        benefits.push(`
            <div class="benefit-item permanencia">
                <i class="bi bi-calendar-check"></i>
                <span>${tarifa.permanencia}</span>
            </div>
        `);
    }

    if (tarifa.unidad_precio) {
        const unidadIcon = tarifa.unidad_precio.includes('Mbps') ? 'zap' :
                          tarifa.unidad_precio.includes('GB') ? 'cloud-download' : 'graph-up';
        benefits.push(`
            <div class="benefit-item unidad">
                <i class="bi bi-${unidadIcon}"></i>
                <span>${tarifa.unidad_precio}</span>
            </div>
        `);
    }

    if (tarifa.condiciones) {
        const isEco = tarifa.condiciones.toLowerCase().includes('renovable');
        const icon = isEco ? 'leaf' : 'info-circle';
        const clase = isEco ? 'eco' : '';
        benefits.push(`
            <div class="benefit-item ${clase}">
                <i class="bi bi-${icon}"></i>
                <span class="text-xs">${tarifa.condiciones.substring(0, 40)}...</span>
            </div>
        `);
    }

    return benefits.slice(0, 3).join('');
}

document.getElementById('searchForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const tipoServicio = document.getElementById('id_tipo_servicio').value;
    const codigoPostal = document.getElementById('codigo_postal').value;

    if (!tipoServicio || !codigoPostal) {
        alert('Por favor completa los campos requeridos');
        return;
    }

    const emptyState = document.getElementById('emptyState');
    const resultsSection = document.getElementById('resultsSection');
    const resultsGrid = document.getElementById('resultsGrid');

    emptyState.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block mb-6">
                <div class="spinner-modern"></div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 font-semibold text-lg">Buscando mejores tarifas...</p>
            <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">Esto puede tomar unos segundos</p>
        </div>
    `;

    try {
        const formData = new FormData(document.getElementById('searchForm'));

        // Construir objeto de filtros - solo incluir valores que no estén vacíos
        const filters = {
            codigo_postal: codigoPostal,
            id_tipo_servicio: tipoServicio,
        };

        const minPrecio = document.getElementById('min_precio')?.value;
        if (minPrecio) filters.min_precio = minPrecio;

        const maxPrecio = document.getElementById('max_precio')?.value;
        if (maxPrecio) filters.max_precio = maxPrecio;

        const ordenarPor = document.getElementById('ordenar_por')?.value;
        if (ordenarPor) filters.ordenar_por = ordenarPor;

        const buscarNombre = document.getElementById('buscar_nombre')?.value;
        if (buscarNombre) filters.buscar_nombre = buscarNombre;

        if (selectedChips.size > 0) filters.permanencia = Array.from(selectedChips);

        const response = await axios.post(searchUrl, filters);

        const result = response.data?.data || response.data;
        const tarifas = result?.tarifas || [];
        const meta = result?.meta || {};

        if (tarifas.length === 0) {
            // Ocultar sección de resultados anteriores
            resultsSection.classList.add('hidden');
            // Mostrar estado vacío con mensaje
            emptyState.classList.remove('hidden');
            emptyState.innerHTML = `
                <div class="text-center py-12">
                    <i class="bi bi-inbox block text-8xl opacity-30 text-gray-400 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No hay tarifas disponibles</h3>
                    <p class="text-gray-600 dark:text-gray-400">No encontramos tarifas para este tipo de servicio y código postal. Intenta con otros filtros.</p>
                </div>
            `;
            return;
        }

        emptyState.classList.add('hidden');
        resultsSection.classList.remove('hidden');
        document.getElementById('resultsCount').innerHTML = `
            <i class="bi bi-lightning-fill text-yellow-500 me-2 animate-pulse"></i>
            ${tarifas.length} tarifa${tarifas.length !== 1 ? 's' : ''} encontrada${tarifas.length !== 1 ? 's' : ''}
        `;

        resultsGrid.innerHTML = tarifas.map((tarifa, idx) => {
            const borderColor = {'Endesa': 'border-l-red-500', 'Iberdrola': 'border-l-blue-600', 'EDF': 'border-l-red-600', 'Naturgy': 'border-l-green-600', 'Telefónica': 'border-l-purple-600', 'Vodafone': 'border-l-red-700'}[tarifa.proveedor?.nombre] || 'border-l-gray-400';
            const mainFeature = tarifa.permanencia ? `📅 ${tarifa.permanencia}` : tarifa.unidad_precio ? `⚡ ${tarifa.unidad_precio}` : '';

            return `
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-all overflow-hidden border-l-4 ${borderColor} animate-fadeInUp flex flex-col" style="animation-delay: ${idx * 0.05}s">

                    <!-- Header -->
                    <div class="p-4 flex items-center gap-3 border-b border-gray-200 dark:border-gray-700">
                        ${tarifa.proveedor?.logo ?
                            `<img src="${tarifa.proveedor.logo}" alt="${tarifa.proveedor.nombre}" class="w-12 h-12 rounded-md object-cover flex-shrink-0">`
                            : '<div class="w-12 h-12 rounded-md bg-gray-300 dark:bg-gray-600 flex-shrink-0"></div>'
                        }
                        <div class="flex-grow min-w-0">
                            <div class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">${tarifa.proveedor?.nombre ?? 'Proveedor'}</div>
                            <div class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">${tarifa.nombre_tarifa}</div>
                        </div>
                    </div>

                    <!-- Precio Grande y Destacado -->
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-950 dark:to-purple-950 border-b border-gray-200 dark:border-gray-700">
                        <div class="text-4xl font-black text-blue-600 dark:text-blue-300 leading-tight">€${parseFloat(tarifa.precio).toFixed(2)}</div>
                        <div class="text-sm font-semibold text-blue-600 dark:text-blue-400 mt-1">/${tarifa.unidad_precio || 'mes'}</div>
                    </div>

                    <!-- Dato Clave -->
                    ${mainFeature ? `<div class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 line-clamp-1">${mainFeature}</div>` : ''}

                    <!-- Botones Grandes y Visuales -->
                    <div class="p-4 flex flex-col gap-2 mt-auto">
                        ${isAuthenticated ? `
                            <button onclick="viewComparison(${result.comparacion_id}, ${JSON.stringify(tarifa).split('"').join('&quot;')})" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg transition-all flex items-center justify-center gap-2 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                                <i class="bi bi-eye-fill text-lg"></i><span>Ver Detalles</span>
                            </button>
                        ` : ''}
                        ${tarifa.url_oferta_externa ? `
                            <a href="${tarifa.url_oferta_externa}" target="_blank" rel="noopener" class="w-full py-3 px-4 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-lg transition-all flex items-center justify-center gap-2 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                                <i class="bi bi-box-arrow-up-right text-lg"></i><span>Ver Oferta</span>
                            </a>
                        ` : ''}
                    </div>
                </div>
            `;
        }).join('');

    } catch (error) {
        console.error('Error:', error);
        resultsSection.classList.add('hidden');
        emptyState.classList.remove('hidden');
        emptyState.innerHTML = `
            <div class="text-center py-12 bg-red-50 dark:bg-red-950 rounded-xl border border-red-200 dark:border-red-800">
                <i class="bi bi-exclamation-triangle block text-8xl opacity-30 text-red-400 mb-6"></i>
                <h3 class="text-2xl font-bold text-red-700 dark:text-red-300 mb-2">Error en la búsqueda</h3>
                <p class="text-red-600 dark:text-red-400">Por favor intenta de nuevo más tarde</p>
            </div>
        `;
    }
});

function closeModal() {
    document.getElementById('comparisonModal').classList.add('hidden');
}

async function viewComparison(comparacionId, tarifaData) {
    if (!isAuthenticated) return;

    try {
        currentComparacionId = comparacionId;

        const html = `
            <div class="space-y-4">
                <!-- Info Principal -->
                <div class="p-4 bg-gradient-to-r from-primary-50 to-blue-50 dark:from-primary-900 dark:to-blue-900 rounded-lg border-2 border-primary-200 dark:border-primary-700">
                    <div class="flex items-start gap-3 mb-3">
                        ${tarifaData.proveedor?.logo ? `<img src="${tarifaData.proveedor.logo}" alt="" class="w-12 h-12 rounded-lg object-cover">` : ''}
                        <div class="flex-grow">
                            <p class="text-xs text-primary-700 dark:text-primary-300 font-bold uppercase">Proveedor</p>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white">${tarifaData.proveedor?.nombre ?? 'Proveedor'}</h3>
                            <p class="text-sm text-gray-700 dark:text-gray-300">${tarifaData.nombre_tarifa}</p>
                        </div>
                    </div>

                    <div class="border-t border-primary-200 dark:border-primary-700 pt-3 mt-3">
                        <p class="text-xs text-primary-700 dark:text-primary-300 font-bold mb-1">PRECIO MENSUAL</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-black text-primary-600 dark:text-primary-300">€${parseFloat(tarifaData.precio).toFixed(2)}</span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">/${tarifaData.unidad_precio || 'mes'}</span>
                        </div>
                    </div>
                </div>

                <!-- Detalles en Grid -->
                <div class="grid grid-cols-2 gap-3">
                    ${tarifaData.permanencia ? `
                        <div class="p-3 bg-blue-50 dark:bg-blue-950 rounded-lg border border-blue-200 dark:border-blue-800">
                            <p class="text-xs text-blue-700 dark:text-blue-300 font-bold mb-1">📅 PERMANENCIA</p>
                            <p class="text-base font-bold text-blue-900 dark:text-blue-100">${tarifaData.permanencia}</p>
                        </div>
                    ` : ''}
                    ${tarifaData.unidad_precio ? `
                        <div class="p-3 bg-purple-50 dark:bg-purple-950 rounded-lg border border-purple-200 dark:border-purple-800">
                            <p class="text-xs text-purple-700 dark:text-purple-300 font-bold mb-1">⚡ VELOCIDAD</p>
                            <p class="text-base font-bold text-purple-900 dark:text-purple-100">${tarifaData.unidad_precio}</p>
                        </div>
                    ` : ''}
                </div>

                <!-- Características -->
                ${tarifaData.condiciones ? `
                    <div class="p-3 bg-green-50 dark:bg-green-950 rounded-lg border border-green-200 dark:border-green-800">
                        <p class="text-xs text-green-700 dark:text-green-300 font-bold mb-1">✓ CARACTERÍSTICAS</p>
                        <p class="text-sm text-green-900 dark:text-green-100">${tarifaData.condiciones}</p>
                    </div>
                ` : ''}

                <!-- Tipo Servicio -->
                ${tarifaData.servicio?.nombre_servicio ? `
                    <div class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-700 dark:text-gray-300 font-bold mb-1">📋 TIPO DE SERVICIO</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">${tarifaData.servicio.nombre_servicio}</p>
                    </div>
                ` : ''}
            </div>
        `;

        document.getElementById('modalContent').innerHTML = html;
        document.getElementById('comparisonModal').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los detalles');
    }
}

async function exportPdf() {
    if (!currentComparacionId) return;

    try {
        const response = await axios.post(exportPdfUrl, {
            comparacion_id: currentComparacionId,
        }, {
            responseType: 'blob',
        });

        const url = window.URL.createObjectURL(response.data);
        const a = document.createElement('a');
        a.href = url;
        a.download = `comparativa-${currentComparacionId}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    } catch (error) {
        console.error('Error:', error);
        alert('Error al descargar PDF');
    }
}
</script>
@endsection
