<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

      use SoftDeletes;
      protected $dates = ['deleted_at'];

    protected $fillable = [
      'description',
	'anexo_id',
	'user_id',
      'username'
    ];


    public function getSinceAttribute()
    {
          return $this->created_at->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo('App\User');

    }
    public function anexo()
    {
        return $this->belongsTo('App\Anexo');
    }
    public static function boot() {
          parent::boot();
          static::deleting(function ($comment) {
              return $comment->user_id = Auth::user()->id;
          });
          static::creating(function ($data) {
              //  $data['user_generate_id'] = Auth::user()->id;
              //  $data['leida'] = 'NO';
              //  return $data;
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
