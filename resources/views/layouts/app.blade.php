<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EasyMove · Comparador inteligente de tarifas')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

    {{-- Anti-flash dark mode --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersColorScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedTheme ? savedTheme === 'dark' : prefersColorScheme;
            if (isDark) document.documentElement.classList.add('dark');
        })();
    </script>

    <style>
        :root {
            --brand-1: #0ea5e9;
            --brand-2: #6366f1;
            --brand-3: #a855f7;
            --surface: 255 255 255;
            --surface-soft: 248 250 252;
        }
        html.dark {
            color-scheme: dark;
            --surface: 15 23 42;
            --surface-soft: 2 6 23;
        }
        html:not(.dark) { color-scheme: light; }

        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; font-feature-settings: 'cv11', 'ss01'; }

        /* Smooth global transitions for theme switching */
        html.switching * { transition: none !important; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #cbd5e1, #94a3b8);
            border-radius: 999px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }
        html.dark ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #334155, #1e293b);
            background-clip: padding-box;
        }
        ::-webkit-scrollbar-thumb:hover { filter: brightness(1.1); }

        /* Glassmorphism navbar */
        .nav-glass {
            background: rgba(255, 255, 255, 0.72);
            -webkit-backdrop-filter: saturate(180%) blur(16px);
            backdrop-filter: saturate(180%) blur(16px);
        }
        html.dark .nav-glass {
            background: rgba(15, 23, 42, 0.72);
        }

        /* Gradient text helper */
        .gradient-text {
            background: linear-gradient(135deg, var(--brand-1), var(--brand-2), var(--brand-3));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Brand button */
        .btn-brand {
            background-image: linear-gradient(135deg, #0ea5e9 0%, #6366f1 50%, #a855f7 100%);
            background-size: 200% 200%;
            background-position: 0% 50%;
            transition: background-position .5s ease, transform .25s ease, box-shadow .25s ease;
            box-shadow: 0 8px 24px -8px rgba(99, 102, 241, .55);
        }
        .btn-brand:hover {
            background-position: 100% 50%;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px -10px rgba(99, 102, 241, .65);
        }

        /* Animated background blobs */
        .bg-blob {
            position: absolute;
            filter: blur(80px);
            opacity: .35;
            border-radius: 9999px;
            pointer-events: none;
            animation: blobFloat 18s ease-in-out infinite;
        }
        html.dark .bg-blob { opacity: .28; }
        @keyframes blobFloat {
            0%, 100% { transform: translate(0,0) scale(1); }
            50% { transform: translate(30px, -20px) scale(1.08); }
        }

        /* Reveal-on-scroll */
        .reveal { opacity: 0; transform: translateY(16px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        /* Subtle ring on focus */
        .ring-brand:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99,102,241,.35);
        }

        /* Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp .5s ease-out both; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-down { animation: slideDown .25s ease-out both; }

        /* Section divider */
        .divider-soft {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(148,163,184,.45), transparent);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/site.js'])
</head>
<body class="antialiased bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">

    {{-- ============================ NAVBAR ============================ --}}
    <nav class="nav-glass sticky top-0 z-50 border-b border-slate-200/70 dark:border-slate-800/70 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="group flex items-center gap-3 hover:opacity-95 transition-opacity">
                    <div class="relative w-11 h-11 rounded-xl flex items-center justify-center shadow-lg shadow-sky-500/25 bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-500 group-hover:scale-105 transition-transform duration-300">
                        <i class="bi bi-lightning-charge-fill text-white text-xl"></i>
                        <span class="absolute inset-0 rounded-xl ring-1 ring-white/20"></span>
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <h1 class="text-lg font-extrabold tracking-tight gradient-text">EasyMove</h1>
                        <p class="text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Smart Comparator</p>
                    </div>
                </a>

                {{-- Right Section --}}
                <div class="flex items-center gap-2 ml-auto">
                    {{-- Botón Buscar Tarifas (visible para todos) --}}
                    <a href="{{ route('search') }}" class="hidden sm:flex btn-brand ring-brand items-center gap-2 px-5 py-2.5 rounded-xl text-white font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        <i class="bi bi-search text-lg"></i>
                        <span class="hidden md:inline">Buscar tarifas</span>
                    </a>

                    @auth
                        {{-- Comparisons Menu --}}
                        <div class="relative hidden md:block">
                            <button id="comparisonsMenuToggle" type="button" class="ring-brand flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:border-sky-400/70 dark:hover:border-sky-400/70 hover:text-sky-600 dark:hover:text-sky-400 transition-all duration-300">
                                <i class="bi bi-bar-chart-line text-lg"></i>
                                <span class="font-semibold">Comparaciones</span>
                                <i class="bi bi-chevron-down text-xs opacity-70"></i>
                            </button>

                            <div id="comparisonsMenu" class="hidden absolute right-0 mt-2 w-60 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xl shadow-slate-900/10 overflow-hidden z-50 animate-slide-down">
                                <a href="{{ route('comparison.history') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    <i class="bi bi-clock-history text-sky-500"></i><span>Historial</span>
                                </a>
                                <a href="{{ route('comparison.saved') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors border-t border-slate-100 dark:border-slate-800">
                                    <i class="bi bi-bookmark-fill text-indigo-500"></i><span>Guardadas</span>
                                </a>
                                <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors border-t border-slate-100 dark:border-slate-800">
                                    <i class="bi bi-search text-purple-500"></i><span>Nueva búsqueda</span>
                                </a>
                            </div>
                        </div>

                        {{-- Admin Panel --}}
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-2 px-4 py-2.5 rounded-xl text-white font-semibold transition-all duration-300 bg-gradient-to-r from-fuchsia-600 to-rose-500 hover:from-fuchsia-700 hover:to-rose-600 shadow-lg shadow-fuchsia-500/25 hover:shadow-fuchsia-500/40 hover:-translate-y-0.5 group">
                                <i class="bi bi-shield-lock text-lg group-hover:rotate-12 transition-transform"></i>
                                <span>Admin</span>
                            </a>
                        @endif
                    @endauth

                    {{-- Theme Toggle --}}
                    <button id="themeToggle" class="ring-brand p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:border-sky-400/70 dark:hover:border-sky-400/70 hover:text-sky-600 dark:hover:text-sky-400 transition-all duration-300 hover:rotate-12" title="Cambiar tema">
                        <i class="bi bi-moon-stars text-lg" id="themeIcon"></i>
                    </button>

                    @auth
                        <div class="hidden sm:flex items-center gap-3 pl-3 ml-1 border-l border-slate-200 dark:border-slate-700">
                            <div class="text-right leading-tight">
                                <p class="text-xs font-semibold text-slate-700 dark:text-slate-200">{{ Auth::user()->nombre ?? 'Usuario' }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wide">{{ Auth::user()->rol === 'admin' ? 'Admin' : 'Usuario' }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="p-2.5 rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-colors" title="Cerrar Sesión">
                                    <i class="bi bi-box-arrow-right text-lg"></i>
                                </button>
                            </form>
                        </div>

                        <div class="md:hidden flex items-center gap-1">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="p-2.5 rounded-xl text-fuchsia-600 dark:text-fuchsia-400 hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20 transition-colors" title="Panel Admin">
                                    <i class="bi bi-shield-lock text-lg"></i>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="p-2.5 rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors" title="Cerrar Sesión">
                                    <i class="bi bi-box-arrow-right text-lg"></i>
                                </button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="hidden sm:inline px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="btn-brand ring-brand px-4 py-2.5 rounded-xl text-white text-sm font-semibold flex items-center gap-2">
                            <i class="bi bi-person-plus"></i>
                            <span class="hidden sm:inline">Crear cuenta</span>
                        </a>
                        <button id="mobileMenuToggle" class="md:hidden p-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <i class="bi bi-list text-xl"></i>
                        </button>
                    @endguest
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-slate-200 dark:border-slate-800 animate-slide-down">
                <div class="flex flex-col gap-2 pt-3">
                    <a href="{{ route('search') }}" class="px-4 py-3 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-600 hover:to-indigo-700 transition-colors flex items-center gap-2">
                        <i class="bi bi-search text-lg"></i><span>Buscar tarifas</span>
                    </a>
                    @auth
                        <a href="{{ route('comparison.history') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
                            <i class="bi bi-clock-history text-sky-500"></i><span>Historial</span>
                        </a>
                        <a href="{{ route('comparison.saved') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
                            <i class="bi bi-bookmark-fill text-indigo-500"></i><span>Guardadas</span>
                        </a>
                        <a href="{{ route('search') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
                            <i class="bi bi-search text-purple-500"></i><span>Nueva búsqueda</span>
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            Iniciar Sesión
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================ MAIN ============================ --}}
    <main class="animate-fade-in-up @yield('main_class', 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8')">
        @yield('content')
    </main>

    {{-- ============================ FOOTER ============================ --}}
    <footer class="relative mt-20 border-t border-slate-200 dark:border-slate-800 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-lg bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-500">
                            <i class="bi bi-lightning-charge-fill text-lg"></i>
                        </div>
                        <h3 class="text-lg font-extrabold tracking-tight gradient-text">EasyMove</h3>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 max-w-xs">El comparador inteligente para encontrar la mejor tarifa en segundos.</p>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 rounded-full bg-gradient-to-b from-sky-500 to-indigo-500"></span>
                        Producto
                    </h4>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('search') }}" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Buscar tarifas</a></li>
                        @auth<li><a href="{{ route('comparison.history') }}" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Historial</a></li>@endauth
                        @auth<li><a href="{{ route('comparison.saved') }}" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Comparaciones guardadas</a></li>@endauth
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 rounded-full bg-gradient-to-b from-indigo-500 to-purple-500"></span>
                        Empresa
                    </h4>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('about') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Sobre Nosotros</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Contacto</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-500"></span>
                        Legal
                    </h4>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Privacidad</a></li>
                        <li><a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Términos</a></li>
                        <li><a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="divider-soft my-8"></div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-600 dark:text-slate-400">
                <p>&copy; {{ date('Y') }} EasyMove · Todos los derechos reservados.</p>
                <div class="flex items-center gap-3">
                    <a href="#" aria-label="Facebook" class="w-9 h-9 grid place-items-center rounded-full border border-slate-200 dark:border-slate-700 hover:border-sky-400 hover:text-sky-500 transition-all hover:-translate-y-0.5"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="Twitter" class="w-9 h-9 grid place-items-center rounded-full border border-slate-200 dark:border-slate-700 hover:border-sky-400 hover:text-sky-500 transition-all hover:-translate-y-0.5"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" aria-label="LinkedIn" class="w-9 h-9 grid place-items-center rounded-full border border-slate-200 dark:border-slate-700 hover:border-sky-400 hover:text-sky-500 transition-all hover:-translate-y-0.5"><i class="bi bi-linkedin"></i></a>
                    <a href="#" aria-label="Instagram" class="w-9 h-9 grid place-items-center rounded-full border border-slate-200 dark:border-slate-700 hover:border-sky-400 hover:text-sky-500 transition-all hover:-translate-y-0.5"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ============================ SCRIPTS ============================ --}}
    <script>
        // Theme toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const savedTheme = localStorage.getItem('theme');
        const isDarkInitial = savedTheme ? savedTheme === 'dark' : prefersDark;

        function applyTheme(dark) {
            html.classList.toggle('dark', dark);
            if (themeIcon) {
                themeIcon.classList.toggle('bi-moon-stars', !dark);
                themeIcon.classList.toggle('bi-sun-fill', dark);
            }
        }
        applyTheme(isDarkInitial);

        themeToggle?.addEventListener('click', () => {
            html.classList.add('switching');
            const next = !html.classList.contains('dark');
            applyTheme(next);
            localStorage.setItem('theme', next ? 'dark' : 'light');
            setTimeout(() => html.classList.remove('switching'), 300);
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) applyTheme(e.matches);
        });

        // Mobile menu
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
            mobileMenu.querySelectorAll('a').forEach(link =>
                link.addEventListener('click', () => mobileMenu.classList.add('hidden'))
            );
        }

        // Comparisons dropdown
        const comparisonsMenuToggle = document.getElementById('comparisonsMenuToggle');
        const comparisonsMenu = document.getElementById('comparisonsMenu');
        if (comparisonsMenuToggle && comparisonsMenu) {
            comparisonsMenuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                comparisonsMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!comparisonsMenuToggle.contains(e.target) && !comparisonsMenu.contains(e.target)) {
                    comparisonsMenu.classList.add('hidden');
                }
            });
        }

        // Reveal on scroll
        const revealEls = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window && revealEls.length) {
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            revealEls.forEach(el => io.observe(el));
        } else {
            revealEls.forEach(el => el.classList.add('is-visible'));
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @yield('scripts')
</body>
</html>
