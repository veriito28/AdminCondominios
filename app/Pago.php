<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Casa;
use DB;
class Pago extends Model
{
    use IdTrait;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
		'concepto', 'cantidad', 'fecha', 'tipo', 'condominio_id', 'casa_id', 'adeudo_id'
    ];
    public function condominio()
    {
    	return $this->belongsTo(Condominio::class,'condominio_id','id');
    }
    public function scopeMensuales($query)
    {
        return $query->where('tipo','M');
    }
    public function scopeExtraudinarios($query)
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
}


 // public function scopeEnero($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'1');
 //    }
 //    public function scopeFebrero($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'2');
 //    }
 //    public function scopeMarzo($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'3');
 //    }
 //    public function scopeAbril($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'4');
 //    }
 //    public function scopeMayo($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'5');
 //    }
 //    public function scopeJunio($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'6');
 //    }
 //    public function scopeJulio($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'7');
 //    }
 //    public function scopeAgosto($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'8');
 //    }
 //    public function scopeSeptiembre($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'9');
 //    }
 //    public function scopeOctubre($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'10');
 //    }
 //    public function scopeNoviembre($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'11');
 //    }
 //    public function scopeDiciembre($query)
 //    {
 //        return $query->where(DB::raw('MONTH(fecha)'),'12');
 //    }
