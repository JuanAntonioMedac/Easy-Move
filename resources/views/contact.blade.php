@extends('layouts.app')

@section('title', 'Contacto · EasyMove')

@section('content')
<style>
    .contact-hero {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
        border: 1px solid rgb(226 232 240);
        background:
            radial-gradient(1000px 380px at 0% -10%, rgba(14,165,233,.16), transparent 60%),
            radial-gradient(900px 360px at 100% 0%, rgba(34,197,94,.16), transparent 60%),
            linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    }
    html.dark .contact-hero {
        border-color: rgb(30 41 59);
        background:
            radial-gradient(1000px 380px at 0% -10%, rgba(14,165,233,.2), transparent 60%),
            radial-gradient(900px 360px at 100% 0%, rgba(34,197,94,.16), transparent 60%),
            linear-gradient(180deg, #0f172a 0%, #020617 100%);
    }

    .contact-card {
        border-radius: 1.5rem;
        border: 1px solid rgb(226 232 240);
        background: white;
        box-shadow: 0 18px 36px -26px rgba(15,23,42,.35);
    }
    html.dark .contact-card {
        border-color: rgb(30 41 59);
        background: rgb(15 23 42);
        box-shadow: 0 18px 36px -26px rgba(0,0,0,.6);
    }
    .contact-card-header {
        background: linear-gradient(135deg, rgba(14,165,233,.14), rgba(99,102,241,.12));
        border-bottom: 1px solid rgb(226 232 240);
    }
    html.dark .contact-card-header {
        background: linear-gradient(135deg, rgba(14,165,233,.18), rgba(99,102,241,.14));
        border-bottom-color: rgb(30 41 59);
    }
    .contact-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(148,163,184,.4), transparent);
    }
</style>

<section class="space-y-12">
    <div class="contact-hero p-8 sm:p-12">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/70 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-700 text-emerald-600 dark:text-emerald-400 mb-5">
            <i class="bi bi-chat-dots-fill"></i> Contacto
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
            Hablemos cuando lo necesites.
        </h1>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-300 max-w-2xl">
            Estamos aqui para ayudarte con comparativas, proveedores o dudas sobre el explorador de zonas.
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="rounded-2xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="w-11 h-11 rounded-xl grid place-items-center bg-gradient-to-br from-sky-500 to-indigo-500 text-white shadow-lg shadow-indigo-500/30 mb-4">
                <i class="bi bi-envelope-paper-fill text-xl"></i>
            </div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Email</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">soporte@easymove.com</p>
        </div>
        <div class="rounded-2xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="w-11 h-11 rounded-xl grid place-items-center bg-gradient-to-br from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/30 mb-4">
                <i class="bi bi-telephone-fill text-xl"></i>
            </div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Telefono</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">+34 900 123 456</p>
        </div>
        <div class="rounded-2xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="w-11 h-11 rounded-xl grid place-items-center bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30 mb-4">
                <i class="bi bi-clock-fill text-xl"></i>
            </div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Horario</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">Lun a Vie, 9:00 - 18:00</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-10 items-start">
        <div class="contact-card overflow-hidden">
            <div class="contact-card-header px-8 py-6">
                <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white">Escribenos</h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Te respondemos en menos de 24 horas laborales.</p>
            </div>
            <div class="px-8 py-7">
                <form class="space-y-4" onsubmit="event.preventDefault();">
                    <div>
                        <label class="field-label">Nombre</label>
                        <input type="text" class="field-input" placeholder="Tu nombre" />
                    </div>
                    <div>
                        <label class="field-label">Email</label>
                        <input type="email" class="field-input" placeholder="tu@email.com" />
                    </div>
                    <div>
                        <label class="field-label">Mensaje</label>
                        <textarea class="field-input" rows="5" placeholder="Cuentanos en que podemos ayudarte"></textarea>
                    </div>
                    <div class="contact-divider"></div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="btn-brand ring-brand inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-white font-semibold">
                            <i class="bi bi-send-fill"></i>
                            Enviar mensaje
                        </button>
                        <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                            <i class="bi bi-shield-check text-emerald-500"></i>
                            Tus datos no se comparten con terceros.
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-gradient-to-br from-slate-50 to-white dark:from-slate-900 dark:to-slate-950 p-8">
            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white">Tambien puedes</h3>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Accede rapido al comparador o al buscador de bares y restaurantes.</p>
            <div class="mt-6 flex flex-col gap-3">
                <a href="{{ route('search') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:border-sky-400 hover:text-sky-600 dark:hover:text-sky-400 transition">
                    <i class="bi bi-stars"></i>
                    Ir al comparador
                </a>
                <a href="{{ route('search', ['mode' => 'zone']) }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-rose-200 dark:border-rose-900/60 text-rose-700 dark:text-rose-200 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition">
                    <i class="bi bi-search-heart"></i>
                    Buscar lugares para comer
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
