<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Adeudo;
use App\Condominio;
use App\SlugNombreTrait;

class ConceptoAdeudo extends Model
{
    use IdTrait, SoftDeletes, SlugNombreTrait;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre','tipo','deudor','condominio_id','slug_nombre'
    ];
   
    public function scopeTipoMensuales($query)
    {
        return $query->where('tipo','M');
    }
    public function scopeTipoFijos($query)
    {
        return $query->where('tipo','F');
    }

    public function scopePersonal($query)
    {
        return $query->where('deudor','P');
    }

    public function scopeGlobal($query)
    {
        return $query->where('deudor','G');
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
