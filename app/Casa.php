<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Condominio;
use App\Pago;
use App\Aduedo;
use DB;
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
   
    public function scopeCondominioId($query,$condominio_id)
    {
        return $query->where('condominio_id',$condominio_id);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
    
    public function adeudos()
    {
        return $this->hasMany(Aduedo::class);
    }

    public function scopeAdeudosHasta($query,$fecha)
    {
      return $query->join('condominios','condominios.id','casas.condominio_id')
                   ->join('adeudos','condominios.id','adeudos.condominio_id')
                   ->join('concepto_adeudos','adeudos.concepto_id','concepto_adeudos.id')
                   ->where('casas.id',$this->id)
                   ->where(function($query) use ($fecha){
                        $query->where(function($query) use ($fecha){
                            $query->where('adeudos.tipo','M')
                           ->where(DB::raw('YEAR(adeudos.fecha)'),'<=',$fecha->year)
                           ->where(DB::raw('MONTH(adeudos.fecha)'),'<=',$fecha->month);    
                        })
                        ->orWhere(function($query){
                            $query->where('adeudos.tipo','O')
                           ->where(function($query){
                                $query->where(function($query){
                                    $query->where('concepto_adeudos.deudor','P')
                                    ->where('adeudos.casa_id',DB::raw('casas.id'));
                                })
                                ->orWhere('concepto_adeudos.deudor','G');
                            });
                        });
                   })
                   ->groupBy('casas.id')
                  ->select(DB::raw('casas.id AS casa_id'), DB::raw('sum(IFNULL(adeudos.cantidad,0)) as adeudado'));
    }
    public function scopePagadoHasta($query,$fecha)
    {
      return $query->join('pagos','casas.id','pagos.casa_id')
                   ->where('casas.id',$this->id)
                   ->where(DB::raw('YEAR(pagos.fecha)'),'<=',$fecha->year)
                   ->where(DB::raw('MONTH(pagos.fecha)'),'<=',$fecha->month)    
                   ->groupBy('casas.id')
                  ->select(DB::raw('casas.id AS casa_id'), DB::raw('sum(IFNULL(pagos.cantidad,0)) as pagado'));
    }

    public function scopePagoDe($query,$fecha)
    {
      return $query->join('pagos','casas.id','pagos.casa_id')
                   ->where('casas.id',$this->id)
                   ->where('pagos.tipo','M')
                   ->where(DB::raw('YEAR(pagos.fecha)'),'=',$fecha->year)
                   ->where(DB::raw('MONTH(pagos.fecha)'),'=',$fecha->month);   
    }
    
}
