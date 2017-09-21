<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Casa;
use App\Usuario;
use App\Reporte;
use App\Adeudo;
use App\ConceptoAdeudo;
use App\ConceptoGasto;
use App\EloquentImageMutatorRafaelTrait;

class Condominio extends Model
{
    use IdTrait, ImagenTrait, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre','direccion','imagen'
    ];

    public function casas()
    {
    	return $this->hasMany(Casa::class,'condominio_id','id');
    }
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class,'usuarios_condominios','condominio_id','usuario_id')->withPivot('seleccionado')->withTimestamps();
    }
    
    public function conceptosAdeudos()
    {
        return $this->hasMany(ConceptoAdeudo::class);
    }
    public function conceptosGastos()
    {
        return $this->hasMany(ConceptoGasto::class);
    }
    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
  
    public function Adeudos()
    {
        return $this->hasMany(Adeudo::class);
    }
}
