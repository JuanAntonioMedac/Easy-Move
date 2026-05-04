<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EasyMove - Comparador de Servicios')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

    <!-- Prevenir parpadeo en modo oscuro -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersColorScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedTheme ? savedTheme === 'dark' : prefersColorScheme;
            
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <style>
        :root {
            --color-primary: #0ea5e9;
            --color-accent: #a855f7;
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
        }

        * {
            @apply transition-colors duration-200;
        }

        html {
            @apply scroll-smooth;
        }

        html.dark {
            color-scheme: dark;
        }

        html:not(.dark) {
            color-scheme: light;
        }

        /* Smooth transitions for theme switching */
        html.switching * {
            @apply !transition-none;
        }

        .btn-transition {
            @apply transition-all duration-300 ease-in-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            @apply w-2;
        }

        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800;
        }

        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300 dark:bg-gray-600 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/site.js'])
</head>
<body class="antialiased bg-white dark:bg-slate-950 transition-colors duration-300">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 sticky top-0 z-50 transition-all duration-300 shadow-sm hover:shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo Section -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity mr-8 group">
                    <div class="relative w-12 h-12 bg-gradient-to-br from-sky-500 via-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-transform">
                        <i class="bi bi-truck text-white text-xl font-bold"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-bold bg-gradient-to-r from-sky-600 to-blue-600 dark:from-sky-400 dark:to-blue-400 bg-clip-text text-transparent">EasyMove</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Comparador Inteligente</p>
                    </div>
                </a>

                <!-- Right Section -->
                    <div class="flex items-center gap-2 ml-auto">
                        <!-- Admin Panel Button -->
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 group">
                                    <i class="bi bi-shield-lock text-lg group-hover:rotate-12 transition-transform"></i>
                                    <span>Panel Admin</span>
                                </a>
                            @endif
                        @endauth

                        <!-- Theme Toggle -->
                        <button id="themeToggle" class="p-2.5 rounded-lg border-2 border-gray-200 dark:border-slate-600 text-gray-600 dark:text-gray-300 hover:border-sky-500 dark:hover:border-sky-400 hover:text-sky-600 dark:hover:text-sky-400 transition-all duration-300 hover:scale-110" title="Cambiar tema">
                            <i class="bi bi-moon-stars text-lg" id="themeIcon"></i>
                        </button>

                        @auth
                            <!-- User Info & Logout -->
                            <div class="hidden sm:flex items-center gap-3 pl-3 border-l-2 border-gray-200 dark:border-slate-700">
                                <div class="text-right">
                                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-200">{{ Auth::user()->nombre ?? 'Usuario' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->rol === 'admin' ? 'Admin' : 'Usuario' }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors" title="Cerrar Sesión">
                                        <i class="bi bi-box-arrow-right text-lg"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Mobile Admin Button + Logout -->
                            <div class="md:hidden flex items-center gap-1">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="p-2.5 rounded-lg text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors" title="Panel Admin">
                                        <i class="bi bi-shield-lock text-lg"></i>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Cerrar Sesión">
                                        <i class="bi bi-box-arrow-right text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="hidden sm:inline px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2.5 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white rounded-lg text-sm font-semibold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 flex items-center gap-2">
                                <i class="bi bi-person-plus"></i>
                                <span class="hidden sm:inline">Registrarse</span>
                            </a>

                            <!-- Mobile Menu Toggle -->
                            <button id="mobileMenuToggle" class="md:hidden p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                <i class="bi bi-list text-lg"></i>
                            </button>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-gray-200 dark:border-slate-700 animate-slide-down">
                <div class="flex flex-col gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors text-sm font-medium">
                            Iniciar Sesión
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-white to-gray-50 dark:from-slate-800 dark:to-slate-900 border-t border-gray-200 dark:border-slate-700 mt-16 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
                            <i class="bi bi-truck text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold bg-gradient-to-r from-sky-600 to-blue-600 dark:from-sky-400 dark:to-blue-400 bg-clip-text text-transparent">EasyMove</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">El comparador inteligente de servicios más confiable.</p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 bg-gradient-to-b from-sky-500 to-blue-600 rounded-full"></span>
                        Producto
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Características</a></li>
                        <li><a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Proveedores</a></li>
                        <li><a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Precios</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 bg-gradient-to-b from-purple-500 to-pink-600 rounded-full"></span>
                        Empresa
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">Sobre Nosotros</a></li>
                        <li><a href="#" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">Contacto</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></span>
                        Legal
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Privacidad</a></li>
                        <li><a href="#" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Términos</a></li>
                        <li><a href="#" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="bg-gradient-to-r from-gray-200 to-gray-100 dark:from-slate-700 dark:to-slate-600 h-px my-8"></div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} EasyMove. Todos los derechos reservados. ✨</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors hover:scale-110"><i class="bi bi-facebook text-lg"></i></a>
                    <a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors hover:scale-110"><i class="bi bi-twitter text-lg"></i></a>
                    <a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors hover:scale-110"><i class="bi bi-linkedin text-lg"></i></a>
                    <a href="#" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors hover:scale-110"><i class="bi bi-instagram text-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Theme & Mobile Menu Script -->
    <script>
        // Dark Mode Toggle con transiciones suaves
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Detectar preferencia del sistema
        const prefersColorScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        // Inicializar tema desde localStorage o usar preferencia del sistema
        const savedTheme = localStorage.getItem('theme');
        const isDark = savedTheme ? savedTheme === 'dark' : prefersColorScheme;

        function applyTheme(dark) {
            if (dark) {
                html.classList.add('dark');
                themeIcon.classList.remove('bi-moon-stars');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                html.classList.remove('dark');
                themeIcon.classList.add('bi-moon-stars');
                themeIcon.classList.remove('bi-sun-fill');
            }
        }

        applyTheme(isDark);

        // Toggle tema con transición suave
        themeToggle.addEventListener('click', () => {
            html.classList.add('switching');
            const isDarkNow = html.classList.contains('dark');
            applyTheme(!isDarkNow);
            localStorage.setItem('theme', !isDarkNow ? 'dark' : 'light');
            
            setTimeout(() => {
                html.classList.remove('switching');
            }, 300);
        });

        // Detectar cambios de preferencia del sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches);
            }
        });

        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                themeIcon.parentElement.classList.toggle('animate-pulse');
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
