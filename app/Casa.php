<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Condominio;
use App\Pago;

class Casa extends Model
{
    use IdTrait;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'no_cliente','nombre', 'contacto','email','telefono','celular','password','condominio_id','manzana','lote','fecha_esc','interfon'
    ];
    public function condominio()
    {
    	return $this->belongsTo(Condominio::class,'condominio_id','id');
    }
   
    public function pagos()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = casa_id, localKey = id)
        return $this->hasMany(Pago::class);
    }
}
