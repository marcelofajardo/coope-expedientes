<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Log extends Model
{
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
    protected $table = 'logs';
    protected $dates = ['deleted_at'];

    protected $fillable = [
      'user_id',
      'expediente_id',
      'username',
      'campo',
      'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
