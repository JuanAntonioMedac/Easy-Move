@extends('layouts.app')

@section('title', 'EasyMove · Encuentra tu mejor tarifa en segundos')

@section('main_class', 'w-full')

@section('content')
<style>
    .feature-card {
        position: relative;
        overflow: hidden;
        transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
    }
    .feature-card::before {
        content: "";
        position: absolute; inset: 0;
        background: radial-gradient(800px circle at var(--mx, 50%) var(--my, 50%), rgba(99,102,241,.12), transparent 40%);
        opacity: 0; transition: opacity .35s ease;
        pointer-events: none;
    }
    .feature-card:hover::before { opacity: 1; }
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 48px -20px rgba(15, 23, 42, .25);
    }
    .feature-icon {
        width: 56px; height: 56px;
        display: grid; place-items: center;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(14,165,233,.15), rgba(168,85,247,.15));
        color: #6366f1;
        font-size: 26px;
        position: relative;
        overflow: hidden;
    }
    .feature-icon::after {
        content: "";
        position: absolute; inset: 0;
        background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,.18));
    }
    html.dark .feature-icon { color: #a5b4fc; }

    .stat-num {
        font-variant-numeric: tabular-nums;
        font-feature-settings: 'tnum';
    }

    .marquee {
        mask-image: linear-gradient(90deg, transparent, black 10%, black 90%, transparent);
        -webkit-mask-image: linear-gradient(90deg, transparent, black 10%, black 90%, transparent);
    }
    .marquee-track {
        display: flex; gap: 4rem;
        animation: marquee 30s linear infinite;
        width: max-content;
    }
    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    .testimonial-card {
        position: relative;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .testimonial-card:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -16px rgba(15,23,42,.2); }

    .pulse-dot {
        position: relative; width: 8px; height: 8px; border-radius: 50%;
        background: #10b981;
    }
    .pulse-dot::after {
        content: ""; position: absolute; inset: -6px; border-radius: 50%;
        background: rgba(16,185,129,.4); animation: pulseRing 1.6s ease-out infinite;
    }
    @keyframes pulseRing { 0% { transform: scale(.5); opacity: 1; } 100% { transform: scale(1.6); opacity: 0; } }

    .hero-card-float { animation: cardFloat 6s ease-in-out infinite; }
    @keyframes cardFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    .grid-pattern {
        background-image:
            linear-gradient(to right, rgba(148,163,184,.18) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(148,163,184,.18) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
    }
</style>

{{-- ============================ HERO ============================ --}}
<section class="relative overflow-hidden">
    <div class="absolute inset-0 grid-pattern opacity-50 dark:opacity-30"></div>
    <div class="bg-blob w-[520px] h-[520px] -top-40 -left-32 bg-gradient-to-br from-sky-400 to-indigo-500"></div>
    <div class="bg-blob w-[420px] h-[420px] top-20 -right-20 bg-gradient-to-br from-purple-500 to-pink-500" style="animation-delay: -6s;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24 lg:pt-24 lg:pb-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-7">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold border border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-900/60 backdrop-blur">
                    <span class="pulse-dot"></span>
                    <span class="text-slate-700 dark:text-slate-200">Comparativa en tiempo real</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.05] text-slate-900 dark:text-white">
                    La tarifa perfecta,
                    <span class="block gradient-text">sin perder horas comparando.</span>
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
                    Compara tarifas de luz, gas y telefonía de los principales proveedores en segundos. Ahorra dinero con datos siempre actualizados.
                </p>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('search') }}" class="btn-brand ring-brand inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl text-white font-semibold text-base">
                        <i class="bi bi-search"></i>
                        Comparar tarifas ahora
                    </a>
                    <a href="#features" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-semibold text-base border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:border-sky-400 hover:text-sky-600 dark:hover:text-sky-400 transition-all">
                        <i class="bi bi-stars"></i>
                        Cómo funciona
                    </a>
                </div>

                <div class="inline-flex flex-wrap items-center gap-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 shadow-sm">
                    <div class="inline-flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-300">
                            <i class="bi bi-pin-map-fill"></i>
                        </span>
                        <div>
                            <div class="font-bold">Explora bares y restaurantes</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">Buscador por zona con mapa interactivo</div>
                        </div>
                    </div>
                    <a href="{{ route('search', ['mode' => 'zone']) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-rose-200 dark:border-rose-900/60 text-rose-700 dark:text-rose-200 font-semibold hover:bg-rose-50 dark:hover:bg-rose-900/30 transition">
                        <i class="bi bi-compass"></i>
                        Explorar zona
                    </a>
                    <span class="text-[10px] uppercase tracking-wider font-bold text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-900/40 px-2 py-1 rounded-full">Novedad</span>
                    <span class="text-[10px] uppercase tracking-wider font-bold text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/40 px-2 py-1 rounded-full">Solo registrados</span>
                </div>

                <div class="grid grid-cols-3 gap-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold gradient-text stat-num">+50K</div>
                        <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold mt-1">Usuarios</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold gradient-text stat-num">€500M</div>
                        <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold mt-1">Ahorrados</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold gradient-text stat-num">4.8★</div>
                        <div class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold mt-1">Valoración</div>
                    </div>
                </div>
            </div>

            {{-- Hero illustration card --}}
            <div class="relative hidden lg:block">
                <div class="relative mx-auto max-w-md">
                    <div class="absolute -inset-6 bg-gradient-to-br from-sky-400/30 via-indigo-500/30 to-purple-500/30 rounded-[2rem] blur-3xl"></div>
                    <div class="relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-indigo-500/10 p-6 hero-card-float">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                <span class="pulse-dot"></span>
                                Mejor oferta detectada
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/40 px-2 py-1 rounded-full">Top 1</span>
                        </div>

                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 grid place-items-center text-white shadow-lg">
                                <i class="bi bi-lightning-charge-fill text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs uppercase font-bold text-slate-500 dark:text-slate-400 tracking-wider">Iberdrola</div>
                                <div class="text-sm font-bold text-slate-900 dark:text-white">Plan Estable Online</div>
                            </div>
                        </div>

                        <div class="rounded-2xl p-4 mb-5 bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-sky-950/40 dark:to-indigo-950/40 border border-sky-100 dark:border-sky-900">
                            <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Precio mensual</div>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-4xl font-black gradient-text stat-num">€32.40</span>
                                <span class="text-sm text-slate-500 dark:text-slate-400">/mes</span>
                            </div>
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-1">
                                <i class="bi bi-arrow-down"></i> Ahorras €18 vs. tu tarifa actual
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="rounded-lg p-2.5 bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700">
                                <div class="text-slate-500 dark:text-slate-400">Permanencia</div>
                                <div class="font-bold text-slate-900 dark:text-white">Sin permanencia</div>
                            </div>
                            <div class="rounded-lg p-2.5 bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700">
                                <div class="text-slate-500 dark:text-slate-400">Energía</div>
                                <div class="font-bold text-slate-900 dark:text-white">100% verde</div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating mini-card --}}
                    <div class="absolute -bottom-6 -left-6 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-xl p-3 hero-card-float" style="animation-delay: -3s;">
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 grid place-items-center text-white">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ahorro medio</div>
                                <div class="text-sm font-extrabold text-slate-900 dark:text-white">€150/año</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================ PROVIDERS MARQUEE ============================ --}}
<section class="py-10 border-y border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/40">
    <div class="max-w-7xl mx-auto px-4">
        <p class="text-center text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6">Proveedores integrados</p>
        <div class="marquee overflow-hidden">
            <div class="marquee-track items-center">
                @foreach (['Endesa','Iberdrola','EDF','Naturgy','Telefónica','Vodafone','Endesa','Iberdrola','EDF','Naturgy','Telefónica','Vodafone'] as $provider)
                    <span class="text-2xl font-black text-slate-400/80 dark:text-slate-600 whitespace-nowrap">{{ $provider }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============================ FEATURES ============================ --}}
<section id="features" class="relative py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-16 reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Beneficios</span>
            <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Diseñado para ahorrarte <span class="gradient-text">tiempo y dinero</span>
            </h2>
            <p class="mt-4 text-lg text-slate-600 dark:text-slate-300">Todo lo que necesitas para tomar la mejor decisión.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $features = [
                    ['icon' => 'lightning-charge-fill', 'title' => 'Comparación instantánea', 'desc' => 'Cientos de tarifas analizadas en menos de un segundo con tu código postal.'],
                    ['icon' => 'piggy-bank-fill', 'title' => 'Ahorro real garantizado', 'desc' => 'Algoritmo de coincidencia que te muestra tu mejor opción según consumo.'],
                    ['icon' => 'shield-check', 'title' => 'Privacidad absoluta', 'desc' => 'Sin spam, sin reventa de datos. Tu información nunca sale de aquí.'],
                    ['icon' => 'graph-up-arrow', 'title' => 'Datos siempre actualizados', 'desc' => 'Sincronización automática con los proveedores cada 24 horas.'],
                    ['icon' => 'sliders2', 'title' => 'Filtros avanzados', 'desc' => 'Permanencia, precio, condiciones especiales, energía verde y más.', 'badge' => 'Solo registrados'],
                    ['icon' => 'file-earmark-pdf', 'title' => 'Exporta y comparte', 'desc' => 'Descarga tus comparativas en PDF o envíalas por email en un clic.', 'badge' => 'Solo registrados'],
                    ['icon' => 'pin-map-fill', 'title' => 'Explora la zona', 'desc' => 'Descubre bares y restaurantes alrededor del código postal directamente sobre el mapa.', 'badge' => 'Solo registrados'],
                ];
            @endphp

            @foreach ($features as $f)
                <div class="feature-card reveal rounded-2xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 relative"
                     onmousemove="this.style.setProperty('--mx', (event.offsetX) + 'px'); this.style.setProperty('--my', (event.offsetY) + 'px');">
                    @if (!empty($f['badge']))
                        <span class="absolute top-4 right-4 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                            <i class="bi bi-person-check-fill"></i>{{ $f['badge'] }}
                        </span>
                    @endif
                    <div class="feature-icon mb-5">
                        <i class="bi bi-{{ $f['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================ HOW IT WORKS ============================ --}}
<section class="relative py-24 bg-slate-50 dark:bg-slate-900/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-16 reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Cómo funciona</span>
            <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Tres pasos. <span class="gradient-text">Cero complicaciones.</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative">
            @foreach ([
                ['n' => '01', 'icon' => 'geo-alt-fill', 'title' => 'Indica tu zona', 'desc' => 'Introduce tu código postal y el tipo de servicio que buscas.'],
                ['n' => '02', 'icon' => 'bar-chart-line-fill', 'title' => 'Compara opciones', 'desc' => 'Filtra por precio, permanencia, condiciones y elige tu favorita.'],
                ['n' => '03', 'icon' => 'check2-circle', 'title' => 'Guarda y contrata', 'desc' => 'Exporta el PDF o accede directo a la oferta del proveedor.'],
            ] as $i => $step)
                <div class="reveal relative rounded-2xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="absolute -top-4 left-6 text-[3.5rem] font-black gradient-text leading-none stat-num opacity-90">{{ $step['n'] }}</div>
                    <div class="pt-10">
                        <div class="w-12 h-12 rounded-xl grid place-items-center bg-gradient-to-br from-sky-500 to-indigo-500 text-white shadow-lg shadow-indigo-500/30 mb-4">
                            <i class="bi bi-{{ $step['icon'] }} text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================ TESTIMONIALS ============================ --}}
<section class="relative py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-16 reveal">
            <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Testimonios</span>
            <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Lo que dicen <span class="gradient-text">nuestros usuarios</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['name' => 'María García', 'city' => 'Madrid', 'text' => 'Ahorré €180 al año cambiando mi tarifa de luz. El proceso fue sorprendentemente sencillo.', 'initials' => 'MG', 'color' => 'from-sky-500 to-indigo-500'],
                ['name' => 'Juan Pérez', 'city' => 'Barcelona', 'text' => 'La comparativa más clara que he visto. Nada de letra pequeña ni promesas raras.', 'initials' => 'JP', 'color' => 'from-purple-500 to-pink-500'],
                ['name' => 'Ana López', 'city' => 'Valencia', 'text' => 'Encontré una tarifa muchísimo mejor que la mía actual. 100% recomendado.', 'initials' => 'AL', 'color' => 'from-emerald-500 to-teal-500'],
            ] as $t)
                <div class="testimonial-card reveal rounded-2xl p-7 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div class="flex gap-1 text-amber-400 mb-4">
                        @for ($i = 0; $i < 5; $i++)<i class="bi bi-star-fill"></i>@endfor
                    </div>
                    <p class="text-slate-700 dark:text-slate-300 leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br {{ $t['color'] }} text-white grid place-items-center font-bold">{{ $t['initials'] }}</div>
                        <div>
                            <div class="font-bold text-slate-900 dark:text-white">{{ $t['name'] }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $t['city'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================ CTA FINAL ============================ --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-sky-500 via-indigo-600 to-purple-600"></div>
    <div class="absolute inset-0 grid-pattern opacity-20"></div>
    <div class="bg-blob w-[420px] h-[420px] -top-20 -left-20 bg-white"></div>
    <div class="bg-blob w-[420px] h-[420px] -bottom-20 -right-20 bg-white" style="animation-delay: -8s;"></div>

    <div class="relative max-w-4xl mx-auto px-4 text-center text-white">
        <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight mb-5">Empieza a ahorrar hoy mismo.</h2>
        <p class="text-lg sm:text-xl text-white/90 mb-9 max-w-2xl mx-auto">Toma el control de tus gastos. Compara las mejores tarifas en menos de 30 segundos.</p>
        <a href="{{ route('search') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-white text-indigo-700 font-bold text-lg shadow-2xl shadow-indigo-900/30 hover:scale-[1.02] transition-transform">
            <i class="bi bi-rocket-takeoff-fill"></i>
            Comparar tarifas ahora
        </a>
    </div>
</section>
@endsection
