@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-lg shadow-md p-8 mt-10">
    <div class="text-center mb-8">
        <i class="bi bi-person-plus text-4xl text-primary-600"></i>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-4">Crear una cuenta</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Únete a EasyMove para guardar tus búsquedas</p>
    </div>

    <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
            <input id="password" type="password" name="password" required
                class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-600">
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-sm text-primary-600 hover:text-primary-700 dark:hover:text-primary-400" href="{{ route('login') }}">
                ¿Ya tienes cuenta?
            </a>

            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition font-medium">
                Registrarse
            </button>
        </div>
    </form>
</div>
@endsection