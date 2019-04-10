<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use ShinobiTrait;

    protected $dates = ['last_login'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'estado','last_login', 'slug', 'name', 'estado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
      protected $hidden = [
            'password', 'remember_token',
      ];

      public static function boot() {
            parent::boot();
            static::creating(function ($data) {
               $data['estado'] = 'Activo';
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
