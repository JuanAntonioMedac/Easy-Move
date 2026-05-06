@extends('layouts.app')

@section('title', 'Comparación · EasyMove')

@section('content')
<div class="space-y-8">

    {{-- ============== HERO HEADER ============== --}}
    <div class="relative overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-700 p-6 sm:p-10 bg-gradient-to-br from-sky-500 via-indigo-600 to-purple-600 text-white shadow-xl shadow-indigo-500/20">
        <div class="bg-blob w-[420px] h-[420px] -top-24 -right-24 bg-white/40"></div>
        <div class="bg-blob w-[320px] h-[320px] -bottom-24 -left-24 bg-white/30" style="animation-delay: -8s;"></div>

        <div class="relative flex flex-col sm:flex-row justify-between items-start gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur border border-white/30 mb-4">
                    <i class="bi bi-bar-chart-fill"></i> Comparativa
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">Tu comparación de tarifas</h1>
                <p class="mt-2 text-white/90 text-base sm:text-lg max-w-2xl">Compara las mejores opciones lado a lado y elige la que más te conviene.</p>
            </div>
            @auth
                <div class="flex flex-wrap gap-2 flex-shrink-0">
                    <button onclick="saveComparison()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-indigo-700 font-bold shadow-md hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        <i class="bi bi-bookmark-fill"></i><span>Guardar</span>
                    </button>
                    <a href="{{ route('comparison.history') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/15 backdrop-blur border border-white/30 text-white font-bold hover:bg-white/25 transition-all">
                        <i class="bi bi-clock-history"></i><span>Historial</span>
                    </a>
                </div>
            @endauth
        </div>
    </div>

    @include('shared.alerts')

    @if(isset($tarifas) && count($tarifas) > 0)
        @php
            $minPrecio = $tarifas->min('precio');
            $maxPrecio = $tarifas->max('precio');
            $ahorro = $maxPrecio - $minPrecio;
        @endphp

        {{-- ============== INSIGHT BAR ============== --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-emerald-200 dark:border-emerald-900 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/40 dark:to-teal-950/40 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl grid place-items-center bg-emerald-500 text-white shadow-md shadow-emerald-500/30">
                        <i class="bi bi-trophy-fill text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-300">Mejor precio</p>
                        <p class="text-2xl font-extrabold text-emerald-900 dark:text-emerald-100">{{ number_format($minPrecio, 2, ',', '.') }}€</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-sky-200 dark:border-sky-900 bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-sky-950/40 dark:to-indigo-950/40 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl grid place-items-center bg-sky-500 text-white shadow-md shadow-sky-500/30">
                        <i class="bi bi-piggy-bank-fill text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-sky-700 dark:text-sky-300">Ahorro potencial</p>
                        <p class="text-2xl font-extrabold text-sky-900 dark:text-sky-100">{{ number_format($ahorro, 2, ',', '.') }}€</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-purple-200 dark:border-purple-900 bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-950/40 dark:to-pink-950/40 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl grid place-items-center bg-purple-500 text-white shadow-md shadow-purple-500/30">
                        <i class="bi bi-stack text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-purple-700 dark:text-purple-300">Tarifas comparadas</p>
                        <p class="text-2xl font-extrabold text-purple-900 dark:text-purple-100">{{ count($tarifas) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============== TARIFAS GRID ============== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($tarifas as $i => $tarifa)
                @php
                    $esMasBarata = $tarifa->precio == $minPrecio;
                    $diferencia = $tarifa->precio - $minPrecio;
                @endphp

                <div class="relative rounded-2xl overflow-hidden bg-white dark:bg-slate-900 border {{ $esMasBarata ? 'border-emerald-400 dark:border-emerald-600 shadow-2xl shadow-emerald-500/20 ring-2 ring-emerald-400/40' : 'border-slate-200 dark:border-slate-800 shadow-sm' }} hover:shadow-xl hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ $i * 0.05 }}s">

                    @if($esMasBarata)
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-4 py-2 text-center font-bold text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                            <i class="bi bi-star-fill"></i> Mejor oferta
                        </div>
                    @else
                        <div class="h-1.5 bg-gradient-to-r from-slate-300 to-slate-400 dark:from-slate-700 dark:to-slate-600"></div>
                    @endif

                    <div class="p-5 space-y-4">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                            @if($tarifa->servicio->proveedor->logo)
                                <img src="{{ Storage::url($tarifa->servicio->proveedor->logo) }}" alt="{{ $tarifa->servicio->proveedor->nombre }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 grid place-items-center text-white font-bold">
                                    {{ substr($tarifa->servicio->proveedor->nombre, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 dark:text-white truncate">{{ $tarifa->servicio->proveedor->nombre }}</p>
                                <p class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">{{ $tarifa->servicio->nombre_servicio }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Plan</p>
                            <p class="font-bold text-slate-900 dark:text-white truncate">{{ $tarifa->nombre_tarifa }}</p>
                        </div>

                        <div class="rounded-xl p-4 {{ $esMasBarata ? 'bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/40 dark:to-teal-950/40 border border-emerald-100 dark:border-emerald-900' : 'bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700' }}">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Precio</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black {{ $esMasBarata ? 'text-emerald-600 dark:text-emerald-400' : 'gradient-text' }}">
                                    {{ number_format($tarifa->precio, 2, ',', '.') }}€
                                </span>
                                <span class="text-sm text-slate-600 dark:text-slate-400">/ {{ $tarifa->unidad_precio }}</span>
                            </div>
                            @if(!$esMasBarata && $diferencia > 0)
                                <p class="text-xs text-rose-600 dark:text-rose-400 mt-2 font-semibold">
                                    <i class="bi bi-arrow-up"></i> +{{ number_format($diferencia, 2, ',', '.') }}€ vs. mejor opción
                                </p>
                            @endif
                        </div>

                        @if($tarifa->permanencia)
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300">
                                    <i class="bi bi-calendar-check"></i> {{ $tarifa->permanencia }}
                                </span>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300">
                                    <i class="bi bi-unlock-fill"></i> Sin permanencia
                                </span>
                            </div>
                        @endif

                        @if($tarifa->condiciones)
                            <div class="rounded-xl p-3 bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1"><i class="bi bi-info-circle"></i> Detalles</p>
                                <p class="text-xs text-slate-700 dark:text-slate-300 line-clamp-2">{{ $tarifa->condiciones }}</p>
                            </div>
                        @endif

                        <div class="space-y-2 pt-2">
                            @if($tarifa->url_oferta_externa)
                                <a href="{{ $tarifa->url_oferta_externa }}" target="_blank" rel="noopener"
                                   class="w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-all hover:-translate-y-0.5 {{ $esMasBarata ? 'bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white shadow-lg shadow-emerald-500/30' : 'btn-brand text-white' }}">
                                    <i class="bi bi-box-arrow-up-right"></i>Ver oferta
                                </a>
                            @else
                                <button disabled class="w-full py-3 rounded-xl font-bold text-sm bg-slate-200 dark:bg-slate-800 text-slate-400 cursor-not-allowed">
                                    No disponible
                                </button>
                            @endif

                            @auth
                                <div class="flex gap-2">
                                    <button onclick="downloadTarifaPDF({{ $comparacion_id }}, {{ $tarifa->id_tarifa }})"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl font-semibold text-xs bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition">
                                        <i class="bi bi-file-earmark-pdf"></i><span>PDF</span>
                                    </button>
                                    <button onclick="downloadTodasPDF({{ $comparacion_id }})"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl font-semibold text-xs bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition">
                                        <i class="bi bi-files"></i><span>Todas</span>
                                    </button>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 bg-white/60 dark:bg-slate-900/40 p-16 text-center">
            <div class="w-16 h-16 mx-auto mb-5 rounded-2xl grid place-items-center bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 text-slate-500">
                <i class="bi bi-inbox text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Sin tarifas para comparar</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Realiza una búsqueda para empezar a comparar opciones.</p>
            <a href="{{ route('search') }}" class="btn-brand ring-brand inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-bold">
                <i class="bi bi-search"></i>Ir al buscador
            </a>
        </div>
    @endif

    {{-- ============== AVISO INVITADO ============== --}}
    @guest
        <div class="rounded-2xl border-2 border-dashed border-amber-300 dark:border-amber-800 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30 p-8 text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl grid place-items-center bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-500/30">
                <i class="bi bi-lock-fill text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Desbloquea todas las funciones</h3>
            <p class="text-slate-700 dark:text-slate-300 mb-6 max-w-md mx-auto">Crea una cuenta gratis para guardar tus comparativas, ver el historial y descargar PDFs.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-amber-400 dark:border-amber-700 bg-white dark:bg-slate-900 text-amber-700 dark:text-amber-300 font-bold hover:bg-amber-50 dark:hover:bg-slate-800 transition">
                    <i class="bi bi-box-arrow-in-right"></i>Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="btn-brand ring-brand inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-white font-bold">
                    <i class="bi bi-person-plus-fill"></i>Crear cuenta gratis
                </a>
            </div>
        </div>
    @endguest

    {{-- ============== MODAL GUARDAR ============== --}}
    @auth
        <div id="saveModal" class="hidden fixed inset-0 bg-slate-900/70 backdrop-blur-md flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-md w-full border border-slate-200 dark:border-slate-700 overflow-hidden animate-fade-in-up">
                <div class="bg-gradient-to-r from-sky-500 via-indigo-500 to-purple-500 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="bi bi-bookmark-fill"></i>Guardar comparación
                    </h3>
                </div>
                <form id="saveComparisonForm" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label for="nombre" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                            Nombre descriptivo
                        </label>
                        <input type="text" id="nombre" name="nombre" required
                               placeholder="Ej: Comparación luz hogar"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-brand ring-brand flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-bold">
                            <i class="bi bi-check-lg"></i>Guardar
                        </button>
                        <button type="button" onclick="closeSaveModal()" class="flex-1 px-4 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endauth
</div>
@endsection

@section('scripts')
@auth
<script>
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
        alert('Error: identificador de comparación no disponible');
        return;
    }

    try {
        const response = await axios.post(@json(route("comparison.save")), {
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

function submitPDFForm(comparacionId, tarifaId = null) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = @json(route("export-pdf"));
    form.style.display = 'none';

    const token = document.querySelector('meta[name="csrf-token"]').content;
    const inputs = [
        ['_token', token],
        ['comparacion_id', comparacionId],
    ];
    if (tarifaId) inputs.push(['tarifa_id', tarifaId]);

    inputs.forEach(([name, value]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function downloadTarifaPDF(comparacionId, tarifaId) { submitPDFForm(comparacionId, tarifaId); }
function downloadTodasPDF(comparacionId) { submitPDFForm(comparacionId); }
</script>
@endauth
@endsection
