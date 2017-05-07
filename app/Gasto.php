<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\FechaTrait;
use App\Concepto;
use DB;
class Gasto extends Model
{
    use IdTrait,FechaTrait,SoftDeletes;
  
    protected $dates = ['fecha','deleted_at'];

    protected $fillable = [
       'concepto', 'cantidad', 'fecha', 'tipo', 'condominio_id', 'concepto_id'
    ];
   	public function scopeOrdinarios($query)
   	{
   		return $query->where('tipo','O');
   	}
   	public function scopeExtraordinarios($query)
   	{
   		return $query->where('tipo','E');
   	}
  

    public function scopeCondominioId($query,$id)
    {
        return $query->where('condominio_id',$id);
    }
    public function condominio()
    {
    	return $this->belongsTo(Condominio::class);
    }
    public function concepto()
    {
    	return $this->belongsTo(Concepto::class);
    }
}
