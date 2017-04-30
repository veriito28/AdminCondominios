<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Condominio;
use App\Casa;
use DB;

class Adeudo extends Model
{
 	use IdTrait;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
       'concepto', 'cantidad', 'fecha', 'tipo', 'condominio_id', 'casa_id'
    ];
   	public function scopeMensualidades($query)
   	{
   		return $query->where('tipo','M');
   	}
   	public function scopeOtros($query)
   	{
   		return $query->where('tipo','O');
   	}
    public function scopeAnio($query,$anio)
    {
        return $query->where(DB::raw('YEAR(fecha)'),$anio);
    }
    public function scopeCondominioId($query,$id)
    {
        return $query->where('condominio_id',$id);
    }
    public function scopeCasaId($query,$id)
    {
        return $query->where('casa_id',$id);
    }

    public function condominio()
    {
    	return $this->belongsTo(Condominio::class);
    }
   
    public function casa()
    {
    	return $this->belongsTo(Casa::class);
    }
}
