<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Usuario;

class Cuenta extends Model
{
    use IdTrait, ImagenTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'imagen','mensaje','usuario_id'
    ];
	public function scopeUsuarioId($query,$usuario_id)
	{
		return $query->where('usuario_id',$usuario_id);
	}
	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}
}
