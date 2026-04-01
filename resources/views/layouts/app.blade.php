<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EasyMove - Comparador de Servicios')</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="antialiased bg-white dark:bg-slate-950 transition-colors">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800 sticky top-0 z-50 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <i class="bi bi-truck text-2xl text-primary-600"></i>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">EasyMove</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Comparador de Servicios</p>
                    </div>
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ Auth::user()->name ?? 'Usuario' }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2">
                                <i class="bi bi-box-arrow-right"></i>
                                Salir
                            </button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 transition flex items-center gap-2">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Iniciar Sesión
                        </a>
                    @endguest
                    <button id="themeToggle" class="p-2 text-gray-600 dark:text-gray-300 hover:text-primary-600 transition border border-gray-300 dark:border-slate-700 rounded-lg">
                        <i class="bi bi-moon-stars" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-gray-200 dark:border-slate-800 mt-16 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-600 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} EasyMove. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Inicializar tema desde localStorage o usar dark por defecto
        const savedTheme = localStorage.getItem('theme');
        const isDark = savedTheme === 'dark' || savedTheme === null; // Dark por defecto
        
        if (isDark) {
            html.classList.add('dark');
            themeIcon.classList.remove('bi-moon-stars');
            themeIcon.classList.add('bi-sun-fill');
        } else {
            html.classList.remove('dark');
            themeIcon.classList.add('bi-moon-stars');
            themeIcon.classList.remove('bi-sun-fill');
        }

        // Toggle tema
        themeToggle.addEventListener('click', () => {
            const isDarkNow = html.classList.contains('dark');
            if (isDarkNow) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-stars');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('bi-moon-stars');
                themeIcon.classList.add('bi-sun-fill');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @yield('scripts')
</body>
</html>
