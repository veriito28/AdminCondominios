<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Hash;
use Auth;
use App\ConceptoAdeudo as Concepto;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('password_valid', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::user()->password);
        });
        Validator::extend('unique_concepto', function($attribute, $value, $parameters, $validator) {
            if (Concepto::slugNombre(str_slug($value))->condominioId($parameters[0])->first()) {
                return false;
            }
            return true;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
