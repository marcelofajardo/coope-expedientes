<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Log extends Model
{
    use SoftDeletes;

	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
    protected $table = 'logs';

    protected $dates = ['deleted_at'];

    /**
     * Asignación masiva de atributos para la insecion
     *
     * @var array
     */

    protected $fillable = [
      'user_id',
      'expediente_id',
      'username',
      'campo',
      'slug'
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
    public function setCampoAttribute($val)
    {
    //	setlocale(LC_TIME, 'es_ES.UTF-8');
        $this->attributes['campo'] = trim($val);
        $this->attributes['slug'] = str_slug($val) . '-'. rand(5,100);

    }
    public function user()
    {
        return $this->belongsTo('App\User');

    }
    public function expediente()
    {
        return $this->belongsTo('App\Expediente', 'expediente_id');
    }
}
