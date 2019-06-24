<?php

namespace App;
use Carbon\Carbon;
use App\Log;
use App\Auditoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Expediente extends Model
{

      use SoftDeletes;
      use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
      protected $table = 'expediente';

      protected $dates = ['deleted_at'];

      protected $softCascade = ['anexos', 'expUsuarios']; //indica la relación posts()

      protected $fillable = [
            'fecha',
            'caratula',
            'name',
            'rol_usuario',
            'slug',
            'user_id',
            'numero',
            'foja',
            'nombre',
            'tipo_expediente_id'
      ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
      public function getRouteKeyName()
      {
            return 'slug';
      }

    /**
     * Normaliza y setea el nombre y el slug del Articulo
     *
     * @param $val
     */
      public function setCaratulaAttribute($val)
      {
            //	setlocale(LC_TIME, 'es_ES.UTF-8');
            $this->attributes['caratula'] = trim($val);
      }

      public function setFechaAttribute($val)
      {
            $this->attributes['fecha'] = \Carbon\Carbon::parse($val)->format('Y-m-d');
      }

      public function getFechaAttribute($val)
      {
          return \Carbon\Carbon::parse($val)->format('d-m-Y');
      }

      public function user()
      {
            return $this->belongsTo('App\User');
      }
      public function expUsuarios()
      {
            return $this->hasMany('App\ExpedienteUsuarios');
      }

      public function anexos()
      {
            return $this->hasMany('App\Anexo');
      }
      public function logs()
      {
            return $this->hasMany('App\Log');
      }

      public function tipoexpediente()
      {
            return $this->belongsTo('App\TipoExpediente', 'tipo_expediente_id');
      }

      public static function boot() {
            parent::boot();
            static::creating(function ($data) {
               $data['user_id'] = Auth::user()->id;
               $data['name'] = Auth::user()->name;
               $data['rol_usuario'] = Auth::user()->roles[0]->name;
               return $data;
            });
      }
}
