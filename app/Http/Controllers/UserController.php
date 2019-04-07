<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\DB;
use App\User;

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

    public function show($id)
    {
        $user = User::find($id);
        $roles = $user->roles();
        
        return view('users.show', [
             'user' => $user,
       ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('adminlte::auth.register');
        //return view('users.create', compact('roles'));
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        $user->roles()->sync($request->get('roles'));
        return redirect()->route('users.edit', $user->id)
            ->with('info', 'Usuario guardado con éxito');
    }

    public function destroy($id)
    {
          $roles_usuarios = DB::select("SELECT * FROM role_user WHERE user_id=" . $id);
          if ($roles_usuarios)
          {
                DB::delete("DELETE FROM role_user WHERE user_id=" . $id);
          }
          $perfil = DB::select("SELECT * FROM profile WHERE user_id=" . $id);
          if ($perfil)
          {
                DB::delete("DELETE FROM profile WHERE user_id=" . $id);
          }
          $user = User::find($id)->delete();
          return back()->with('info', 'Eliminado correctamente');
    }
}
