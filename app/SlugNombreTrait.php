<?php

namespace App;


trait SlugNombreTrait
{
	public function scopeSlugNombre($query,$slug_nombre)
	{
		return $query->where('slug_nombre',$slug_nombre);
	}
	public function setNombreAttribute($value)
	{
		$this->attributes['nombre'] = $value;
		return parent::setAttribute('slug_nombre', str_slug($value));
	}

}
