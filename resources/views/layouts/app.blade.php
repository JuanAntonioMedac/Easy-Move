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

    @vite(['resources/css/app.css', 'resources/js/site.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-950 transition-colors">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo Section -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-90 transition group mr-8">
                    <div class="relative w-12 h-12 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition">
                        <i class="bi bi-truck text-white text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">EasyMove</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Comparador Smart</p>
                    </div>
                </a>

                <!-- Right Section -->
                    <div class="flex items-center gap-2 ml-auto">
                        <!-- Admin Panel Button -->
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-lg font-semibold transition shadow-lg hover:shadow-xl">
                                    <i class="bi bi-shield-lock text-lg"></i>
                                    <span>Panel Admin</span>
                                </a>
                            @endif
                        @endauth

                        <!-- Theme Toggle -->
                        <button id="themeToggle" class="p-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:border-blue-500 dark:hover:border-blue-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                            <i class="bi bi-moon-stars text-lg" id="themeIcon"></i>
                        </button>

                        @auth
                            <!-- User Info & Logout -->
                            <div class="hidden sm:flex items-center gap-2 pl-2 border-l-2 border-gray-200 dark:border-gray-700">
                                <div class="text-right">
                                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ Auth::user()->nombre ?? 'Usuario' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->rol === 'admin' ? 'Administrador' : 'Usuario' }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2.5 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition font-semibold" title="Cerrar Sesión">
                                        <i class="bi bi-power text-lg"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Mobile Admin Button + Logout -->
                            <div class="md:hidden flex items-center gap-1">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="p-2.5 rounded-lg text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/30 transition" title="Panel Admin">
                                        <i class="bi bi-shield-lock text-lg"></i>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2.5 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition" title="Cerrar Sesión">
                                        <i class="bi bi-power text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="hidden sm:inline px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg text-sm font-semibold transition shadow-lg hover:shadow-xl flex items-center gap-2">
                                <i class="bi bi-person-plus"></i>
                                <span class="hidden sm:inline">Registrarse</span>
                            </a>

                            <!-- Mobile Menu Toggle -->
                            <button id="mobileMenuToggle" class="md:hidden p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <i class="bi bi-list text-lg"></i>
                            </button>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition text-sm font-medium">
                            Iniciar Sesión
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-16 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold">
                            <i class="bi bi-truck text-lg"></i>
                        </div>
                        <h3 class="text-lg font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">EasyMove</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">El comparador inteligente de servicios más rápido.</p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4">Producto</h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Características</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Proveedores</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Precios</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4">Empresa</h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Sobre Nosotros</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Blog</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Contacto</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Privacidad</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Términos</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="bg-gray-100 dark:bg-gray-700 h-px my-8"></div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} EasyMove. Todos los derechos reservados.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Theme & Mobile Menu Script -->
    <script>
        // Dark Mode Toggle
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

        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Close menu when clicking links
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @yield('scripts')
</body>
</html>
