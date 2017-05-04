<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Condominio;
use App\Casa;
use App\Pago;
use DB;

class Adeudo extends Model
{
 	use IdTrait;
    use SoftDeletes;
    protected $dates = ['fecha','deleted_at'];

    protected $fillable = [
       'concepto', 'cantidad', 'fecha', 'tipo', 'condominio_id', 'casa_id'
    ];
   	public function scopeMensualidades($query)
   	{
   		return $query->where('adeudos.tipo','M');
   	}
   	public function scopeOtros($query)
   	{
   		return $query->where('adeudos.tipo','O');
   	}
    public function scopeAnio($query,$anio)
    {
        return $query->where(DB::raw('YEAR(adeudos.fecha)'),$anio);
    }
    public function scopeFecha($query,$fecha)
    {
        return $query->where(DB::raw('YEAR(adeudos.fecha)'),$fecha->year)->where(DB::raw('MONTH(adeudos.fecha)'),$fecha->month);
    }
    public function scopeCondominioId($query,$id)
    {
        return $query->where('adeudos.condominio_id',$id);
    }
    public function scopeCasaId($query,$id)
    {
        return $query->where('adeudos.casa_id',$id);
    }
    public function scopeCasaHasta($query,$casa_id,$fecha)
    {
      return $query->join('condominios','condominios.id','adeudos.condominio_id')
                   ->join('casas','condominios.id','casas.condominio_id')
                   ->where('casas.id',$casa_id)
                   ->leftJoin('pagos',function($join) use ($fecha,$casa_id){
                        $join->on('pagos.adeudo_id', '=', 'adeudos.id');
                        $join->on('pagos.casa_id', '=', DB::raw( $casa_id));
                        $join->on(DB::raw('YEAR(pagos.fecha)'),'<=',DB::raw($fecha->year));
                        $join->on(DB::raw('MONTH(pagos.fecha)'),'<', DB::raw($fecha->month));
                    })
                   ->where(function($query) use ($casa_id){
                        $query->where('adeudos.tipo','M')
                        ->orWhere(function($query) use ($casa_id){
                            $query->where('adeudos.tipo','O')->where('adeudos.casa_id',$casa_id);
                        });
                   })
                  ->where(DB::raw('YEAR(adeudos.fecha)'),'<=',$fecha->year)
                  ->where(DB::raw('MONTH(adeudos.fecha)'),'<',$fecha->month)
                  ->groupBy('adeudos.id','casas.id','adeudos.concepto', 'adeudos.cantidad', 'adeudos.fecha', 'adeudos.tipo', 'adeudos.condominio_id')
                  ->select('adeudos.id',DB::raw('casas.id AS casa_id'),'adeudos.concepto', 'adeudos.cantidad', 'adeudos.fecha', 'adeudos.tipo', 'adeudos.condominio_id',DB::raw('sum(IFNULL(pagos.cantidad,0)) as pagado'),DB::raw('(adeudos.cantidad - IFNULL(sum(pagos.cantidad),0)) as adeudado'));
    }
    public function scopeCasaDelMes($query,$casa_id,$fecha){
      return $query->join('condominios','condominios.id','adeudos.condominio_id')
                   ->join('casas','condominios.id','casas.condominio_id')
                   ->where('casas.id',$casa_id)
                   ->leftJoin('pagos',function($join) use ($fecha,$casa_id){
                        $join->on('pagos.adeudo_id', '=', 'adeudos.id');
                        $join->on('pagos.casa_id', '=', DB::raw( $casa_id));
                        $join->on(DB::raw('YEAR(pagos.fecha)'),'=',DB::raw( $fecha->year));
                        $join->on(DB::raw('MONTH(pagos.fecha)'),'=', DB::raw($fecha->month));
                    })
                   ->where(function($query) use ($casa_id){
                        $query->where('adeudos.tipo','M')
                        ->orWhere(function($query) use ($casa_id){
                            $query->where('adeudos.tipo','O')->where('adeudos.casa_id',$casa_id);
                        });
                   })
                  ->where(DB::raw('YEAR(adeudos.fecha)'),'=',$fecha->year)
                  ->where(DB::raw('MONTH(adeudos.fecha)'),'=',$fecha->month)
                  ->groupBy('adeudos.id','casas.id','adeudos.concepto', 'adeudos.cantidad', 'adeudos.fecha', 'adeudos.tipo', 'adeudos.condominio_id')
                  ->select('adeudos.id',DB::raw('casas.id AS casa_id'),'adeudos.concepto', 'adeudos.cantidad', 'adeudos.fecha', 'adeudos.tipo', 'adeudos.condominio_id',DB::raw('sum(IFNULL(pagos.cantidad,0)) as pagado'),DB::raw('(adeudos.cantidad - IFNULL(sum(pagos.cantidad),0)) as adeudado'));
    }
     public function scopeCasaTodos($query,$casa_id){
      return $query->join('condominios','condominios.id','adeudos.condominio_id')
                   ->join('casas','condominios.id','casas.condominio_id')
                   ->where('casas.id',$casa_id)
                   ->leftJoin('pagos',function($join) use ($casa_id){
                        $join->on('pagos.adeudo_id', '=', 'adeudos.id');
                        $join->on('pagos.casa_id', '=', DB::raw($casa_id));
                    })
                   ->where(function($query) use ($casa_id){
                        $query->where('adeudos.tipo','M')
                        ->orWhere(function($query) use ($casa_id){
                            $query->where('adeudos.tipo','O')->where('adeudos.casa_id',$casa_id);
                        });
                   })
                  ->groupBy('adeudos.id','casas.id','adeudos.concepto', 'adeudos.cantidad', 'adeudos.fecha', 'adeudos.tipo', 'adeudos.condominio_id')
                  ->select('adeudos.id',DB::raw('casas.id AS casa_id'),'adeudos.concepto', 'adeudos.cantidad', 'adeudos.fecha', 'adeudos.tipo', 'adeudos.condominio_id',DB::raw('sum(IFNULL(pagos.cantidad,0)) as pagado'),DB::raw('(adeudos.cantidad - IFNULL(sum(pagos.cantidad),0)) as adeudado'));
    }

    public function condominio()
    {
    	return $this->belongsTo(Condominio::class);
    }
   
    public function casa()
    {
    	return $this->belongsTo(Casa::class);
    }
    public function pagos()
    {
      return $this->hasMany(Pago::class);
    }
}
