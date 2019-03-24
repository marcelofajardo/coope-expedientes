<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
      Route::post('posts/{post}/comment', 'CommentController@store')->name('comments.store');

      /*
	Route::group(['prefix' => 'rol'], function () {
        Route::get('listado', 'RolController@index')->name('rol.index');
        Route::get('nueva', 'RolController@create')->name('rol.create');
        Route::post('nueva', 'RolController@store')->name('rol.store');
        Route::get('editar/{rol}', 'RolController@edit')->name('rol.edit');
        Route::get('ver/{rol}', 'RolController@show')->name('rol.show');
        Route::patch('editar/{rol}', 'RolController@update')->name('rol.update');
        Route::get('eliminar/{rol}', 'RolController@destroy')->name('rol.delete');
        Route::get('restaurar', 'RolController@eliminated')->name('rol.eliminated');
        Route::get('restore/{rol}', 'RolController@restore')->name('rol.restore');
    });
    */
    Route::group(['prefix' => 'clasificacion'], function () {

        Route::get('listado', 'ClasificacionAnexoController@index')->name('clasificacion.index')->middleware('permission:clasificacion.index');
        Route::get('nueva', 'ClasificacionAnexoController@create')->name('clasificacion.create')->middleware('permission:clasificacion.create');
        Route::post('nueva', 'ClasificacionAnexoController@store')->name('clasificacion.store')->middleware('permission:clasificacion.store');
        Route::get('editar/{clasificacionAnexo}', 'ClasificacionAnexoController@edit')->name('clasificacion.edit')->middleware('permission:clasificacion.edit');
        Route::get('ver/{clasificacionAnexo}', 'ClasificacionAnexoController@show')->name('clasificacion.show')->middleware('permission:clasificacion.show');
        Route::patch('editar/{clasificacionAnexo}', 'ClasificacionAnexoController@update')->name('clasificacion.update')->middleware('permission:clasificacion.update');
        Route::get('eliminar/{clasificacionAnexo}', 'ClasificacionAnexoController@destroy')->name('clasificacion.delete')->middleware('permission:clasificacion.delete');

    });

    Route::group(['prefix' => 'log'], function () {

        Route::get('listado', 'LogController@index')->name('log.index')->middleware('permission:log.index');
        Route::get('nueva', 'LogController@create')->name('log.create')->middleware('permission:log.create');
        Route::post('nueva', 'LogController@store')->name('log.store')->middleware('permission:log.store');
        Route::get('editar/{log}', 'LogController@edit')->name('log.edit')->middleware('permission:log.edit');
        Route::get('ver/{log}', 'LogController@show')->name('log.show')->middleware('permission:log.show');
        Route::patch('editar/{log}', 'LogController@update')->name('log.update')->middleware('permission:log.update');
        Route::get('eliminar/{log}', 'LogController@destroy')->name('log.delete')->middleware('permission:log.delete');
    });

    Route::group(['prefix' => 'anexo'], function () {
        Route::get('create_exp{expediente}', 'AnexoController@create_exp')->name('anexo.create_exp')->middleware('permission:anexo.create_exp');
        Route::get('listado', 'AnexoController@index')->name('anexo.index')->middleware('permission:anexo.index');
        Route::get('nueva', 'AnexoController@create')->name('anexo.create')->middleware('permission:anexo.create');
        Route::post('nueva', 'AnexoController@store')->name('anexo.store')->middleware('permission:anexo.store');
        Route::get('editar/{anexo}', 'AnexoController@edit')->name('anexo.edit')->middleware('permission:anexo.edit');
        Route::get('ver/{anexo}', 'AnexoController@show')->name('anexo.show')->middleware('permission:anexo.show');
        Route::patch('editar/{anexo}', 'AnexoController@update')->name('anexo.update')->middleware('permission:anexo.update');
        Route::get('eliminar/{anexo}', 'AnexoController@destroy')->name('anexo.delete')->middleware('permission:anexo.delete');
        Route::get('eliminarAjax/{id}', 'AnexoController@destroyAjax')->name('anexo.deleteAjax')->middleware('permission:anexo.deleteAjax');

    });



    Route::group(['prefix' => 'expediente'], function () {

        Route::get('listado', 'ExpedienteController@index')->name('expediente.index')->middleware('permission:expediente.index');
        Route::get('agregarAnexo/{expediente}', 'ExpedienteController@agregarAnexo')->name('expediente.agregarAnexo')->middleware('permission:expediente.agregarAnexo');
        Route::get('nueva', 'ExpedienteController@create')->name('expediente.create')->middleware('permission:expediente.create');
        Route::post('nueva', 'ExpedienteController@store')->name('expediente.store')->middleware('permission:expediente.store');
        Route::get('editar/{expediente}', 'ExpedienteController@edit')->name('expediente.edit')->middleware('permission:expediente.edit');
        Route::patch('editar/{expediente}', 'ExpedienteController@update')->name('expediente.update')->middleware('permission:expediente.update');
        Route::get('ver/{expediente}', 'ExpedienteController@show')->name('expediente.show')->middleware('permission:expediente.show');
        Route::get('eliminar/{expediente}', 'ExpedienteController@destroy')->name('expediente.delete')->middleware('permission:expediente.delete');

    });

    Route::group(['prefix' => 'tipoexpediente'], function () {

        Route::get('listado', 'TipoExpedienteController@index')->name('tipoexpediente.index')->middleware('permission:tipoexpediente.index');
        Route::get('nueva', 'TipoExpedienteController@create')->name('tipoexpediente.create')->middleware('permission:tipoexpediente.create');
        Route::post('nueva', 'TipoExpedienteController@store')->name('tipoexpediente.store')->middleware('permission:tipoexpediente.store');
        Route::get('editar/{tipoExpediente}', 'TipoExpedienteController@edit')->name('tipoexpediente.edit')->middleware('permission:tipoexpediente.edit');
        Route::get('ver/{tipoExpediente}', 'TipoExpedienteController@show')->name('tipoexpediente.show')->middleware('permission:tipoexpediente.show');
        Route::patch('editar/{tipoExpediente}', 'TipoExpedienteController@update')->name('tipoexpediente.update')->middleware('permission:tipoexpediente.update');
        Route::get('eliminar/{tipoExpediente}', 'TipoExpedienteController@destroy')->name('tipoexpediente.delete')->middleware('permission:tipoexpediente.delete');

    });

    Route::group(['prefix' => 'task'], function () {

        Route::get('listado', 'TaskController@index')->name('task.index');
        Route::get('nueva', 'TaskController@create')->name('task.create');
        Route::post('nueva', 'TaskController@store')->name('task.store');
        Route::get('editar/{task}', 'TaskController@edit')->name('task.edit');
        Route::get('ver/{task}', 'TaskController@show')->name('task.show');
        Route::patch('editar/{task}', 'TaskController@update')->name('task.update');
        Route::get('eliminar/{task}', 'TaskController@destroy')->name('task.delete');
        Route::get('restaurar', 'TaskController@eliminated')->name('task.eliminated');
        Route::get('restore/{task}', 'TaskController@restore')->name('task.restore');
    });

    Route::group(['prefix' => 'notificacion'], function () {

        Route::get('listado', 'NotificacionController@index')->name('notificacion.index')->middleware('permission:notificacion.index');
        Route::get('nueva', 'NotificacionController@create')->name('notificacion.create')->middleware('permission:notificacion.create');
        Route::post('nueva', 'NotificacionController@store')->name('notificacion.store')->middleware('permission:notificacion.store');
        Route::get('editar/{notificacion}', 'NotificacionController@edit')->name('notificacion.edit')->middleware('permission:notificacion.edit');
        Route::get('ver/{notificacion}', 'NotificacionController@show')->name('notificacion.show')->middleware('permission:notificacion.show');
        Route::patch('editar/{notificacion}', 'NotificacionController@update')->name('notificacion.update')->middleware('permission:notificacion.update');
        Route::get('eliminar/{notificacion}', 'NotificacionController@destroy')->name('notificacion.delete')->middleware('permission:notificacion.delete');
    });

    Route::group(['prefix' => 'profile'], function () {
        // Profiles
        Route::get('listado', 'ProfileController@index')->name('profile.index')->middleware('permission:profile.index');
        Route::get('nueva', 'ProfileController@create')->name('profile.create')->middleware('permission:profile.create');
        Route::post('nueva', 'ProfileController@store')->name('profile.store')->middleware('permission:profile.store');
        Route::get('editar/{profile}', 'ProfileController@edit')->name('profile.edit')->middleware('permission:profile.edit');
        Route::get('ver/{profile}', 'ProfileController@show')->name('profile.show')->middleware('permission:profile.show');
        Route::patch('editar/{profile}', 'ProfileController@update')->name('profile.update')->middleware('permission:profile.update');
        Route::get('eliminar/{profile}', 'ProfileController@destroy')->name('profile.delete')->middleware('permission:profile.delete');
    });


      Route::get('roles', 'RoleController@index')->name('roles.index')->middleware('permission:roles.index');
      Route::post('roles/store', 'RoleController@store')->name('roles.store')->middleware('permission:roles.create');
	Route::get('roles/create', 'RoleController@create')->name('roles.create')->middleware('permission:roles.create');
	Route::put('roles/{role}', 'RoleController@update')->name('roles.update')->middleware('permission:roles.edit');
	Route::get('roles/{role}', 'RoleController@show')->name('roles.show')->middleware('permission:roles.show');
	Route::delete('roles/{role}', 'RoleController@destroy')->name('roles.destroy')->middleware('permission:roles.destroy');
	Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit')->middleware('permission:roles.edit');


      // permisos
      Route::post('permisos/store', 'PermissionController@store')->name('permisos.store')->middleware('permission:permisos.create');
      Route::get('permisos', 'PermissionController@index')->name('permisos.index')->middleware('permission:permisos.index');
      Route::get('permisos/create', 'PermissionController@create')->name('permisos.create')->middleware('permission:permisos.create');
      Route::put('permisos/{permiso}', 'PermissionController@update')->name('permisos.update')->middleware('permission:permisos.edit');
      Route::get('permisos/{permiso}', 'PermissionController@show')->name('permisos.show')->middleware('permission:permisos.show');
      Route::delete('permisos/{permiso}', 'PermissionController@destroy')->name('permisos.destroy')->middleware('permission:permisos.destroy');
      Route::get('permisos/{permiso}', 'PermissionController@edit')->name('permisos.edit')->middleware('permission:permisos.edit');
      Route::patch('permisos/{permiso}', 'PermissionController@update')->name('permisos.update')->middleware('permission:permisos.update');

	//Users
	Route::get('users', 'UserController@index')->name('users.index')->middleware('permission:users.index');
      Route::post('users/store', 'UserController@store')->name('users.store')->middleware('permission:users.create');
      Route::get('users/create', 'UserController@create')->name('users.create')->middleware('permission:users.create');
	Route::put('users/{user}', 'UserController@update')->name('users.update')->middleware('permission:users.update');
	Route::get('users/{user}', 'UserController@show')->name('users.show')->middleware('permission:users.show');
	Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
	Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit')->middleware('permission:users.edit');


});