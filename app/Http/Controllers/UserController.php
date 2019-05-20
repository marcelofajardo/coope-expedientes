<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Expediente;
use App\ExpedienteUsuarios;
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
            return view('users.index', [
                  'users' => $users,
            ]);
      }

      public function show($id)
      {
            $user = User::find($id);
            $roles = $user->roles();
            return view('users.show', [
             'user' => $user,
            ]);
      }

      /*
      public function activo($id)
      {
            $user = User::find($id);
            ($user->estado == 'Activo')?$user->estado='Inactivo':$user->estado='Activo';
            $user->save();
            return back();
      }
      */
      public function edit($id)
      {
            $user = User::find($id);
            if(Auth::user()->getRoles()[0] != 'admin')
            {
                  $roles = Role::where('slug', '!=', 'admin')->get();
            }else{
                  $roles = Role::get();
            }
            return view('users.edit', [
                'user' => $user,
                'roles' => $roles
            ]);
      }
      public function activo($id)
      {
            $user = User::find($id);
            ($user->estado == 'Activo')?$user->estado = 'Inactivo':$user->estado = 'Activo';
            $guardado = $user->save();
            $users = User::paginate();
            if($guardado){

                return redirect()->route('users.index')
                    ->with('success', 'Usuario guardado con éxito');
            }else{
                return redirect()->route('users.index')
                    ->with('danger', 'Ocurrió un error al intentaractualizar el usuario');
            }

            return view('users.index', [
                'users' => $users
            ]);
      }

      public function create()
      {
            $roles = Role::get();
            return view('users.create', compact('roles'));
      }
      public function store(Request $request)
      {
            $au = new User();
            $au->name = $request->name;
            $au->email = $request->email;
            $au->estado = 'Activo';
            $au->password = bcrypt($request->password);

            if ($au->save())
            {
                  $role = Role::where('name', 'Usuario')->get();
                  $rolid = $role[0]->id;
                  $insertar = DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$rolid, $au->id]);

                  if($insertar)
                  {
                        return redirect()->route('users.index')
                            ->with('success', 'Usuario guardado con éxito');
                  }else{
                        return redirect()->route('users.index')
                            ->with('danger', 'Ocurrió un error al intentar crear un nuevo usuario');
                  }

            }else{
                  return redirect()->route('users.index')
                      ->with('danger', 'Ocurrió un error al intentar crear un nuevo usuario');
            }

      }


    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        $user->roles()->sync($request->get('roles'));
        return redirect()->route('users.edit', $user->id)
            ->with('success', 'Usuario guardado con éxito');
    }

    public function destroy($id)
    {
            $user = User::find($id);
            //$admin = $user->getRoles()[0];
            //dd($admin);
            $administradores = DB::Select ("
                  SELECT
                  COUNT(u.id) AS cantidad
                  FROM
                  users u, roles r, role_user
                  WHERE
                  role_user.`role_id` = r.`id`
                  AND
                  role_user.`user_id` = u.`id`
                  AND
                  r.name = 'Administrador'
            ");
            $cantidadAdmin = $administradores[0]->cantidad;

            $expedientes = Expediente::where('user_id', $id)->count();
            $expUsuario =  ExpedienteUsuarios::where('user_id', $id)->count();
            if($cantidadAdmin == 1)
            {
                return redirect()->route('users.index')->with('danger', 'El Usuario no puede ser borrado porque es el único Administrador');
            }
            if (($expedientes > 0) OR ($expUsuario > 0))
            {
                return redirect()->route('users.index')->with('danger', 'El Usuario no puede ser borrado porque tiene Expedientes Asignados');

            }else{

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
               return back()->with('success', 'Usuario Eliminado correctamente!!!');
            }

    }
}
