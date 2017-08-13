<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\FechaTrait;
use App\Casa;
use App\Condominio;
use App\Adeudo;
use DB;

class Pago extends Model
{
    use IdTrait, FechaTrait, SoftDeletes;

    protected $dates = ['fecha','fecha_pago','deleted_at'];

    protected $fillable = [
		'concepto', 'cantidad', 'fecha', 'tipo', 'condominio_id', 'casa_id', 'adeudo_id','fecha_pago'
    ];
   
    public function scopeMensuales($query)
    {
        return $query->where('tipo','M');
    }
    public function scopeOtros($query)
    {
        return $query->where('tipo','O');
    }
     public function scopeNormales($query)
    {
        return $query->where('concepto','mensualidad');
    }
     public function scopeAtrasadas($query)
    {
        return $query->where('concepto','atradasas');
    }
    public function scopeAdelantadas($query)
    {
        return $query->where('concepto','adelantadas');
    }
    public function scopeCasaId($query,$id)
    {
        return $query->where('casa_id',$id);
    }
    public function scopeExtraordinarios($query)
    {
        return $query->where('tipo','E');
    }

    public function scopeCondominioId($query,$id)
    {
        return $query->where('condominio_id',$id);
    }
    public function casa()
    {
        return $this->belongsTo(Casa::class);
    }
    public function condominio()
    {
        return $this->belongsTo(Condominio::class,'condominio_id','id');
    }
    public function adeudo()
    {
        return $this->belongsTo(Adeudo::class);
    }
    public function adeudos()
    {
        return $this->hasMany(Adeudo::class,'fecha','fecha');
    }
}
