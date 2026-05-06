@extends('layouts.app')

@section('title', 'Iniciar sesión · EasyMove')

@section('main_class', 'w-full')

@section('content')
<div class="relative min-h-[calc(100vh-5rem)] flex items-center justify-center px-4 py-12 overflow-hidden">
    <div class="bg-blob w-[480px] h-[480px] -top-24 -left-24 bg-gradient-to-br from-sky-400 to-indigo-500"></div>
    <div class="bg-blob w-[420px] h-[420px] -bottom-24 -right-24 bg-gradient-to-br from-purple-500 to-pink-500" style="animation-delay: -8s;"></div>

    <div class="relative w-full max-w-md">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-indigo-500/10 p-8 sm:p-10 animate-fade-in-up">
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-14 h-14 rounded-2xl grid place-items-center bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-500 text-white shadow-lg shadow-indigo-500/30 mb-4">
                    <i class="bi bi-lightning-charge-fill text-2xl"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Bienvenido de vuelta</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Inicia sesión para acceder a tus comparativas</p>
            </div>

            @include('shared.alerts')

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        <i class="bi bi-envelope mr-1"></i>Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        <i class="bi bi-lock mr-1"></i>Contraseña
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="••••••••" required
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
                        <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 px-4 text-slate-400 hover:text-indigo-500 transition-colors" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-brand ring-brand w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-white font-bold text-base">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Iniciar sesión
                </button>
            </form>

            <div class="my-6 flex items-center gap-3">
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
                <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">o</span>
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
            </div>

            <p class="text-center text-sm text-slate-600 dark:text-slate-400">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Crea una</a>
            </p>

            <p class="text-center mt-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <i class="bi bi-arrow-left"></i> Volver al inicio
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('i');
        const isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !isPwd);
        icon.classList.toggle('bi-eye-slash', isPwd);
    }
</script>
@endsection
