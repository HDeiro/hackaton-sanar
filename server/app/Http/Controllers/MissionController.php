<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use App\Models\Mission;
use App\Utils;

class MissionController extends Controller
{
    public function index() {
        $query = Mission::where(function($query) {
            if (Input::has('q') && !empty(Input::get('q'))) {
                $q = Input::get('q');
                $query->where('mission.description', 'like', '%'.$q.'%')
                    ->orWhere('mission.score', 'like', intval($q));
            }
        });

        // Count the number of occurrences in Mission table
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
        $mission = Mission::find($id);

        return [
            'success' => isset($mission),
            'data' => $mission
        ];
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
			$data = Input::except([]);

            $mission = Mission::create($data);

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
            $data = Input::except([]);
            
            Mission::find($id)->update($data);
            
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
            Mission::where('id', $id)
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
