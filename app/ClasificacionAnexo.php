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
            static::creating(function ($data) {
            });
            static::updating(function($data)
            {
            });
            static::deleting(function($clasificacion)
            {
                  $control = new Auditoria();
                  $control->user_id = Auth::user()->id;
                  $control->username = Auth::user()->name;
                  $control->accion = 'Borrar';
                  $control->descripcion = 'Se borro la Clasificación de un Anexo: ' . $clasificacion->nombre . ' !!!';
                  $control->slug = str_slug(rand(40,1000) . '-' . $clasificacion->nombre);
                  $control->save();
            });
            static::updated(function($data) {
            });
            static::created(function ($data) {
            });
      }
}
