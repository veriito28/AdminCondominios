<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\IdTrait;
use App\Gasto;

class Concepto extends Model
{
    use IdTrait;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre'
    ];
   
    public function gastos()
    {
    	return $this->hasMany(Gasto::class);
    }
}
