<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Auditoria;
use Illuminate\Support\Facades\Auth;


class ClasificacionAnexo extends Model
{
      use SoftDeletes;

      protected $dates = ['deleted_at'];
      protected $table = 'clasificacion_anexo';
      protected $fillable = ['nombre', 'slug'];
      public function getRouteKeyName()
      {
            return 'slug';
      }

      public function setNombreAttribute($val)
      {
            $this->attributes['nombre'] = trim($val);
            $this->attributes['slug'] = str_slug($val);
      }

      public function anexo()
      {
            return $this->hasMany('App\Anexo', 'clasificacion_id');
      }

      public function user()
      {
          return $this->belongsTo('App\User');
      }
      public static function boot() {
            parent::boot();
            static::creating(function ($clasificacion) {

            });
            static::updating(function($data)
            {
            });
            static::deleted(function($clasificacion)
            {
                $au = new Auditoria();
                $au->user_id = Auth::user()->id;
                $au->username = Auth::user()->name;
                $au->componente_id = $clasificacion->id;
                $au->modelo = 'ClasificacionAnexo';
                $au->accion = 'Se acaba de Borrar una Clasificación de los Anexos';
                $au->descripcion = 'Se borro la Clasificación de un Anexo: ' . $clasificacion->nombre . ' !!!';
                $au->save();
            });
            static::updated(function($clasificacion) {
                $au = new Auditoria();
                $au->user_id = Auth::user()->id;
                $au->username = Auth::user()->name;
                $au->componente_id = $clasificacion->id;
                $au->modelo = 'ClasificacionAnexo';
                $au->accion = 'Se acaba de ACTUALIZAR una Clasificación de los Anexos';
                $au->descripcion = 'Se ACTUALIZO la Clasificación de un Anexo: ' . $clasificacion->nombre . ' !!!';
                $au->save();
            });
            static::created(function ($clasificacion) {
                $au = new Auditoria();
                $au->user_id = Auth::user()->id;
                $au->username = Auth::user()->name;
                $au->componente_id = $clasificacion->id;
                $au->modelo = 'ClasificacionAnexo';
                $au->accion = 'Se acaba de CREAR una Clasificación de los Anexos';
                $au->descripcion = 'Se CREO la Clasificación de un Anexo: ' . $clasificacion->nombre . ' !!!';
                $au->save();
            });
      }
}
