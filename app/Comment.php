<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'parent_id', 'post_id', 'user_id',
    ];

    public function anexo()
    {
        return $this->belongsTo('App\Anexo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function parent()
    {
        return $this->belongsTo('App\Comment', 'parent_id');
    }
    public function newCollection(array $models = [])
    {
        return new CommentCollection($models);
    }

    public function replies()
    {
        return $this->hasMany('App\Comment', 'parent_id');
    }
}
