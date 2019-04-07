<?php

namespace App;
use Carbon\Carbon;
use App\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class Expediente extends Model
{
	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
    protected $table = 'expediente';

    protected $dates = ['fecha'];

    protected $fillable = [
      'fecha',
      'caratula',
      'name',
      'rol_usuario',
      'slug',
      'user_id',
      'archivado',
      'numero',
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
      $this->attributes['fecha'] = Carbon::parse($val)->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo('App\User');

    }
    public function expUsuarios()
    {
        return $this->hasMany('App\ExpedienteUsuarios');

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
          static::updating(function($data)
          {
          });
          static::updated(function($data) {
          });
          static::created(function ($data) {
          });
    }


/*
    public static function boot(){
        parent::boot();
        static::updating(function($expediente)
        {

            foreach ($expediente->getDirty() as $key => $value) {
              if ($key != 'slug')
              {
                $control = new Log();
                $control->user_id = Auth::user()->id;
                $control->username = Auth::user()->username;
                $control->expediente_id = $expediente->id;
                $control->campo = $key;
                $control->valor_anterior = $expediente->getOriginal($key);
                $control->valor_nuevo = $value;
                $control->save();
              }
            }
        });
    }
    */
}
