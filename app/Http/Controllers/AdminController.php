<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Servicio;
use App\Models\Tarifa;
use App\Models\TipoServicio;
use App\Models\Ubicacion;
use App\Models\User;
use App\Models\Comparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Dashboard - Mostrar estadísticas principales
     */
    public function dashboard()
    {
        $totalUsuarios = User::count();
        $totalProveedores = Proveedor::count();
        $totalServicios = Servicio::count();
        $totalTarifas = Tarifa::count();
        $totalUbicaciones = Ubicacion::count();

        // Búsquedas últimos 7 días
        $busquedasUltimaSemana = Comparacion::where('fecha', '>=', now()->subDays(7))->count();
        
        // Búsquedas semana anterior
        $busquedasSemanaAnterior = Comparacion::whereBetween('fecha', [
            now()->subDays(14),
            now()->subDays(7)
        ])->count();
        
        // Calcular porcentaje de cambio en búsquedas
        $porcentajeBusquedas = $busquedasSemanaAnterior > 0 
            ? round((($busquedasUltimaSemana - $busquedasSemanaAnterior) / $busquedasSemanaAnterior) * 100)
            : 0;

        // Usuarios nuevos últimos 7 días (usando fecha_registro)
        $usuariosNuevos = User::where('fecha_registro', '>=', now()->subDays(7))->count();

        // Búsquedas por día (últimos 7 días)
        $busquedasPorDia = [];
        $diasNombres = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        
        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subDays($i);
            $count = Comparacion::whereDate('fecha', $fecha->toDateString())->count();
            $busquedasPorDia[] = $count;
        }

        // Proveedores más buscados (con servicios)
        $proveedoresMasBuscados = Proveedor::withCount('servicios')
            ->orderBy('servicios_count', 'desc')
            ->take(5)
            ->get();

        // Tipos de servicio más demandados
        $tiposMasDemandados = TipoServicio::withCount('servicios')
            ->orderBy('servicios_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalUsuarios' => $totalUsuarios,
            'totalProveedores' => $totalProveedores,
            'totalServicios' => $totalServicios,
            'totalTarifas' => $totalTarifas,
            'totalUbicaciones' => $totalUbicaciones,
            'busquedasUltimaSemana' => $busquedasUltimaSemana,
            'busquedasPorDia' => $busquedasPorDia,
            'porcentajeUsuarios' => 0,
            'porcentajeBusquedas' => $porcentajeBusquedas,
            'usuariosNuevos' => $usuariosNuevos,
            'proveedoresMasBuscados' => $proveedoresMasBuscados,
            'tiposMasDemandados' => $tiposMasDemandados,
        ]);
    }

    // ========================================================================
    // CRUD PROVEEDORES
    // ========================================================================

    public function indexProviders(Request $request)
    {
        $search = $request->input('search');

        $proveedores = Proveedor::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('web', 'like', "%{$search}%");
            })
            ->with('servicios')
            ->paginate(15);

        return view('admin.providers.index', [
            'proveedores' => $proveedores,
            'search' => $search,
        ]);
    }

    public function createProvider()
    {
        return view('admin.providers.create');
    }

    public function storeProvider(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:proveedores,nombre'],
            'web' => ['nullable', 'url'],
            'logo' => ['nullable'],
            'logo_type' => ['nullable', 'in:file,url'],
            'tipo_proveedor' => ['required', 'string', 'max:255'],
            'api_disponible' => ['boolean'],
        ]);

        // Manejar logo: archivo o URL
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        } elseif ($request->filled('logo') && $request->input('logo_type') === 'url') {
            // Validar que sea una URL válida
            if (filter_var($request->input('logo'), FILTER_VALIDATE_URL)) {
                $validated['logo'] = $request->input('logo');
            } else {
                return redirect()->back()->withErrors(['logo' => 'La URL del logo no es válida.'])->withInput();
            }
        }

        $validated['api_disponible'] = $request->has('api_disponible');
        unset($validated['logo_type']); // No guardar logo_type en BD

        Proveedor::create($validated);

        return redirect()->route('admin.providers.index')
                        ->with('success', 'Proveedor creado exitosamente.');
    }

    public function editProvider(Proveedor $proveedor)
    {
        return view('admin.providers.edit', [
            'proveedor' => $proveedor,
        ]);
    }

    public function updateProvider(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:proveedores,nombre,' . $proveedor->id_proveedor . ',id_proveedor'],
            'web' => ['nullable', 'url'],
            'logo' => ['nullable'],
            'logo_type' => ['nullable', 'in:file,url'],
            'tipo_proveedor' => ['required', 'string', 'max:255'],
            'api_disponible' => ['boolean'],
        ]);

        // Manejar logo: archivo o URL
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe y es local (no URL)
            if ($proveedor->logo && !filter_var($proveedor->logo, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($proveedor->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        } elseif ($request->filled('logo') && $request->input('logo_type') === 'url') {
            // Validar que sea una URL válida
            if (filter_var($request->input('logo'), FILTER_VALIDATE_URL)) {
                // Eliminar logo anterior si existe y es local
                if ($proveedor->logo && !filter_var($proveedor->logo, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($proveedor->logo);
                }
                $validated['logo'] = $request->input('logo');
            } else {
                return redirect()->back()->withErrors(['logo' => 'La URL del logo no es válida.'])->withInput();
            }
        }

        $validated['api_disponible'] = $request->has('api_disponible');
        unset($validated['logo_type']); // No guardar logo_type en BD

        $proveedor->update($validated);

        return redirect()->route('admin.providers.index')
                        ->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroyProvider(Proveedor $proveedor)
    {
        if ($proveedor->servicios()->exists()) {
            return redirect()->route('admin.providers.index')
                            ->with('error', 'No puedes eliminar un proveedor con servicios asociados.');
        }

        // Solo eliminar si es archivo local, no si es URL
        if ($proveedor->logo && !filter_var($proveedor->logo, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($proveedor->logo);
        }

        $proveedor->delete();

        return redirect()->route('admin.providers.index')
                        ->with('success', 'Proveedor eliminado exitosamente.');
    }

    // ========================================================================
    // CRUD SERVICIOS
    // ========================================================================

    public function indexServices(Request $request)
    {
        $search = $request->input('search');
        $filterProveedor = $request->input('proveedor');
        $filterTipo = $request->input('tipo');

        $servicios = Servicio::query()
            ->with('proveedor', 'tipoServicio')
            ->when($search, function ($q) use ($search) {
                $q->where('nombre_servicio', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            })
            ->when($filterProveedor, function ($q) use ($filterProveedor) {
                $q->where('id_proveedor', $filterProveedor);
            })
            ->when($filterTipo, function ($q) use ($filterTipo) {
                $q->where('id_tipo_servicio', $filterTipo);
            })
            ->paginate(15);

        $proveedores = Proveedor::all();
        $tiposServicios = TipoServicio::all();

        return view('admin.services.index', [
            'servicios' => $servicios,
            'proveedores' => $proveedores,
            'tiposServicios' => $tiposServicios,
            'search' => $search,
            'filterProveedor' => $filterProveedor,
            'filterTipo' => $filterTipo,
        ]);
    }

    public function createService()
    {
        $proveedores = Proveedor::all();
        $tiposServicios = TipoServicio::all();

        return view('admin.services.create', [
            'proveedores' => $proveedores,
            'tiposServicios' => $tiposServicios,
        ]);
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'nombre_servicio' => ['required', 'string', 'max:255', 'unique:servicios,nombre_servicio'],
            'descripcion' => ['nullable', 'string'],
            'id_tipo_servicio' => ['required', 'integer', 'exists:tipos_servicios,id_tipo_servicio'],
            'id_proveedor' => ['required', 'integer', 'exists:proveedores,id_proveedor'],
        ]);

        Servicio::create($validated);

        return redirect()->route('admin.services.index')
                        ->with('success', 'Servicio creado exitosamente.');
    }

    public function editService(Servicio $servicio)
    {
        $proveedores = Proveedor::all();
        $tiposServicios = TipoServicio::all();

        return view('admin.services.edit', [
            'servicio' => $servicio,
            'proveedores' => $proveedores,
            'tiposServicios' => $tiposServicios,
        ]);
    }

    public function updateService(Request $request, Servicio $servicio)
    {
        $validated = $request->validate([
            'nombre_servicio' => ['required', 'string', 'max:255', 'unique:servicios,nombre_servicio,' . $servicio->id_servicio . ',id_servicio'],
            'descripcion' => ['nullable', 'string'],
            'id_tipo_servicio' => ['required', 'integer', 'exists:tipos_servicios,id_tipo_servicio'],
            'id_proveedor' => ['required', 'integer', 'exists:proveedores,id_proveedor'],
        ]);

        $servicio->update($validated);

        return redirect()->route('admin.services.index')
                        ->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroyService(Servicio $servicio)
    {
        if ($servicio->tarifas()->exists()) {
            return redirect()->route('admin.services.index')
                            ->with('error', 'No puedes eliminar un servicio con tarifas asociadas.');
        }

        $servicio->delete();

        return redirect()->route('admin.services.index')
                        ->with('success', 'Servicio eliminado exitosamente.');
    }

    // ========================================================================
    // CRUD TARIFAS
    // ========================================================================

    public function indexTariffs(Request $request)
    {
        $search = $request->input('search');

        $tarifas = Tarifa::query()
            ->with('servicio.proveedor', 'disponibilidades.ubicacion')
            ->when($search, function ($q) use ($search) {
                $q->where('nombre_tarifa', 'like', "%{$search}%");
            })
            ->paginate(15);

        return view('admin.tariffs.index', [
            'tarifas' => $tarifas,
            'search' => $search,
        ]);
    }

    public function createTariff()
    {
        $servicios = Servicio::with('proveedor', 'tipoServicio')->get();
        $ubicaciones = Ubicacion::orderBy('codigo_postal')->get();

        return view('admin.tariffs.create', [
            'servicios' => $servicios,
            'ubicaciones' => $ubicaciones,
        ]);
    }

    public function storeTariff(Request $request)
    {
        $validated = $request->validate([
            'nombre_tarifa' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'unidad_precio' => ['required', 'string', 'max:50'],
            'permanencia' => ['nullable', 'string', 'in:1mes,3meses,6meses,12meses,sin_permanencia'],
            'condiciones' => ['nullable', 'string'],
            'url_oferta_externa' => ['nullable', 'url'],
            'id_servicio' => ['required', 'integer', 'exists:servicios,id_servicio'],
            'ubicaciones' => ['nullable', 'array'],
            'ubicaciones.*' => ['integer', 'exists:ubicaciones,id_ubicacion'],
        ]);

        $ubicaciones = $validated['ubicaciones'] ?? [];
        unset($validated['ubicaciones']);

        $tarifa = Tarifa::create($validated);

        // Asociar códigos postales si se seleccionaron
        if (!empty($ubicaciones)) {
            $tarifa->ubicaciones()->attach($ubicaciones);
        }

        return redirect()->route('admin.tariffs.index')
                        ->with('success', 'Tarifa creada exitosamente.');
    }

    public function editTariff(Tarifa $tarifa)
    {
        $servicios = Servicio::with('proveedor', 'tipoServicio')->get();
        $ubicaciones = Ubicacion::orderBy('codigo_postal')->get();
        $tarifa->load('ubicaciones');

        return view('admin.tariffs.edit', [
            'tarifa' => $tarifa,
            'servicios' => $servicios,
            'ubicaciones' => $ubicaciones,
        ]);
    }

    public function updateTariff(Request $request, Tarifa $tarifa)
    {
        $validated = $request->validate([
            'nombre_tarifa' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'unidad_precio' => ['required', 'string', 'max:50'],
            'permanencia' => ['nullable', 'string', 'in:1mes,3meses,6meses,12meses,sin_permanencia'],
            'condiciones' => ['nullable', 'string'],
            'url_oferta_externa' => ['nullable', 'url'],
            'id_servicio' => ['required', 'integer', 'exists:servicios,id_servicio'],
            'ubicaciones' => ['nullable', 'array'],
            'ubicaciones.*' => ['integer', 'exists:ubicaciones,id_ubicacion'],
        ]);

        $ubicaciones = $validated['ubicaciones'] ?? [];
        unset($validated['ubicaciones']);

        $tarifa->update($validated);

        // Sincronizar códigos postales
        $tarifa->ubicaciones()->sync($ubicaciones);

        return redirect()->route('admin.tariffs.index')
                        ->with('success', 'Tarifa actualizada exitosamente.');
    }

    public function destroyTariff(Tarifa $tarifa)
    {
        $tarifa->delete();

        return redirect()->route('admin.tariffs.index')
                        ->with('success', 'Tarifa eliminada exitosamente.');
    }

    // ========================================================================
    // CRUD USUARIOS
    // ========================================================================

    public function indexUsers(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(15);

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function updateUserRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'rol' => ['required', 'string', 'in:admin,usuario'],
        ]);

        // Prevent removing last admin
        if ($user->rol === 'admin' && $validated['rol'] === 'usuario') {
            $adminCount = User::where('rol', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')
                                ->with('error', 'No puedes eliminar el último administrador.');
            }
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Rol de usuario actualizado.');
    }

    public function destroyUser(User $user)
    {
        // Prevent deleting last admin
        if ($user->rol === 'admin') {
            $adminCount = User::where('rol', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')
                                ->with('error', 'No puedes eliminar el último administrador.');
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'Usuario eliminado exitosamente.');
    }

    // ========================================================================
    // UBICACIONES / CÓDIGOS POSTALES
    // ========================================================================

    public function indexLocations(Request $request)
    {
        $search = $request->input('search');

        $ubicaciones = Ubicacion::query()
            ->when($search, function ($q) use ($search) {
                $q->where('codigo_postal', 'like', "%{$search}%")
                  ->orWhere('ciudad', 'like', "%{$search}%")
                  ->orWhere('provincia', 'like', "%{$search}%");
            })
            ->orderBy('codigo_postal')
            ->paginate(15);

        return view('admin.locations.index', [
            'ubicaciones' => $ubicaciones,
            'search' => $search,
        ]);
    }

    public function createLocation()
    {
        return view('admin.locations.create');
    }

    public function storeLocation(Request $request)
    {
        $validated = $request->validate([
            'codigo_postal' => ['required', 'string', 'max:20', 'unique:ubicaciones,codigo_postal'],
            'ciudad' => ['required', 'string', 'max:255'],
            'provincia' => ['required', 'string', 'max:255'],
        ]);

        Ubicacion::create($validated);

        return redirect()->route('admin.locations.index')
                        ->with('success', 'Ubicación creada exitosamente.');
    }

    public function editLocation(Ubicacion $ubicacion)
    {
        return view('admin.locations.edit', [
            'ubicacion' => $ubicacion,
        ]);
    }

    public function updateLocation(Request $request, Ubicacion $ubicacion)
    {
        $validated = $request->validate([
            'codigo_postal' => ['required', 'string', 'max:20', 'unique:ubicaciones,codigo_postal,' . $ubicacion->id_ubicacion . ',id_ubicacion'],
            'ciudad' => ['required', 'string', 'max:255'],
            'provincia' => ['required', 'string', 'max:255'],
        ]);

        $ubicacion->update($validated);

        return redirect()->route('admin.locations.index')
                        ->with('success', 'Ubicación actualizada exitosamente.');
    }

    public function destroyLocation(Ubicacion $ubicacion)
    {
        if ($ubicacion->disponibilidades()->exists()) {
            return redirect()->route('admin.locations.index')
                            ->with('error', 'No puedes eliminar una ubicación con disponibilidades asociadas.');
        }

        $ubicacion->delete();

        return redirect()->route('admin.locations.index')
                        ->with('success', 'Ubicación eliminada exitosamente.');
    }
}
