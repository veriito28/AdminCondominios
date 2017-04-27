<?php

namespace App;


trait IdTrait
{
    
    public function scopeId($query,$id)
    {
    	return $query->where('id',$id);
    }
}
