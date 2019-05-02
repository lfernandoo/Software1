<?php

namespace App\Http\Controllers;

use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Http\Request;
use App\Bitacora;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create($request->all());

        //Actualizar permisos
        $role->permissions()->sync($request->get('permissions'));

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Insertar Rol';
        $bitacora->save();

        return redirect()->route('roles.edit', $role->id)
            ->with('info', 'Rol guardado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //Actualizar rol
        $role->update($request->all());

        //Actualizar permisos
        $role->permissions()->sync($request->get('permissions'));

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Editar Rol';
        $bitacora->save();

        return redirect()->route('roles.edit', $role->id)
            ->with('info', 'Rol actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Eliminar Rol';
        $bitacora->save();

        return back()->with('info', 'Eliminado correctamente');
    }
}
