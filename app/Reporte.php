<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\FechaTrait;
use App\Condominio;

class Reporte extends Model
{
	use IdTrait,FechaTrait,SoftDeletes;
    
    protected $dates = ['fecha','deleted_at'];
    protected $fillable = [
		'encabezado','mensaje','prosupuestado_atrazado','diferencia_autorizada', 'condominio_id', 'fecha'
    ];    
    public function condominio()
    {
    	return $this->belongsTo(Condominio::class);
    }
 
    public function scopeCondominioId($query,$id)
    {
    	return $query->where('condominio_id',$id);
    }
}
