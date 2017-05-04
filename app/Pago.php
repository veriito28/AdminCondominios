<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Casa;
use App\Condominio;
use App\Adeudo;
use DB;

class Pago extends Model
{
    use IdTrait;
    use SoftDeletes;
    protected $dates = ['fecha','deleted_at'];
    protected $fillable = [
		'concepto', 'cantidad', 'fecha', 'tipo', 'condominio_id', 'casa_id', 'adeudo_id'
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
    public function scopeFecha($query,$fecha)
    {
        return $query->where(DB::raw('YEAR(fecha)'),$fecha->year)->where(DB::raw('MONTH(fecha)'),$fecha->month);
    }
    public function scopeHasta($query,$fecha)
    {
        return $query->where(DB::raw('fecha'),'<',$fecha);
    }
    public function scopeExtraordinarios($query)
    {
        return $query->where('tipo','E');
    }
     public function scopeAnio($query,$anio)
    {
        return $query->where(DB::raw('YEAR(fecha)'),$anio);
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
