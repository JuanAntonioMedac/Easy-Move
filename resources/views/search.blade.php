@extends('layouts.app')

@section('title', 'Búsqueda - EasyMove')

@section('content')
<div class="space-y-8">
    <!-- Formulario de Búsqueda -->
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 border border-gray-200 dark:border-slate-800">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Buscar Servicios</h2>
        
        <form id="searchForm" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            @csrf
            
            <!-- Tipo de Servicio -->
            <div>
                <label for="id_tipo_servicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="bi bi-list-check me-2"></i>Tipo de Servicio
                </label>
                <select id="id_tipo_servicio" name="id_tipo_servicio" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
                    <option value="">-- Seleccionar --</option>
                    @foreach ($tiposServicios as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Código Postal -->
            <div>
                <label for="codigo_postal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="bi bi-geo-alt me-2"></i>Código Postal
                </label>
                <select id="codigo_postal" name="codigo_postal" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600" placeholder="Buscar código postal...">
                    <option value="">-- Seleccionar código postal --</option>
                    @foreach ($codigosPostales as $codigo)
                        <option value="{{ $codigo }}">{{ $codigo }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botón Buscar -->
            <div>
                <button type="submit" class="w-full px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="bi bi-search"></i>
                    Buscar
                </button>
            </div>
        </form>

        <!-- Mensaje Info para No Autenticados -->
        @guest
            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-sm text-blue-800 dark:text-blue-300 flex items-start gap-2">
                    <i class="bi bi-info-circle mt-0.5 flex-shrink-0"></i>
                    <span>
                        <strong>Nota:</strong> Eres usuario anónimo. Solo verás los 2 mejores resultados. 
                        <a href="{{ route('login') }}" class="underline font-medium hover:text-blue-900 dark:hover:text-blue-200">Inicia sesión</a> para ver todas las opciones.
                    </span>
                </p>
            </div>
        @endguest
    </div>

    <!-- Resultados -->
    <div id="resultsContainer" class="space-y-4">
        <!-- Los resultados se cargarán aquí via AJAX -->
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-12 text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-slate-800">
            <i class="bi bi-search block text-4xl mb-4 opacity-50"></i>
            <p>Realiza una búsqueda para ver los resultados disponibles</p>
        </div>
    </div>

    <!-- Modal de Comparativa (Solo para autenticados) -->
    @if (auth()->check())
        <div id="comparisonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-slate-900 rounded-lg shadow-2xl max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
                <div class="p-6 sticky top-0 bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detalles de Comparativa</h3>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>
                </div>
                <div id="modalContent" class="p-6">
                    <!-- Content loaded via AJAX -->
                </div>
                <div class="p-6 border-t border-gray-200 dark:border-slate-800 flex gap-3">
                    <button onclick="exportPdf()" class="flex-1 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                        <i class="bi bi-file-pdf"></i>
                        Descargar PDF
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 bg-gray-300 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg transition">
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
// Inicializar Tom Select para código postal
new TomSelect('#codigo_postal', {
    create: false,
    placeholder: 'Buscar código postal...',
    searchField: ['text', 'value'],
    maxOptions: 100,
});

const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
let currentComparacionId = null;

document.getElementById('searchForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(document.getElementById('searchForm'));
    const resultsContainer = document.getElementById('resultsContainer');
    
    try {
        resultsContainer.innerHTML = `
            <div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-slate-800">
                <div class="inline-block">
                    <div class="animate-spin inline-block w-8 h-8 border-4 border-gray-300 dark:border-slate-700 border-t-primary-600 rounded-full"></div>
                </div>
                <p class="mt-4">Buscando...</p>
            </div>
        `;
        
        const response = await axios.post('/search', {
            codigo_postal: formData.get('codigo_postal'),
            id_tipo_servicio: formData.get('id_tipo_servicio'),
        });

        const { tarifas } = response.data;
        
        if (tarifas.length === 0) {
            resultsContainer.innerHTML = `
                <div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-12 text-center border border-gray-200 dark:border-slate-800">
                    <i class="bi bi-inbox block text-4xl text-gray-400 dark:text-gray-600 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400">No se encontraron resultados</p>
                </div>
            `;
            return;
        }

        resultsContainer.innerHTML = tarifas.map(tarifa => `
            <div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-6 hover:shadow-lg transition border border-gray-200 dark:border-slate-800">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">${tarifa.proveedor.nombre}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${tarifa.servicio.nombre}</p>
                    </div>
                    <span class="text-3xl font-bold text-primary-600 ml-4">$${parseFloat(tarifa.precio).toFixed(2)}</span>
                </div>
                
                <div class="space-y-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <p><i class="bi bi-geo-alt me-2"></i><strong>Ubicación:</strong> ${tarifa.ubicacion.nombre}</p>
                    <p><i class="bi bi-clock me-2"></i><strong>Tiempo:</strong> ${tarifa.tiempo_estimado} min</p>
                    <p><i class="bi bi-star me-2"></i><strong>Calificación:</strong> ${tarifa.calificacion || 'N/A'}</p>
                </div>

                ${isAuthenticated ? `
                    <button onclick="viewComparison(${tarifa.comparacion_id})" class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition flex items-center justify-center gap-2">
                        <i class="bi bi-eye"></i>
                        Ver Detalles
                    </button>
                ` : ''}
            </div>
        `).join('');
    } catch (error) {
        console.error('Error:', error);
        resultsContainer.innerHTML = `
            <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-lg p-6">
                <p class="text-red-700 dark:text-red-300 flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    Error al buscar. Por favor intenta de nuevo.
                </p>
            </div>
        `;
    }
});

function closeModal() {
    document.getElementById('comparisonModal').classList.add('hidden');
}

async function viewComparison(comparacionId) {
    if (!isAuthenticated) return;
    
    try {
        currentComparacionId = comparacionId;
        const response = await axios.get(`/comparacion/${comparacionId}`);
        
        const html = `
            <div class="space-y-4">
                ${response.data.tarifas.map(t => `
                    <div class="border-b border-gray-200 dark:border-slate-700 pb-4 last:border-0">
                        <h4 class="font-semibold text-gray-900 dark:text-white">${t.proveedor.nombre}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${t.servicio.nombre}</p>
                        <p class="text-lg font-bold text-primary-600 mt-2">$${parseFloat(t.precio).toFixed(2)}</p>
                    </div>
                `).join('')}
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
        const response = await axios.post('/export-pdf', {
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
