@extends('layouts.app')

@section('title', 'Iniciar Sesión - EasyMove')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen-navbar bg-gray-50 dark:bg-slate-950">
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">Iniciar Sesión</h2>
        
        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Email
                </label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Contraseña
                </label>
                <input type="password" id="password" name="password" placeholder="••••••••" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
            </div>

            <button type="submit" class="w-full px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
                Iniciar Sesión
            </button>
        </form>

        <p class="text-center text-gray-600 dark:text-gray-400 mt-4 text-sm">
            <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Volver a búsqueda
            </a>
        </p>
    </div>
</div>
@endsection
