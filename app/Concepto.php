<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Adeudo;
use App\Gasto;
use App\Condominio;
use App\SlugNombreTrait;

class Concepto extends Model
{
    use IdTrait, SoftDeletes, SlugNombreTrait;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre','tipo','condominio_id','slug_nombre'
    ];
   
    public function gastos()
    {
    	return $this->hasMany(Gasto::class);
    }
   
    public function scopeTipoMensuales($query)
    {
        return $query->where('tipo','A');
    }

    public function scopeTipoAdeudo($query)
    {
        return $query->where('tipo','A');
    }

    public function scopeTipoGastos($query)
    {
        return $query->where('tipo','G');
    }
  
    public function scopeCondominioId($query,$condominio_id)
    {
        return $query->where('condominio_id',$condominio_id);
    }
    public function aduedos()
    {
        return $this->hasMany(Aduedo::class);
    }
   
    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

}
