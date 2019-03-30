<?php

namespace App;
use Carbon\Carbon;
//use App\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Anexo extends Model
{
	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
    protected $table = 'anexo';

    protected $dates = ['fecha_vto'];

    /**
     * Asignación masiva de atributos para la insecion
     *
     * @var array
     */

    protected $fillable = [
      'expediente_id',
      'clasificacion_id',
      'username',
      'descripcion',
      'slug',
      'user_id',
      'url',
      'file',
      'fecha_vto',
      'anexo_providencia',
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

    public function setFileAttribute($val)
    {
    //	setlocale(LC_TIME, 'es_ES.UTF-8');
        $this->attributes['file'] = trim($val);
        $this->attributes['slug'] = str_slug($val) . '-'. rand(5,10);

    }

    public function user()
    {
        return $this->belongsTo('App\User');

    }
    public function comments()
    {
        return $this->hasMany('App\Comment');

    }
    public function expediente()
    {
        return $this->belongsTo('App\Expediente', 'expediente_id');
    }

    public function clasificacion()
    {
        return $this->belongsTo('App\ClasificacionAnexo', 'clasificacion_id');
    }

}
