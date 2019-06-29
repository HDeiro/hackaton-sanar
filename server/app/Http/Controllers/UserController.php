<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use App\Models\User;
use App\Utils;

class UserController extends Controller
{
    public function index() {
        $query = User::where(function($query) {
            if (Input::has('q') && !empty(Input::get('q'))) {
                $q = Input::get('q');
                $query->where('user.name', 'like', '%'.$q.'%')
                    ->orWhere('user.email', 'like', '%'.$q.'%');
            }
        });
        // Count the number of occurrences in User table
        $count = $query->count();
        // Skips / Fetch elements

        if( !Input::has('skip') && !Input::has('take')) {
            $dataset = $query->get();
        } else {
            $dataset = $query->skip(Input::get('skip', 0))
                ->take(Input::get('take', Utils::$posts_per_page))
            ->get();
        }

        return [
            'success' => true,
            'data' => $dataset,
            'count' => $count
        ];
    }
    
    public function show($id) {
        $user = User::find($id);

        return [
            'success' => isset($user),
            'data' => $user
        ];
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
			$data = Input::except([
				'roles',
            ]);

            if(Input::has('password') && ! is_null($data['password']))
                $data['password'] = bcrypt($data['password']);
            
            $user = User::create($data);

            DB::commit();
            
            return [
                'success' => true
            ];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível criar Usuário');
        }
    }

    public function update($id, Request $request) {
        DB::beginTransaction();
        try {
            $data = Input::except([
				'roles'
            ]);
            
			$hasToEditPassword = Input::has('password') && ! is_null($data['password']);
            
            $user = User::find($id);
            
            // Encrypt password if it has been sent
            if($hasToEditPassword) {
				$newPassword = $data['password'];
				$data['password'] = bcrypt($newPassword);
			}
            
            $user->update($data);
            
			if($hasToEditPassword) {
                //Send e-mail to user with new password
            }

            DB::commit();
            return [
                'success' => true
            ];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível atualizar Usuário');
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            User::where('id', $id)
                ->firstOrFail()
                ->delete();

            DB::commit();
            
            return [
				'success' => true
			];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível deletar Usuário');
        }
    }
}
