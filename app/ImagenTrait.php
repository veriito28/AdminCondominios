<?php

namespace App;
use Storage;

trait ImagenTrait
{    
	public function setImagenAttribute($imagen)
	{
		if (is_string($imagen)) {
			if (filter_var($imagen, FILTER_VALIDATE_URL)) {
				$this->attributes['imagen'] = $imagen;
			}
			return;
		}
		if (is_file($imagen)) {
			$nombre = $imagen->getClientOriginalName();
			// $extension = strtolower($imagen->getClientOriginalExtension());
			$filename = date('Y-m-d-h-i-s').".".$nombre;           
			$newImagen = $this->getTable().'/'.$filename; 
			Storage::disk('public')->put($newImagen,\File::get($imagen));		
			$this->attributes['imagen'] = $newImagen;
		}
		return;
	}
	public function getImagenAttribute($imagen)
	{
		if (filter_var($imagen, FILTER_VALIDATE_URL)) {
			return $this->attributes['imagen'];
		}
		return asset('storage/'.urldecode($this->attributes['imagen'])); 
	}	
	public function getImagenUrlAttribute($imagen)
	{
		if (filter_var($imagen, FILTER_VALIDATE_URL)) {
			return $this->attributes['imagen'];
		}
		return base_path('public/storage/'.urldecode($this->attributes['imagen'])); 
	}	
	
}
