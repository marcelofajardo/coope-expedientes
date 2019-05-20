<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  /**
 * Setea la Tabla a la que pertenece el modelo
 *
 * @var string
 */
    protected $table = 'profile';
    protected $dates = ['deleted_at'];

    protected $fillable = [
      'user_id',
      'avatar',
      'apellido',
      'nombre',
      'telefono',
      'slug',
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
      public function setApellidoAttribute($val)
      {
            //	setlocale(LC_TIME, 'es_ES.UTF-8');
            $this->attributes['apellido'] = trim($val);
            //$this->attributes['slug'] = str_slug($val) . '-'. rand(5,10);
      }
      public function user()
      {
            return $this->belongsTo('App\User');
      }

      public static function boot() {
            parent::boot();
            static::updated(function ($data) {
                  

            });
      }

}
