<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\IdTrait;
use App\Condominio;

class Usuario extends Authenticatable
{
    use Notifiable;
    use IdTrait;

    protected $fillable = [
        'nombre', 'username', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function condominios()
    {
    	return $this->belongsToMany(Condominio::class,'usuarios_condominios','usuario_id','condominio_id')->withPivot('seleccionado')->withTimestamps();
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
