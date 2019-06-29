<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use JWTAuth;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Utils;
use App\Models\Usuario;

class AuthController extends Controller {

    public function login() {
        $credentials = Input::all();

        if(!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $user = Usuario::where(['username' => $credentials['email']])
                ->select('email')
                ->first();

            if(isset($user))
                $credentials['email'] = $user['email'];
		}

		$user = Usuario::where(['email' => $credentials['email']])
			->select('is_active')
			->first();

		if($user['is_active'] == 0) {
			return response()->json([
				'success' => false,
				'error' => 'Não é possível acessar o sistema com um usuário inativo'
			], 401);
		}

        try {
            if ( !$token = JWTAuth::attempt($credentials))
                return response()->json([
                    'success' => false,
                    'error' => 'Usuário e/ou senha inválidos'
                ], 401);
        } catch (\Exception $ex) {
            return Utils::treatException($ex, 'Não foi possível realizar login no momento');
        }

        $user = auth()->user();

        return [
            'success' => true,
            'data' => $user,
            'token' => $token
        ];
    }

    public function refresh () {
        try {
            return response()->json([
                'success' => true,
                'token' => JWTAuth::parseToken()->refresh()
            ]);
        } catch (JWTException $ex) {
            return Utils::treatException($ex);
        }
    }

    public function logout() {
        try {
            $sucessLogout = JWTAuth::parseToken()->invalidate();

            if(!$sucessLogout)
                throw new \Exception('Não foi possível fazer logout agora', 500);

            return response()->json([
                'success' => $sucessLogout,
                'msg' => 'Logout efetuado com sucesso'
            ]);
        } catch (JWTException $ex) {
            return Utils::treatException($ex, 'Não foi possível fazer logout agora');
        }
    }

    public function recoverPassword() {
        try {
            $user = Usuario::where('email', Input::get('email'))->first();

            // Found Usuario
            if(isset($user)) {
                $newPassword = Utils::random();
                $user->update(['password' => bcrypt($newPassword)]);
                Utils::mail(
                    $user['email'],
                    'Recuperação de Senha',
                    'Olá, ' . $user->getFirstName() .
                        ',<br/><br/>Foi solicitada uma mudança de senha para a sua conta.' .
                        ' Você poderá acessar o sistema utilizando a senha <b>'. $newPassword . '</b>.'.
                        '<br/><br/>Você poderá alterar sua senha depois.'
                );

                return response()->json([
                    'success' => true,
                    'msg' => $user->getFirstName() . ', sua nova senha foi encaminhada para seu e-mail'
                ]);
            }

            return response()->json([
                'success' => false,
                'msg' => 'O e-mail informado não existe'
            ]);
        } catch(\Exception $ex) {
            return Utils::treatException(
                $ex,
                'Não foi possível recuperar sua senha agora'
            );
        }
    }

    public function authenticate() {
        try {
            return response()->json([
                'success' => true,
                'user' => JWTAuth::parseToken()->authenticate()
            ]);
        } catch (JWTException $ex) {
            return Utils::treatException($ex, $token);
        }
    }

    private function getToken() {
        return str_replace("Bearer ", "", Request::header('Authorization'));
    }
}
