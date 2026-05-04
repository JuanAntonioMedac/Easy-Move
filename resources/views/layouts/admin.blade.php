@extends('layouts.app')

@section('content')
<style>
    .admin-layout {
        display: flex;
        min-height: calc(100vh - 80px);
    }

    .admin-sidebar {
        width: 256px;
        background-color: inherit;
        border-right: 1px solid;
        border-color: inherit;
        overflow-y: auto;
        position: fixed;
        left: 0;
        top: 80px;
        height: calc(100vh - 80px);
        z-index: 30;
    }

    .admin-content {
        margin-left: 256px;
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sidebar-link.active {
        background-color: rgba(59, 130, 246, 0.1);
        border-right: 3px solid #3b82f6;
        color: #3b82f6;
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            width: 100%;
            max-width: 256px;
            z-index: 40;
        }

        .admin-sidebar.active {
            transform: translateX(0);
        }

        .admin-content {
            margin-left: 0;
            width: 100%;
        }
    }
</style>

<!-- Overlay para móvil -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 hidden md:hidden z-30"></div>

<!-- Contenedor Principal -->
<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
        <nav class="p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Divider -->
            <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div>

            <!-- Sección: Gestión -->
            <div class="px-4 py-2">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gestión</p>
            </div>

            <!-- Usuarios -->
            <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people text-lg"></i>
                <span class="font-medium">Usuarios</span>
            </a>

            <!-- Proveedores -->
            <a href="{{ route('admin.providers.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition {{ request()->routeIs('admin.providers.*') ? 'active' : '' }}">
                <i class="bi bi-building text-lg"></i>
                <span class="font-medium">Proveedores</span>
            </a>

            <!-- Servicios -->
            <a href="{{ route('admin.services.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase text-lg"></i>
                <span class="font-medium">Servicios</span>
            </a>

            <!-- Tarifas -->
            <a href="{{ route('admin.tariffs.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition {{ request()->routeIs('admin.tariffs.*') ? 'active' : '' }}">
                <i class="bi bi-tags text-lg"></i>
                <span class="font-medium">Tarifas</span>
            </a>

            <!-- Ubicaciones -->
            <a href="{{ route('admin.locations.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                <i class="bi bi-map-fill text-lg"></i>
                <span class="font-medium">Ubicaciones</span>
            </a>

            <!-- Divider -->
            <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div>

            <!-- Sección: Otros -->
            <div class="px-4 py-2">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Otros</p>
            </div>

            <!-- Volver al sitio -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                <i class="bi bi-house text-lg"></i>
                <span class="font-medium">Volver al Sitio</span>
            </a>

            <!-- Cerrar Sesión -->
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                    <i class="bi bi-box-arrow-right text-lg"></i>
                    <span class="font-medium">Cerrar Sesión</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Contenido Principal -->
    <main class="admin-content">
        <!-- Botón Hamburguesa para móvil -->
        <button id="sidebarToggle" onclick="toggleSidebar()" class="md:hidden fixed top-24 left-4 z-50 p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="bi bi-list text-xl"></i>
        </button>

        <div class="flex-1 w-full p-4 md:p-8">
            @yield('admin-content')
        </div>
    </main>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('active');
    overlay.classList.toggle('hidden');
}

// Cerrar sidebar al hacer clic en un enlace (en móvil)
document.querySelectorAll('.admin-sidebar a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth < 768) {
            const sidebar = document.querySelector('.admin-sidebar');
            if (sidebar.classList.contains('active')) {
                toggleSidebar();
            }
        }
    });
});

// Cerrar sidebar al hacer clic en el overlay
document.getElementById('sidebarOverlay')?.addEventListener('click', toggleSidebar);
</script>
@endsection
