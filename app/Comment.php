<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
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
        return $this->hasMany('App\Anexo', 'anexo_id');
    }


}
