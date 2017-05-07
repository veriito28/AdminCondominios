<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\PasswordUpdateRequest;
use Auth;
use App\Usuario;

class InvitadoCtrl extends Controller
{
	use AuthenticatesUsers;
    protected $redirectTo = 'usuario';

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
        $this->middleware('guest', ['except' => ['logout','cambiarContrasenia']]);
    }
	public function mostrarLogin()
	{
		return view('invitado.login');
	}
    public function cambiarContrasenia(PasswordUpdateRequest $request)
    {
        $usuario = $this->usuario->find(Auth::user()->id);
        $usuario->password = $request->new_password;
        $usuario->save();
        return redirect()->back()->with(['message'=>'Contraseña actualizada correctamente.','type'=>'success']);
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
