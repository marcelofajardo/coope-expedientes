<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Auditoria extends Model
{
    use SoftDeletes;

	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
    protected $table = 'auditorias';

    protected $dates = ['deleted_at'];

    /**
     * Asignación masiva de atributos para la insecion
     *
     * @var array
     */

    protected $fillable = [
      'user_id',
      'username',
      'accion',
      'modelo',
      'componente_id',
      'descripcion',
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
    public function setDescripcionAttribute($val)
    {
    //	setlocale(LC_TIME, 'es_ES.UTF-8');
        $this->attributes['descripcion'] = trim($val);
        $this->attributes['slug'] = str_slug($val) . '-'. rand(50,1000);

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
