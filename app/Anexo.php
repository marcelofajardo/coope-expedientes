<?php

namespace App;
use Carbon\Carbon;
//use App\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Anexo extends Model
{

      use SoftDeletes;
      use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
	/**
     * Setea la Tabla a la que pertenece el modelo
     *
     * @var string
     */
    protected $table = 'anexo';
    protected $dates = ['deleted_at'];
    protected $softCascade = ['comments']; //indica la relación posts()

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


      public function getRouteKeyName()
      {
            return 'slug';
      }

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

      public static function boot() {
            parent::boot();
            static::addGlobalScope('user_id', function ($query) {
                  //return $query->where('provincia_id', Auth::user()->provincia_id);
            });
            static::creating(function ($anexo) {
                  //return $localidad->provincia_id = Auth::user()->provincia_id;
            });
            static::updating(function($anexo) {

            });
            static::updated(function($anexo) {
            });
            static::created(function ($anexo) {
            });
      }



}
