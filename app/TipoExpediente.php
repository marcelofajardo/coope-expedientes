<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipoExpediente;
use Illuminate\Support\Facades\Auth;

class TipoExpediente extends Model
{

    protected $table = 'tipoexpediente';

    protected $fillable = ['nombre', 'letra', 'slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getNombreAndLetraAttribute()
    {
        return $this->letra . ' - ' . $this->nombre;
    }
 
    public function setNombreAttribute($val)
    {
    //	setlocale(LC_TIME, 'es_ES.UTF-8');
        $this->attributes['nombre'] = strtolower(trim($val));
        $this->attributes['slug'] = str_slug($val);
    }

    public function user()
    {
        return $this->hasMany('App\Expediente');
    }

    public static function boot() {
          parent::boot();
          static::creating(function ($clasificacion) {

          });
          static::updating(function($data)
          {
          });
          static::deleted(function($tipoExpediente)
          {
              $au = new Auditoria();
              $au->user_id = Auth::user()->id;
              $au->username = Auth::user()->name;
              $au->componente_id = $tipoExpediente->id;
              $au->modelo = 'TipoExpediente';
              $au->accion = 'Se acaba de Borrar un Tipo de Expediente';
              $au->descripcion = 'Se borro un Tipo de Expediente: ' . $tipoExpediente->nombre . ' !!!';
              $au->save();
          });
          static::updated(function($tipoExpediente) {
              $au = new Auditoria();
              $au->user_id = Auth::user()->id;
              $au->username = Auth::user()->name;
              $au->componente_id = $tipoExpediente->id;
              $au->modelo = 'TipoExpediente';
              $au->accion = 'Se acaba de ACTUALIZAR un Tipo de Expediente';
              $au->descripcion = 'Se ACTUALIZO un Tipo de Expediente: ' . $tipoExpediente->nombre . ' !!!';
              $au->save();
          });
          static::created(function ($tipoExpediente) {
              $au = new Auditoria();
              $au->user_id = Auth::user()->id;
              $au->username = Auth::user()->name;
              $au->componente_id = $tipoExpediente->id;
              $au->modelo = 'TipoExpediente';
              $au->accion = 'Se acaba de CREAR un Tipo de Expediente';
              $au->descripcion = 'Se CREO un Tipo de Expediente: ' . $tipoExpediente->nombre . ' !!!';
              $au->save();
          });
    }
}
