<?php

namespace App\Http\Controllers;

use App\User;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Http\Request;
use App\Bitacora;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Actualizar usuario
        $user->update($request->all());

        //Actualizar roles
        $user->roles()->sync($request->get('roles'));

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Editar Usuario';
        $bitacora->save();

        return redirect()->route('users.edit', $user->id)
            ->with('info', 'Usuario actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Eliminar Usuario';
        $bitacora->save();

        return back()->with('info', 'Eliminado correctamente');
    }
}
