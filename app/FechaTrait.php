<?php

namespace App;
use DB;

trait FechaTrait
{
    public function scopeAnio($query,$anio)
    {
        return $query->where(DB::raw('YEAR('.$this->getTable().'.fecha)'),$anio);
    }
    public function scopeFecha($query,$fecha)
    {
        return $query->where(DB::raw('YEAR('.$this->getTable().'.fecha)'),$fecha->year)->where(DB::raw('MONTH('.$this->getTable().'.fecha)'),$fecha->month);
    }
    public function scopeHasta($query,$fecha)
    {
        return $query->where(DB::raw($this->getTable().'.fecha'),'<',$fecha);
    }
    public function scopeDesde($query,$fecha)
    {
        return $query->where(DB::raw($this->getTable().'.fecha'),'>',$fecha);
    }
}
