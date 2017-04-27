<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Casa;
use App\Usuario;

class Condominio extends Model
{
    use IdTrait;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre'
    ];
    public function casas()
    {
    	return $this->hasMany(Casa::class,'condominio_id','id');
    }
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class,'usuarios_condominios','condominio_id','usuario_id')->withPivot('seleccionado')->withTimestamps();
    }
}
