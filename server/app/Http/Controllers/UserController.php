<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use App\Models\User;
use App\Models\Relational\UserRole;
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

        if(!isset($user))
            return [
                'success' => false
            ];

        $user->listRoles();
        $user->calcScore();

        return [
            'success' => true,
            'data' => $user
        ];
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $roles = Input::get('roles', null);
            $data = Input::except([
				'roles',
            ]);

            if(Input::has('password') && ! is_null($data['password']))
                $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

			if(!is_null($roles)) {
				foreach($roles as $role_id) {
					UserRole::create([
						'user_id' => $user['id'],
						'role_id' => $role_id
					]);
				}
			}

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
            $roles = Input::get('roles');
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

            // If changed roles
			if(!is_null($roles)) {
                UserRole::where('user_id', $user['id'])->delete();
				foreach($roles as $role_id) {
					UserRole::create([
						'user_id' => $user['id'],
						'role_id' => $role_id
					]);
				}
			}

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
            UserRole::where('user_id', $id)->delete();
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
