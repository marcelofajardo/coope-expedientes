<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notificacion extends Model
{


	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
    protected $table = 'notificaciones';

    protected $dates = ['fecha_vto'];

    /**
     * Asignación masiva de atributos para la insecion
     *
     * @var array
     */
    protected $fillable = [
          'nombre',
          'descripcion',
          'slug',
          'user_id',
          'user_generate_id',
          'expediente_id',
          'anexo_id',
          'anexo_providencia',
          'fecha_vto',
          'leida'
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
    public function setNombreAttribute($val)
    {
    //	setlocale(LC_TIME, 'es_ES.UTF-8');
        $this->attributes['nombre'] = strtolower(trim($val));
        $this->attributes['slug'] = str_slug($val) . '-'. rand(5,100);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function user_generate()
    {
        return $this->belongsTo('App\User', 'user_generate_id');
    }

      public static function boot() {
            parent::boot();
            static::creating(function ($data) {
                  $data['user_generate_id'] = Auth::user()->id;
                  $data['leida'] = 'NO';
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




}
