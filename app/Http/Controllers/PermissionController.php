<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{

  public function index()
  {
      $permisos = Permission::paginate();
      return view('permisos.index', compact('permisos'));
  }

  public function index2()
  {
      $permisos = Permission::paginate();

      return view('permisos.index', compact('permisos'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //  $permissions = Permission::get();
      return view('permisos.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $permisos = Permission::create($request->all());
      //$role->permissions()->sync($request->get('permissions'));
      if($permisos){
        Session::flash('message-success', 'Permiso guardado satisfactoriamente.');
      }else{
        Session::flash('message-warnning', 'Hubo un problema al intentar guardar el permiso.');
      }
      return redirect()->route('permisos.index');
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Permission $permiso)
  {
    return view('permisos.show', [
          'permiso'=>$permiso,
        ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Permission $permiso)
  {
    return view('permisos.edit', [
        'permiso' => $permiso,
      ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Permission $permiso)
  {
      $permiso->fill($request->all())->update();
      if($permiso){
        Session::flash('message-success', 'Permiso guardado satisfactoriamente.');
      }else{
        Session::flash('message-warnning', 'Hubo un problema al intentar guardar el permiso.');
      }
      return redirect()->route('permisos.index');
  }


}
