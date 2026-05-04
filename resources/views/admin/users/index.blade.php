@extends('layouts.admin')

@section('title', 'Gestionar Usuarios - Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <div>
        <h1 class="text-5xl font-black bg-gradient-to-r from-orange-600 to-orange-700 bg-clip-text text-transparent mb-2">
            👥 Gestionar Usuarios
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Administra los usuarios registrados en la plataforma</p>
        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Total: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $users->total() }}</span> usuarios</p>
    </div>
</div>

@include('shared.alerts')

<!-- Filtro de búsqueda -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="🔍 Buscar por nombre o email..."
                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-orange-500 dark:focus:border-orange-400 transition">
        </div>
        <button type="submit" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 whitespace-nowrap shadow-md">
            <i class="bi bi-search"></i>
            Buscar
        </button>
        @if($search)
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition whitespace-nowrap">
                ✕ Limpiar
            </a>
        @endif
    </form>
</div>

<!-- Tabla de Usuarios -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b-2 border-gray-200 dark:border-gray-700">
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Usuario</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Email</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Rol</th>
                    <th class="text-left py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Registrado</th>
                    <th class="text-center py-4 px-6 text-gray-700 dark:text-gray-300 font-bold text-sm uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-orange-50 dark:hover:bg-gray-700/50 transition duration-150">
                        <td class="py-4 px-6">
                            <p class="text-gray-900 dark:text-white font-bold">{{ $user->nombre }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->email }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <select name="rol" style="display:inline-block;" onchange="this.form.submit()"
                                        class="px-3 py-1.5 rounded-full text-xs font-bold border-0 cursor-pointer transition
                                        {{ $user->rol === 'admin' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' }}">
                                    <option value="usuario" @selected($user->rol === 'usuario')>👤 Usuario</option>
                                    <option value="admin" @selected($user->rol === 'admin')>🔐 Administrador</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-gray-600 dark:text-gray-400 text-sm">
                                @if ($user->created_at)
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-center">
                                <button onclick="viewUserDetails('{{ $user->nombre }}', '{{ $user->email }}', '{{ $user->rol }}')"
                                        class="p-2.5 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition duration-200 font-semibold"
                                        title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @if ($user->rol !== 'admin' || \App\Models\User::where('rol', 'admin')->count() > 1)
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition duration-200 font-semibold" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-inbox text-4xl text-gray-300 dark:text-gray-600"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay usuarios registrados</p>
                                <p class="text-gray-400 text-sm">Los nuevos usuarios aparecerán aquí</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Paginación -->
<div class="mt-6 flex justify-center">
    <nav aria-label="pagination" class="inline-flex gap-1">
        {{ $users->links() }}
    </nav>
</div>

<!-- Modal de Detalles del Usuario -->
<div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-md w-full mx-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detalles del Usuario</h3>
                <button onclick="closeUserModal()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>
        </div>
        <div id="userModalContent" class="p-6 space-y-4">
            <!-- Content loaded via JS -->
        </div>
    </div>
</div>

<script>
function viewUserDetails(nombre, email, rol) {
    const content = `
        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Nombre</p>
                <p class="text-lg font-medium text-gray-900 dark:text-white">${nombre}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                <p class="text-lg font-medium text-gray-900 dark:text-white">${email}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Rol</p>
                <p class="text-lg font-medium"><span class="inline-block px-3 py-1 rounded-full text-sm ${
                    rol === 'admin'
                    ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'
                    : 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400'
                }">${rol === 'admin' ? 'Administrador' : 'Usuario'}</span></p>
            </div>
        </div>
    `;
    document.getElementById('userModalContent').innerHTML = content;
    document.getElementById('userModal').classList.remove('hidden');
}

function closeUserModal() {
    document.getElementById('userModal').classList.add('hidden');
}
</script>
@endsection
