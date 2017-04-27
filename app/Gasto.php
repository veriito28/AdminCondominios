<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Concepto;

class Gasto extends Model
{
     use IdTrait;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
       'concepto', 'cantidad', 'fecha', 'tipo', 'condominio_id', 'concepto_id'
    ];
   	public function scopeOrdinarios($query)
   	{
   		return $query->where('tipo','O');
   	}
   	public function scopeExtraudinarios($query)
   	{
   		return $query->where('tipo','E');
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
