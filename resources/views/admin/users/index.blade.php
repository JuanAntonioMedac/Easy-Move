@extends('layouts.admin')

@section('title', 'Usuarios · Admin EasyMove')

@section('admin-content')
<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-fuchsia-500 grid place-items-center text-white shadow-lg shadow-rose-500/30">
            <i class="bi bi-people-fill text-xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">Usuarios</h1>
    </div>
    <p class="text-sm text-slate-500 dark:text-slate-400">Total: <span class="font-bold text-slate-700 dark:text-slate-200">{{ $users->total() }}</span> usuarios registrados</p>
</div>

@include('shared.alerts')

<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 mb-6">
    <form method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre o email…"
                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all">
        </div>
        <button type="submit" class="btn-brand ring-brand inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-white font-bold whitespace-nowrap">
            <i class="bi bi-search"></i>Buscar
        </button>
        @if($search)
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-bold whitespace-nowrap transition">
                <i class="bi bi-x-lg"></i>Limpiar
            </a>
        @endif
    </form>
</div>

<div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800">
                <tr>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Usuario</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Email</th>
                    <th class="text-left py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Registrado</th>
                    <th class="text-right py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $user->rol === 'admin' ? 'from-rose-500 to-fuchsia-500' : 'from-sky-500 to-indigo-500' }} grid place-items-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($user->nombre, 0, 1)) }}
                                </div>
                                <p class="font-bold text-slate-900 dark:text-white">{{ $user->nombre }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                        <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-400">
                            {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 justify-end">
                                <button onclick="viewUserDetails(@js($user->nombre), @js($user->email), @js($user->rol))" title="Ver detalles" class="p-2.5 rounded-lg text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                @if ($user->rol !== 'admin' || \App\Models\User::where('rol', 'admin')->count() > 1)
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Eliminar" class="p-2.5 rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 px-6 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl grid place-items-center bg-slate-100 dark:bg-slate-800 text-slate-400">
                                <i class="bi bi-inbox text-2xl"></i>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 font-semibold">No hay usuarios registrados</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $users->links() }}</div>

{{-- Modal detalles --}}
<div id="userModal" class="hidden fixed inset-0 bg-slate-900/70 backdrop-blur-md flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-md w-full border border-slate-200 dark:border-slate-700 overflow-hidden animate-fade-in-up">
        <div class="bg-gradient-to-r from-rose-500 to-fuchsia-500 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="bi bi-person-badge"></i>Detalles del usuario
            </h3>
            <button onclick="closeUserModal()" class="text-white/90 hover:text-white text-xl leading-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div id="userModalContent" class="p-6 space-y-4"></div>
    </div>
</div>

<script>
function viewUserDetails(nombre, email, rol) {
    const isAdmin = rol === 'admin';
    document.getElementById('userModalContent').innerHTML = `
        <div class="flex items-center gap-4 mb-2">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br ${isAdmin ? 'from-rose-500 to-fuchsia-500' : 'from-sky-500 to-indigo-500'} grid place-items-center text-white text-2xl font-extrabold shadow-lg">
                ${nombre.charAt(0).toUpperCase()}
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-bold text-slate-500 dark:text-slate-400">Nombre</p>
                <p class="text-lg font-bold text-slate-900 dark:text-white">${nombre}</p>
            </div>
        </div>
        <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 p-3">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1"><i class="bi bi-envelope"></i> Email</p>
            <p class="text-sm font-medium text-slate-900 dark:text-white break-all">${email}</p>
        </div>
        <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 p-3">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1"><i class="bi bi-shield-lock"></i> Rol</p>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold ${isAdmin ? 'bg-rose-100 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300' : 'bg-sky-100 dark:bg-sky-950/50 text-sky-700 dark:text-sky-300'}">
                <i class="bi bi-${isAdmin ? 'shield-fill' : 'person-fill'}"></i>${isAdmin ? 'Administrador' : 'Usuario'}
            </span>
        </div>
    `;
    document.getElementById('userModal').classList.remove('hidden');
}
function closeUserModal() { document.getElementById('userModal').classList.add('hidden'); }
</script>
@endsection
