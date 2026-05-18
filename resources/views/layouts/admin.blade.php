@extends('layouts.app')

@section('main_class', 'w-full')

@section('content')
<style>
    .admin-layout {
        display: flex;
        min-height: calc(100vh - 80px);
    }

    .admin-sidebar {
        width: 280px;
        background: rgba(255, 255, 255, 0.85);
        -webkit-backdrop-filter: saturate(180%) blur(16px);
        backdrop-filter: saturate(180%) blur(16px);
        border-right: 1px solid rgba(226, 232, 240, .8);
        overflow-y: auto;
        position: fixed;
        left: 0;
        top: 80px;
        height: calc(100vh - 80px);
        z-index: 30;
        transition: transform .3s ease;
    }
    html.dark .admin-sidebar {
        background: rgba(15, 23, 42, 0.85);
        border-right-color: rgba(51, 65, 85, .8);
    }

    .admin-content {
        margin-left: 280px;
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .sidebar-link {
        position: relative;
        overflow: hidden;
        transition: all .25s ease;
    }
    .sidebar-link::before {
        content: '';
        position: absolute;
        left: 0; top: 8px; bottom: 8px;
        width: 3px;
        background: linear-gradient(180deg, #0ea5e9, #6366f1, #a855f7);
        border-radius: 0 3px 3px 0;
        transform: translateX(-4px);
        transition: transform .3s ease;
    }
    .sidebar-link.active {
        background: linear-gradient(135deg, rgba(14,165,233,.12), rgba(168,85,247,.12));
        color: #4f46e5;
        font-weight: 700;
    }
    html.dark .sidebar-link.active {
        background: linear-gradient(135deg, rgba(56,189,248,.18), rgba(192,132,252,.18));
        color: #a5b4fc;
    }
    .sidebar-link.active::before { transform: translateX(0); }

    .sidebar-link:not(.active):hover {
        background: rgba(99,102,241,.08);
        color: #4f46e5;
    }
    html.dark .sidebar-link:not(.active):hover {
        background: rgba(129,140,248,.12);
        color: #a5b4fc;
    }

    .sidebar-pill {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 9999px;
        letter-spacing: .04em;
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            transform: translateX(-100%);
            width: 100%;
            max-width: 280px;
            z-index: 40;
            box-shadow: 4px 0 24px rgba(0,0,0,.18);
        }
        .admin-sidebar.active { transform: translateX(0); }
        .admin-content { margin-left: 0; width: 100%; }
    }
</style>

<div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden md:hidden z-30 transition-opacity"></div>

<div class="admin-layout">
    {{-- ============== SIDEBAR ============== --}}
    <aside id="sidebar" class="admin-sidebar">
        <div class="h-full flex flex-col">
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 grid place-items-center text-white shadow-lg shadow-indigo-500/30 overflow-hidden p-0.5">
                        <img src="{{ asset('brand-logo.png') }}" alt="CamionBrum" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <p class="text-sm font-extrabold gradient-text leading-tight">Panel Admin</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wider">EasyMove</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 text-lg"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <div class="px-4 pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Gestión</p>
                </div>

                <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill text-lg"></i>
                    <span class="font-medium text-sm">Usuarios</span>
                    <span class="sidebar-pill ml-auto bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300">{{ $totalUsuarios ?? '0' }}</span>
                </a>
                <a href="{{ route('admin.providers.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.providers.*') ? 'active' : '' }}">
                    <i class="bi bi-building-fill text-lg"></i>
                    <span class="font-medium text-sm">Proveedores</span>
                    <span class="sidebar-pill ml-auto bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">{{ $totalProveedores ?? '0' }}</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase-fill text-lg"></i>
                    <span class="font-medium text-sm">Servicios</span>
                    <span class="sidebar-pill ml-auto bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300">{{ $totalServicios ?? '0' }}</span>
                </a>
                <a href="{{ route('admin.tariffs.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.tariffs.*') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill text-lg"></i>
                    <span class="font-medium text-sm">Tarifas</span>
                    <span class="sidebar-pill ml-auto bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300">{{ $totalTarifas ?? '0' }}</span>
                </a>
                <a href="{{ route('admin.locations.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill text-lg"></i>
                    <span class="font-medium text-sm">Ubicaciones</span>
                </a>

                <div class="px-4 pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">General</p>
                </div>

                <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300">
                    <i class="bi bi-house-door-fill text-lg"></i>
                    <span class="font-medium text-sm">Volver al sitio</span>
                </a>
                <a href="{{ route('search') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300">
                    <i class="bi bi-search text-lg"></i>
                    <span class="font-medium text-sm">Ir al buscador</span>
                </a>
            </nav>

            <div class="px-3 py-4 border-t border-slate-200 dark:border-slate-800">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors font-medium text-sm">
                        <i class="bi bi-box-arrow-right text-lg"></i>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ============== MAIN ============== --}}
    <main class="admin-content">
        <button id="sidebarToggle" class="md:hidden fixed top-24 left-4 z-50 p-3 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-500 text-white shadow-lg shadow-indigo-500/30 hover:scale-105 transition-transform">
            <i class="bi bi-list text-lg"></i>
        </button>

        <div class="flex-1 w-full p-4 md:p-8 bg-slate-50/50 dark:bg-slate-950">
            @yield('admin-content')
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('hidden');
        document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : 'auto';
    }
    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('active')) toggleSidebar();
            }
        });
    });
    document.getElementById('sidebarOverlay')?.addEventListener('click', toggleSidebar);
    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });
</script>
@endsection
