<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Gasto;
use App\Condominio;
use App\SlugNombreTrait;

class ConceptoGasto extends Model
{
    use IdTrait, SoftDeletes, SlugNombreTrait;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre','tipo','condominio_id','slug_nombre'
    ];
   
    public function scopeGlobal($query)
    {
        return $query->where('tipo','A');
    }

    public function scopeCondominio($query)
    {
        return $query->where('tipo','A');
    }
    public function scopeMisConceptos($query,$condominio_id)
    {
        return $query->where('tipo','A')->orWhere('condominio_id',$condominio_id);
    }
  
    public function scopeCondominioId($query,$condominio_id)
    {
        return $query->where('condominio_id',$condominio_id);
    }

    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }
   	
   	public function gastos()
    {
    	return $this->hasMany(Gasto::class);
    }
}
