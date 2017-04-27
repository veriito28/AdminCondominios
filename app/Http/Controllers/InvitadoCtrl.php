<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class InvitadoCtrl extends Controller
{
	use AuthenticatesUsers;
    protected $redirectTo = 'usuario';

	public function mostrarLogin()
	{
		return view('invitado.login');
	}

	public function username()
    {
        return 'username';
    }
	protected function authenticated(Request $request, $user)
    {
    	foreach ($user->condominios as $condominio) {
    		if ($condominio->pivot->seleccionado) {
    			$request->session()->regenerate();
    			$request->session()->put('condominio', $condominio);
    			break;
    		}
    	}
    }

}
