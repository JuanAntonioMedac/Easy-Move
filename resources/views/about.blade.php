@extends('layouts.app')

@section('title', 'Sobre Nosotros · EasyMove')

@section('content')
<style>
    .about-hero {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
        border: 1px solid rgb(226 232 240);
        background:
            radial-gradient(900px 360px at 0% -10%, rgba(14,165,233,.18), transparent 60%),
            radial-gradient(900px 360px at 100% 0%, rgba(168,85,247,.18), transparent 60%),
            linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    }
    html.dark .about-hero {
        border-color: rgb(30 41 59);
        background:
            radial-gradient(900px 360px at 0% -10%, rgba(14,165,233,.20), transparent 60%),
            radial-gradient(900px 360px at 100% 0%, rgba(168,85,247,.18), transparent 60%),
            linear-gradient(180deg, #0f172a 0%, #020617 100%);
    }
</style>

<section class="space-y-16">
    <div class="about-hero p-8 sm:p-12">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/70 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-400 mb-5">
            <i class="bi bi-people-fill"></i> Nuestro equipo
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
            Creamos la forma mas simple de
            <span class="block gradient-text">encontrar la mejor tarifa.</span>
        </h1>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-300 max-w-2xl">
            EasyMove nace para ayudar a las familias y negocios a comparar servicios en segundos, con datos reales y sin letra pequena.
        </p>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Comparativas al mes</p>
                <p class="text-2xl font-extrabold gradient-text">+120k</p>
            </div>
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Proveedores conectados</p>
                <p class="text-2xl font-extrabold gradient-text">+35</p>
            </div>
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Ahorro medio</p>
                <p class="text-2xl font-extrabold gradient-text">€150/ano</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="rounded-2xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="w-11 h-11 rounded-xl grid place-items-center bg-gradient-to-br from-sky-500 to-indigo-500 text-white shadow-lg shadow-indigo-500/30 mb-4">
                <i class="bi bi-lightning-charge-fill text-xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Velocidad real</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">Algoritmos optimizados para mostrar tarifas en segundos, sin esperas ni sorpresas.</p>
        </div>
        <div class="rounded-2xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="w-11 h-11 rounded-xl grid place-items-center bg-gradient-to-br from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/30 mb-4">
                <i class="bi bi-shield-check text-xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Transparencia total</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">Sin letra pequena, sin spam. Solo comparativas claras y condiciones reales.</p>
        </div>
        <div class="rounded-2xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="w-11 h-11 rounded-xl grid place-items-center bg-gradient-to-br from-rose-500 to-amber-500 text-white shadow-lg shadow-rose-500/30 mb-4">
                <i class="bi bi-heart-fill text-xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Centrados en ti</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">Diseño claro, datos actualizados y soporte humano cuando lo necesites.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 sm:p-10">
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            <div>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Nuestro compromiso</h3>
                <p class="mt-3 text-slate-600 dark:text-slate-400">Actualizamos la informacion de proveedores cada 24 horas para que siempre compares con datos reales y vigentes.</p>
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="benefit-item"><i class="bi bi-check-circle"></i>Datos verificados</span>
                    <span class="benefit-item"><i class="bi bi-check-circle"></i>Soporte en minutos</span>
                    <span class="benefit-item"><i class="bi bi-check-circle"></i>Sin coste oculto</span>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-sky-950/40 dark:to-indigo-950/40 p-6">
                <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Explora tambien nuestra novedad</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-5">Encuentra bares y restaurantes por zona con un mapa interactivo.</p>
                <a href="{{ route('search', ['mode' => 'zone']) }}" class="btn-brand ring-brand inline-flex items-center gap-2 px-5 py-3 rounded-xl text-white font-semibold">
                    <i class="bi bi-search-heart"></i>
                    Buscar lugares para comer
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
