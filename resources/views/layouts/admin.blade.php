@extends('layouts.app')

@section('content')
<style>
    .admin-layout {
        display: flex;
        min-height: calc(100vh - 80px);
    }

    .admin-sidebar {
        width: 280px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-right: 1px solid #e2e8f0;
        overflow-y: auto;
        position: fixed;
        left: 0;
        top: 80px;
        height: calc(100vh - 80px);
        z-index: 30;
        transition: all 0.3s ease;
    }

    html.dark .admin-sidebar {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-right: 1px solid #334155;
    }

    .admin-content {
        margin-left: 280px;
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sidebar-link {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .sidebar-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(180deg, #0ea5e9, #0284c7);
        transform: translateX(-3px);
        transition: transform 0.3s ease;
    }

    .sidebar-link.active {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0.05) 100%);
        color: #0284c7;
        font-weight: 600;
    }

    html.dark .sidebar-link.active {
        background: linear-gradient(135deg, rgba(56, 189, 248, 0.15) 0%, rgba(56, 189, 248, 0.05) 100%);
        color: #38bdf8;
    }

    .sidebar-link.active::before {
        transform: translateX(0);
    }

    .sidebar-link:hover:not(.active) {
        background: rgba(14, 165, 233, 0.08);
    }

    html.dark .sidebar-link:hover:not(.active) {
        background: rgba(56, 189, 248, 0.12);
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            transform: translateX(-100%);
            width: 100%;
            max-width: 280px;
            z-index: 40;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15);
        }

        .admin-sidebar.active {
            transform: translateX(0);
        }

        .admin-content {
            margin-left: 0;
            width: 100%;
        }
    }

    .section-header {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    html.dark .section-header {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<!-- Overlay para móvil -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden md:hidden z-30 transition-opacity duration-300"></div>

<!-- Contenedor Principal -->
<div class="admin-layout">
    <!-- Sidebar Moderno -->
    <aside id="sidebar" class="admin-sidebar">
        <div class="h-full flex flex-col">
            <!-- Logo en Sidebar -->
            <div class="px-6 py-6 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-blue-600 rounded-lg flex items-center justify-center text-white shadow-md group-hover:shadow-lg transition-shadow">
                        <i class="bi bi-sliders text-lg font-bold"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">Panel Admin</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">EasyMove</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 {{ request()->routeIs('admin.dashboard') ? 'active text-sky-600 dark:text-sky-400' : '' }}">
                    <i class="bi bi-speedometer2 text-lg flex-shrink-0"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <!-- Divider -->
                <div class="my-3 border-t border-gray-200 dark:border-slate-700"></div>

                <!-- Sección: Gestión de Contenido -->
                <div class="px-4 py-3 mb-2">
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Gestión</p>
                </div>

                <!-- Usuarios -->
                <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 {{ request()->routeIs('admin.users.*') ? 'active text-sky-600 dark:text-sky-400' : '' }}">
                    <i class="bi bi-people text-lg flex-shrink-0"></i>
                    <span class="font-medium text-sm">Usuarios</span>
                    <span class="ml-auto text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full">{{ $totalUsuarios ?? '0' }}</span>
                </a>

                <!-- Proveedores -->
                <a href="{{ route('admin.providers.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 {{ request()->routeIs('admin.providers.*') ? 'active text-sky-600 dark:text-sky-400' : '' }}">
                    <i class="bi bi-building text-lg flex-shrink-0"></i>
                    <span class="font-medium text-sm">Proveedores</span>
                    <span class="ml-auto text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-0.5 rounded-full">{{ $totalProveedores ?? '0' }}</span>
                </a>

                <!-- Servicios -->
                <a href="{{ route('admin.services.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 {{ request()->routeIs('admin.services.*') ? 'active text-sky-600 dark:text-sky-400' : '' }}">
                    <i class="bi bi-briefcase text-lg flex-shrink-0"></i>
                    <span class="font-medium text-sm">Servicios</span>
                    <span class="ml-auto text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-full">{{ $totalServicios ?? '0' }}</span>
                </a>

                <!-- Tarifas -->
                <a href="{{ route('admin.tariffs.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 {{ request()->routeIs('admin.tariffs.*') ? 'active text-sky-600 dark:text-sky-400' : '' }}">
                    <i class="bi bi-tags text-lg flex-shrink-0"></i>
                    <span class="font-medium text-sm">Tarifas</span>
                    <span class="ml-auto text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 px-2 py-0.5 rounded-full">{{ $totalTarifas ?? '0' }}</span>
                </a>

                <!-- Ubicaciones -->
                <a href="{{ route('admin.locations.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 {{ request()->routeIs('admin.locations.*') ? 'active text-sky-600 dark:text-sky-400' : '' }}">
                    <i class="bi bi-geo-alt text-lg flex-shrink-0"></i>
                    <span class="font-medium text-sm">Ubicaciones</span>
                </a>

                <!-- Divider -->
                <div class="my-3 border-t border-gray-200 dark:border-slate-700"></div>

                <!-- Sección: General -->
                <div class="px-4 py-3 mb-2">
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">General</p>
                </div>

                <!-- Volver al sitio -->
                <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                    <i class="bi bi-house text-lg flex-shrink-0"></i>
                    <span class="font-medium text-sm">Volver al Sitio</span>
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="px-3 py-4 border-t border-gray-200 dark:border-slate-700 space-y-2">
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-medium text-sm">
                        <i class="bi bi-box-arrow-right text-lg flex-shrink-0"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="admin-content">
        <!-- Botón Hamburguesa para móvil -->
        <button id="sidebarToggle" class="md:hidden fixed top-24 left-4 z-50 p-2.5 bg-gradient-to-r from-sky-600 to-blue-600 text-white rounded-lg hover:from-sky-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="bi bi-list text-lg"></i>
        </button>

        <div class="flex-1 w-full p-4 md:p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-900 dark:to-slate-950">
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

    // Cerrar sidebar al hacer clic en un enlace (en móvil)
    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            }
        });
    });

    // Cerrar sidebar al hacer clic en el overlay
    document.getElementById('sidebarOverlay')?.addEventListener('click', toggleSidebar);
    
    // Toggle sidebar
    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);

    // Cerrar sidebar si se redimensiona a desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.remove('active');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
    });
</script>
@endsection
